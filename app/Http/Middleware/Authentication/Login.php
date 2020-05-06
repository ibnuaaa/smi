<?php

namespace App\Http\Middleware\Authentication;

use App\Models\User;
use App\Models\UsersFromApi;
use App\Models\PositionsFromApi;
use App\Models\Position;
use App\Models\ApiLog;

use Closure;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Login extends BaseMiddleware
{
    private function Initiate()
    {
        $this->username = $this->_Request->input('username');
        $this->password = $this->_Request->input('password');
        $this->isWithEmail = filter_var($this->username, FILTER_VALIDATE_EMAIL);
    }

    private function Validation()
    {
        if (!$this->isWithEmail) {
            $validator = Validator::make($this->_Request->all(), [
                'username' => 'required|max:255',
                'password' => 'required|max:255'
            ]);
        } else {
            $validator = Validator::make($this->_Request->all(), [
                'username' => 'required|email|max:255',
                'password' => 'required|max:255'
            ]);
        }

        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors()->jsonSerialize());
            return false;
        }


        /*
            [nip] => 198304112010121001
            [nama] => ADETYA CAHYA NINGRAT, S.Kom
            [ttl] => MALANG, 11-04-1983
            [agama] => ISLAM
            [pangkat] => PENATA (III/c)
            [nama_gol] => III/c
            [tmtpang] => 01-04-2019
            [jabatan] => ANALIS DATA DAN INFORMASI PADA SUBBIDANG PEMBANGUNAN DAN PENGEMBANGAN BIDANG PENGELOLAAN SISTEM INFORMASI PUSAT DATA DAN SISTEM INFORMASI SEKRETARIAT JENDERAL
            [tmtjabatan] => 01-02-2019
            [file_bmp] => ADETYA_CAHYA_NINGRAT,_S._KOM_(O)_.JPG
            [foto] => https://ropeg.setjen.kemendagri.go.id/foto/198304112010121001/ADETYA_CAHYA_NINGRAT,_S._KOM_(O)_.JPG
            [kunker] => 0001090410
            [kunkom] => 01
            [kununit] => 09
            [kunsk] => 04
            [kunssk] => 10
            [jnsjab] => 4
        */

        /*
        try {
            $start_api = time();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://ropeg.setjen.kemendagri.go.id/restsimpeg/index.php/api/api_profil");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "token=af9ec164748d7690c4f58021b6907d8d&nip=" . $this->username);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);

            $api_data = json_decode($server_output);
            $value = $api_data->results;

            // === POSITION ====
            // CEK DI Position
            $Position = Position::where('name', $value->jabatan)->first();

            $name = $value->nama;
            $name_arr = explode(',', $name);
            $nama_depan = $name_arr[0];
            $nama_depan_arr  = explode('.', $nama_depan);
            $nama_main = $nama_depan_arr[count($nama_depan_arr)-1];

            $nama_main = strtolower($nama_main);
            $nama_main = ucwords($nama_main);

            $fullname = "";
            foreach ($nama_depan_arr as $key2 => $value2) {
                if(count($nama_depan_arr)-1 > $key2) $fullname .= $value2 . ".";
            }

            $fullname = $fullname . $nama_main . ",";

            foreach ($name_arr as $key2 => $value2) {

                $comma = ',';
                if (count($name_arr) - 1 == $key2) $comma = '';
                if($key2 > 0) $fullname .= $value2 . $comma;
            }

            $golongan = $value->pangkat;
            $golongan = str_replace('PENATA', 'Penata', $golongan);
            $golongan = str_replace('PRANATA', 'Pranata', $golongan);
            $golongan = str_replace('PEMBINA', 'Pembina', $golongan);
            $golongan = str_replace('UTAMA', 'Utama', $golongan);
            $golongan = str_replace('MUDA', 'Muda', $golongan);
            $golongan = str_replace('PENATA', 'Penata', $golongan);
            $golongan = str_replace('JURU', 'Juru', $golongan);

            $UserUpdate = User::where('username', $this->username)->first();

            $UserUpdate->name = $fullname;
            $UserUpdate->position_id = $Position->id;
            $UserUpdate->golongan = $golongan;
            $UserUpdate->save();

            $end_api = time();
            $status = 200;
            $duration = $end_api - $start_api;
        } catch (\Exception $e) {
            $server_output = 'fetch_data_ropeg_internal_server_error';
            $status = 500;
            $duration = 0;
        }


        $ApiLog = new ApiLog();
        $ApiLog->status_code = $status;
        $ApiLog->results = $server_output;
        $ApiLog->duration = $duration;
        $ApiLog->save();
        */

        if (($this->isWithEmail) && !$this->Model->User = User::where('email', $this->username)->where('status', 'active')->first()) {
            $this->Json::set('errors.username', [
                trans('validation.login.invalid_email')
            ]);
            return false;
        } elseif ((!$this->isWithEmail) && !$this->Model->User = User::where('username', $this->username)->where('status', 'active')->first()) {
            $this->Json::set('errors.username', [
                trans('validation.login.username')
            ]);
            return false;
        } elseif (!Hash::check($this->password, $this->Model->User->password)) {
            $this->Json::set('errors.password', [
                trans('validation.login.invalid_password')
            ]);
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
