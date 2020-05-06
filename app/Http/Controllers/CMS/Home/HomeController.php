<?php

namespace App\Http\Controllers\CMS\Home;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function Home(Request $request)
    {

        return view('app.home.index');
    }
}
