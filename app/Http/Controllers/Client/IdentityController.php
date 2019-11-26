<?php

namespace App\Http\Controllers\Client;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class IdentityController extends ObjectController
{
    public function verifyPhoto(Request $request)
    {
        $user = Auth::user();
        if (!$user->identify_photo_id) {
            $this->table = 'identify_photo';
            $this->values = convertRequestBodyToArray($request);
            $photo_id = $this->createGetId();

            if ($photo_id) {
                $user->status_id = UserStatusEnum::MEDIUM_WAITING_FOR_VERIFICATION;
                $user->identify_photo_id = $photo_id;
                $user->save();
            }
            return responseSuccess();
        } else
            return responseFail('Duplicate photo');
    }

    public function verifyAddress()
    {

    }

    public function getPhotoVerified()
    {
        return Auth::user()->identifyPhoto()->get()[0];
    }

}
