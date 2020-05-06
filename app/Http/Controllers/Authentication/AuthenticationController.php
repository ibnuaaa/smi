<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function Login(Request $request)
    {

        // $Recaptcha = new \ReCaptcha\ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        // $RecaptchaResponse = $Recaptcha->setExpectedHostname(env('RECAPTCHA_DOMAIN'))->verify($request->input('tokeng'), $request->ip());

        $Model = $request->Payload->all()['Model'];
        Json::set('data', [
            'name' => $Model->User->name,
            'email' => $Model->User->email,
            'username' => $Model->User->username,
            'oauth' => [
                'token_type' => 'Bearer',
                'access_token' => $Model->User->createToken('Login')->accessToken
            ]
        ]);
        return response()->json(Json::get(), 201);
    }
}
