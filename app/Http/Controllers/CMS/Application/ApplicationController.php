<?php

namespace App\Http\Controllers\CMS\Application;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function Verified(Request $request)
    {
        $TableKey = 'application-verified-table';

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'take' => $Take,
            'filter_search' => ___TableGetFilterSearch($request, $TableKey),
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)0, 30, ___TableGetCurrentPage($request, $TableKey)),
            'heads' => [
                (object)['name' => 'TGL_SUBMIT', 'label' => 'Tgl Submit'],
                (object)['name' => 'NAMA_DEALER', 'label' => 'Nama dealer'],
                (object)['name' => 'NAMA_USER', 'label' => 'Nama user'],
                (object)['name' => 'JABATAN', 'label' => 'Jabatan'],
                (object)['name' => 'STATUS_VERIFED', 'label' => 'Status Verifed'],
                (object)['name' => 'STATUS_PENGAJUAN_APLIKASI', 'label' => 'Status Pengajuan Aplikasi'],
                (object)['name' => 'ACTION', 'label' => 'ACTION']
            ],
            'records' => [
                (object)['TGL_SUBMIT' => '2019-09-01', 'NAMA_DEALER' => 'WALDI', 'NAMA_USER' => 'Waldi Irawan','JABATAN' => 'OWNER', 'STATUS_VERIFED' => 'VERIFIED', 'STATUS_PENGAJUAN_APLIKASI' => 'PENDING']
            ]
        ];

        $DataTable['total'] = 0;
        $DataTable['show'] = 0;

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.application.verified.home.index', $ParseData);
    }

    public function NotVerified(Request $request)
    {
        $TableKey = 'application-notverified-table';

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'take' => $Take,
            'filter_search' => ___TableGetFilterSearch($request, $TableKey),
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)0, 30, ___TableGetCurrentPage($request, $TableKey)),
            'heads' => [
                (object)['name' => 'TGL_SUBMIT', 'label' => 'Tgl Submit'],
                (object)['name' => 'NAMA_DEALER', 'label' => 'Nama dealer'],
                (object)['name' => 'NAMA_USER', 'label' => 'Nama user'],
                (object)['name' => 'JABATAN', 'label' => 'Jabatan'],
                (object)['name' => 'STATUS_VERIFED', 'label' => 'Status Verifed'],
                (object)['name' => 'STATUS_PENGAJUAN_APLIKASI', 'label' => 'Status Pengajuan Aplikasi'],
                (object)['name' => 'ACTION', 'label' => 'ACTION']
            ],
            'records' => [
                (object)['TGL_SUBMIT' => '2019-09-01', 'NAMA_DEALER' => 'WALDI', 'NAMA_USER' => 'Waldi Irawan','JABATAN' => 'OWNER', 'STATUS_VERIFED' => 'NOT VERIFIED', 'STATUS_PENGAJUAN_APLIKASI' => 'PENDING']
            ]
        ];

        $DataTable['total'] = 0;
        $DataTable['show'] = 0;

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.application.notverified.home.index', $ParseData);
    }
}
