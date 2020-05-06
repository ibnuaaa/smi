<?php

namespace App\Http\Controllers\GetPdf;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use App\Support\Response\Json;

use App\Http\Controllers\Controller;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class GetPdfController extends Controller
{
    public function GetPdf(Request $request, $encoded_url)
    {
        header("Content-type:application/pdf");
        echo $decoded_url = str_replace('0!0', '/', $encoded_url);
        // echo $decoded_url = str_replace('/', '0!0', 'https:0!00!0esign.kemendagri.go.id0!0DS0!020200!0nota-dinas0!01587374492lvpifh.pdf');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $decoded_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 0
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
        die();
    }


}
