<?php

namespace App\Http\Controllers\Client;

use App\Enums\NotificationTypeEnum;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class NotificationController extends ObjectController
{
    protected $table = 'notification';

    public function getYour()
    {
        $id = Auth::user()->id;
        return $this->get([
            [
                'type_id', '!=', NotificationTypeEnum::SYSTEM
            ],
            [
                'recipient_id', '=', $id
            ]
        ]);
    }

    public function getSystem()
    {
        return $this->get([
            [
                'type_id', '=', NotificationTypeEnum::SYSTEM
            ],
            [
                'recipient_id', '=', null
            ]
        ]);
    }

    public function setUnread(Request $request)
    {
        $user_id = Auth::id();
        return DB::table('notification')->where('recipient_id', $user_id)
                                              ->update(['is_unread' => true]);
    }

    public function countUnread()
    {
        $user_id = Input::get('user_id');

        $count_unread = DB::table('notification')->where([
            ['is_unread', '=', false],
            ['recipient_id', '=', $user_id]
        ])->count();

        return [
            'count_unread' => $count_unread
        ];
    }
}
