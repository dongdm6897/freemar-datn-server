<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SignupActivate;
use Illuminate\Support\Facades\Input;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{


    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'fcm_token' => 'required|string'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => str_random(60),
            'fcm_token' => $request->fcm_token,
            'status_id' => UserStatusEnum::INACTIVE
        ]);
        $user->save();
        $when = now()->addSecond(30);
        $user->notify((new SignupActivate($user))->delay($when));

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        $user = $request->user();
        if ($user->status_id == UserStatusEnum::SIMPLE) {
            if ($request->fcm_token) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
            }
            $tokenResult = $user->createToken('Personal Access Token');

            return [
                'access_token' => $tokenResult->accessToken,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => new UserResource($user)
            ];
        } else
            return responseFail('Unauthorized');
    }

    public function loginSocial(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'id' => 'required',
            'type' => 'required'
        ]);

        $sns_id = $request->id;
        $sns_data = $request->data;
        $name = $sns_data['name'];
        $email = $sns_data['email'];
        $avatar = $sns_data['photoUrl'];

        $user_id = DB::table('users')->select('id')->where([
            ['sns_id', '=', $sns_id],
            ['sns_type', '=', $request->type]
        ])->first();

        if (!empty($user_id->id) && Auth::loginUsingId($user_id->id)) {
            $user = $request->user();
        } else {
            $user = new User([
                'name' => $name,
                'avatar' => $avatar,
                'email' => $email,
                'sns_id' => $sns_id,
                'sns_data' => json_encode($request->data),
                'sns_type' => $request->type,
                'status_id' => UserStatusEnum::SIMPLE,
                'fcm_token' => $request->fcm_token
            ]);
            try {
                $user->save();
            } catch (QueryException $exception) {
                return responseFail('Login error or Duplicate email');
            }
        }

        $tokenResult = $user->createToken('Personal Access Token');


        return [
            'access_token' => $tokenResult->accessToken,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => new UserResource($user)
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function profile(Request $request)
    {

        return new UserResource($request->user());
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->activation_token = '';
        $user->status_id = UserStatusEnum::SIMPLE;
        $user->save();
        return $user;
    }

}
