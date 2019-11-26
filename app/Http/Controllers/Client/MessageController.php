<?php

namespace App\Http\Controllers\Client;

use App\Enums\NotificationTypeEnum;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\FreeMarNotification;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


class MessageController extends ObjectController
{
    public function getMessage()
    {
        $product_id = Input::get('product_id');
        $order_id = Input::get('order_id');
        $page = Input::get('page') ?? 1;
        $page_size = Input::get('page_size') ?? config('freemar.page_size_default');
        if ($product_id != null)
            DB::table('products')->where('id', '=', $product_id)->increment('views');
        $result = DB::select('SELECT users.avatar,users.id as user_id,users.name,users.introduction,
                                           message.content,message.created_at,message.id as message_id,
                                           (SELECT COUNT(product_id) FROM product_comment GROUP BY product_id HAVING product_id = ?) as total
                                    FROM product_comment
                                    INNER JOIN message ON message.id = product_comment.message_id
                                    LEFT JOIN users ON users.id = message.sender_id
                                    WHERE product_id = ? ORDER BY message.created_at DESC LIMIT ?,?',
            [$product_id, $product_id, ($page - 1) * $page_size, $page_size]);
        if ($order_id != null)
            $result = DB::select('SELECT users.avatar,users.id as user_id,users.name,users.introduction,
                                           message.content,message.created_at,message.id as message_id,
                                           (SELECT COUNT(order_id) FROM order_chat GROUP BY order_id HAVING order_id = ?) as total
                                    FROM order_chat 
                                    INNER JOIN message ON message.id = order_chat.message_id 
                                    LEFT JOIN users ON users.id = message.sender_id
                                    WHERE order_id = ? ORDER BY message.created_at DESC LIMIT ?,?',
                [$order_id, $order_id, ($page - 1) * $page_size, $page_size]);
        $total = $result[0]->total ?? 0;
        $result = collect($result)->map(function ($data) {
            return [
                'id' => $data->message_id,
                'datetime' => $data->created_at,
                'content' => $data->content,
                'sender' => [
                    'id' => $data->user_id,
                    'name' => $data->name,
                    'introduction' => $data->introduction,
                    'avatar' => $data->avatar,

                ]
            ];
        });
        return response([
            'data' => $result,
            'current_page' => (int)$page,
            'per_page' => (int)$page_size,
            'to' => count($result),
            'total' => (int)$total
        ]);
    }

    public function setMessage()
    {
        $message = Input::get('message');
        $content = $message['content'];
        $datetime = date_create()->format('Y-m-d H:i:s');
        $sender_id = $message['sender_id'];
        $product_id = Input::get('product_id');
        $order_id = Input::get('order_id');

        try {
            /// get user
            $array_user_id = array();

            if ($product_id != null) {
                $res = DB::select('SELECT sender_id FROM message 
                                         WHERE id IN (SELECT message_id FROM product_comment WHERE product_id = ?) 
                                               AND sender_id != ? 
                                               AND sender_id NOT IN (SELECT id FROM users WHERE notify_product_comment = true)
                                         GROUP BY sender_id', [$product_id, $sender_id]);
                $owner_id = DB::table('products')->select('owner_id','name')->where('id', '=', $product_id)->first();
                foreach ($res as $value) {
                    array_push($array_user_id, $value->sender_id);
                }
                if (!in_array($owner_id->owner_id, $array_user_id) && $owner_id->owner_id != $sender_id) {
                    array_push($array_user_id, $owner_id->owner_id);
                }
                /// insert database
                $message_id = DB::table('message')->insertGetId([
                    'content' => $content,
                    'created_at' => $datetime,
                    'sender_id' => $sender_id
                ]);
                DB::table('product_comment')->insert([
                    'product_id' => $product_id,
                    'message_id' => $message_id
                ]);

                $sender = DB::select('SELECT id,name,introduction,avatar FROM users where id=?', [$sender_id]);

                /// send notification
                $notification = new FreeMarNotification();
                $notification->title = "Bình luận";
                $notification->body = $sender[0]->name . " đã bình luận trong sản phẩm " . $owner_id->name;
                $type = NotificationTypeEnum::PRODUCT_COMMENT;
                $data_type = [
                    "message" => [
                        'id' => $message_id,
                        'datetime' => $datetime,
                        'content' => $content,
                        'sender' => $sender[0]
                    ],
                    "product_id" => $product_id
                ];

                $notification->sendNotification($array_user_id, $type, json_encode($data_type), false, "/productdetal");
            }
            elseif ($order_id != null) {

                /// insert database
                $message_id = DB::table('message')->insertGetId([
                    'content' => $content,
                    'created_at' => $datetime,
                    'sender_id' => $sender_id
                ]);
                DB::table('order_chat')->insert([
                    'order_id' => $order_id,
                    'message_id' => $message_id
                ]);

                $sender = DB::select('SELECT id,name,introduction,avatar FROM users where id=?', [$sender_id]);

                $order = DB::select('SELECT product_id,buyer_id,owner_id 
                                           FROM products,orders 
                                           WHERE orders.id = ? AND products.id = orders.product_id', [$order_id])[0];

                if ($sender_id == $order->owner_id &&
                    !DB::table('users')->select('notify_order_chat')->where('id', '=', $order->buyer_id)->first()->notify_order_chat)
                    array_push($array_user_id, $order->buyer_id);
                else
                    if (!DB::table('users')->select('notify_order_chat')->where('id', '=', $order->owner_id)->first()->notify_order_chat)
                    {

                        array_push($array_user_id, $order->owner_id);
                    }


                /// send notification
                $notification = new FreeMarNotification();
                $notification->title = "Tin nhắn";
                $notification->body = $sender[0]->name . " đã trả lời bạn trong đơn hàng #" . $order_id;
                $type = NotificationTypeEnum::ORDER_CHAT;
                $data_type = [
                    "message" => [
                        'id' => $message_id,
                        'datetime' => $datetime,
                        'content' => $content,
                        'sender' => $sender[0]
                    ],
                    "product_id" => $order->product_id
                ];

                $notification->sendNotification($array_user_id, $type, json_encode($data_type), false);
            }

            return [
                'id' => $message_id,
                'datetime' => $datetime,
                'content' => $content,
                'sender' => $sender[0]
            ];

        } catch (QueryException $exception) {
            return response([
                "status" => "failed",
                "message" => 'Create failed'], 401);
        }

    }

    public function createChannel(Request $request)
    {
        $this->table = 'product_comment_channel';
        $this->values = convertRequestBodyToArray($request);
        return $this->create();
    }

}
