<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/login', ['as' => 'login', function () {
//     return view('app.authentication.login.index');
// }]);

$router->get('/login', ['as' => 'login', function () {
    return view('app.authentication.login.index');
}, 'middleware' => ['AuthenticatePage']]);


$router->get('/qrpdf/{id}', 'CMS\SuratMasuk\SuratMasukController@DownloadPdfFromQr');
// $router->get('/captchaInfo', 'CMS\SuratMasuk\SuratMasukController@DownloadPdfFromQr');

$router->get('/pdf/{encoded_url}', 'GetPdf\GetPdfController@GetPdf');
