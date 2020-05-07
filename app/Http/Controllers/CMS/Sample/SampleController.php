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

    // MASTER DATA PEMDA
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

    // MASTER DATA PROVINCE
    public function MasterDataProvinceHome(Request $request)
    {
        return view('app.master_data_province.home.index');
    }

    public function MasterDataProvinceNew(Request $request)
    {
        return view('app.master_data_province.new.index');
    }

    public function MasterDataProvinceEdit(Request $request)
    {
        return view('app.master_data_province.new.index');
    }

    public function MasterDataProvinceDetail(Request $request)
    {
        return view('app.master_data_province.detail.index');
    }

    // MASTER DATA KABUPATEN
    public function MasterDataKabupatenHome(Request $request)
    {
        return view('app.master_data_kabupaten.home.index');
    }

    public function MasterDataKabupatenNew(Request $request)
    {
        return view('app.master_data_kabupaten.new.index');
    }

    public function MasterDataKabupatenEdit(Request $request)
    {
        return view('app.master_data_kabupaten.new.index');
    }

    public function MasterDataKabupatenDetail(Request $request)
    {
        return view('app.master_data_kabupaten.detail.index');
    }

    // MASTER DATA KECAMATAN
    public function MasterDataKecamatanHome(Request $request)
    {
        return view('app.master_data_kecamatan.home.index');
    }

    public function MasterDataKecamatanNew(Request $request)
    {
        return view('app.master_data_kecamatan.new.index');
    }

    public function MasterDataKecamatanEdit(Request $request)
    {
        return view('app.master_data_kecamatan.new.index');
    }

    public function MasterDataKecamatanDetail(Request $request)
    {
        return view('app.master_data_kecamatan.detail.index');
    }

    // MASTER DATA Desa
    public function MasterDataDesaHome(Request $request)
    {
        return view('app.master_data_desa.home.index');
    }

    public function MasterDataDesaNew(Request $request)
    {
        return view('app.master_data_desa.new.index');
    }

    public function MasterDataDesaEdit(Request $request)
    {
        return view('app.master_data_desa.new.index');
    }

    public function MasterDataDesaDetail(Request $request)
    {
        return view('app.master_data_desa.detail.index');
    }

}
