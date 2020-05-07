<?php

namespace App\Http\Controllers\CMS\Register;


use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function Home(Request $request)
    {
        return view('app.register.home.index');
    }
}
