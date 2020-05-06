<?php

use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;

$router->get('/', function () use ($router) {
    Json::set('message', 'BEP BEP WELCOME TO API EOFFICE OF KEMENDAGRI');
    return response()->json(Json::get(), 200);
});

$router->get('/storage/{key}', ['uses' => 'Storage\StorageController@Fetch', 'middleware' => ['LogActivity:Storage.Fetch','Storage.Fetch']]);
$router->get('/tmp/{key}', ['uses' => 'Storage\StorageController@FetchTmp', 'middleware' => ['LogActivity:Storage.FetchTmp','Storage.FetchTmp']]);
$router->delete('/storage/{id}', ['uses' => 'Storage\StorageController@Delete', 'middleware' => ['LogActivity:Storage.Delete','Storage.Delete']]);



$router->get('/thumb/{key}', ['uses' => 'Storage\StorageController@FetchThumb', 'middleware' => ['LogActivity:Storage.FetchThumb','ArrQuery']]);

$router->post('/login', ['uses' => 'Authentication\AuthenticationController@Login', 'middleware' => ['Authentication.Login']]);

$router->get('/qrcode/{key}', ['uses' => 'QrCode\QrCodeController@Create', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);


$router->get('/user/capitalize_user', ['uses' => 'User\UserController@Capitalize', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);
$router->get('/comms/{commands}', ['uses' => 'User\UserController@Comms', 'middleware' => ['LogActivity:Mail.View', 'ArrQuery']]);

