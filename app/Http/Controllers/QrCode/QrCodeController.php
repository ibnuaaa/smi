<?php

namespace App\Http\Controllers\QrCode;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use App\Support\Response\Json;

use App\Http\Controllers\Controller;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class QrCodeController extends Controller
{
    public function Create(Request $request, $key)
    {
        $qrCode = new QrCode("http://".env('APP_DOMAIN')."/qrpdf/" . $key);
        $qrCode->writeFile(__DIR__ . '/../../../..' . '/public/assets/img/qrcode/'.$key.'.png');
        // cetak($qrCode->getContentType());
        // die();

        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();

        return response($qrCode->writeString(), 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'filename=lala.png');


        // echo __DIR__ . '/../../..' . '/qrcode.png' ;
        // die();

        return $response = new QrCodeResponse($qrCode);

    }


}
