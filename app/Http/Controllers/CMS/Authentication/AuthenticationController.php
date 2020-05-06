<?php

namespace App\Http\Controllers\CMS\Authentication;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{

    public function Logout(Request $request)
    {
        if (isset($_COOKIE['AccessToken'])) {
            unset($_COOKIE['AccessToken']);
            setcookie('AccessToken', null, -1, '/');
        }
        return redirect()->route('login');
    }
}
