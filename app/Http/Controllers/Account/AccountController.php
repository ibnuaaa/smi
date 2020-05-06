<?php

namespace App\Http\Controllers\Account;

use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function SignUp(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $RealPassword = $Model->User->password;
        $Model->User->password = app('hash')->make($RealPassword);
        if (Hash::needsRehash($Model->User->password)) {
            $Model->User->password = app('hash')->make($RealPassword);
        }
        $Model->User->save();
        $Model->User->position_id = 3;
        $Model->Member->user_id = $Model->User->id;
        $Model->Member->save();

        Json::set('data', [
            'name' => $Model->User->name,
            'email' => $Model->User->email,
            'username' => $Model->User->username,
            'oauth' => [
                'token_type' => 'Bearer',
                'access_token' => $Model->User->createToken('SignUp')->accessToken
            ]
        ]);
        return response()->json(Json::get(), 201);
    }
}
