<?php

namespace App\Notifications;

use DB;
use Illuminate\Database\QueryException;

class FreeMarNotification
{
    public $body, $title;


    public function freemar()
    {

    }

    public function sendMessage()
    {

    }

    public function sendNotification($array_user_id, $type, $array_data_type, $create_table = true,$screen = "/notifications")
    {
        $fcm_url = config('freemar.fcm_url');
        $fcm_notification = [];

        $notification = [
            'body' => $this->body,
            'title' => $this->title,
            'sound' => true,
        ];
        $extra_notificationData = [
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "screen" => $screen,
            "type" => $type,
            "data_type" => $array_data_type
        ];

        if (count($array_user_id) == 1) {
            $fcm_token = $this->getToken($array_user_id[0]);

            $fcm_notification = [
                'to' => $fcm_token,
                'notification' => $notification,
                'data' => $extra_notificationData
            ];

        }
        elseif (count($array_user_id) > 1) {
            $registration_ids = array();

            $res = DB::table('users')->whereIn('id', $array_user_id)->select('fcm_token')->get();

            foreach ($res as $value) {
                array_push($registration_ids, $value->fcm_token);
            }

            $fcm_notification = [
                'registration_ids' => $registration_ids,
                'notification' => $notification,
                'data' => $extra_notificationData
            ];

        }

        $headers = [
            'Authorization: key=' . config('freemar.fcm_server_key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcm_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcm_notification));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            dd('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        if($create_table)
            $this->createNotification($type,$array_user_id);

        return $result;
    }

    public function getToken(int $user_id)
    {
        $fcm_token = DB::table('users')->where('id', $user_id)->select('fcm_token')->get()[0]->fcm_token;
        return $fcm_token;
    }

    private function createNotification($type, $array_recipient_ids){

        $data = array();
        foreach ($array_recipient_ids as $value){
            array_push($data,[
                'title' => $this->title,
                'body' => $this->body,
                'type_id' => $type,
                'recipient_id' => $value
            ]);
        }

        if(count($data) > 0) {
            try{
                DB::table('notification')->insert($data);
            }catch (QueryException $exception){
                dd($exception);
            }
        }
    }

}