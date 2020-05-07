<?php

namespace App\Http\Controllers\CMS\Sample;

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

use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    public function MasterDataPemdaHome(Request $request)
    {
        return view('app.master_data_pemda.home.index');
    }

    public function MasterDataPemdaNew(Request $request)
    {
        return view('app.master_data_pemda.new.index');
    }

    public function MasterDataPemdaEdit(Request $request)
    {
        return view('app.master_data_pemda.new.index');
    }

    public function MasterDataPemdaDetail(Request $request)
    {
        return view('app.master_data_pemda.detail.index');
    }

}
