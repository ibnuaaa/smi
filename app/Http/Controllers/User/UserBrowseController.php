<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Traits\Browse;
use App\Traits\User\UserCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class UserBrowseController extends Controller
{
    use Browse, UserCollection {
        UserCollection::__construct as private __UserCollectionConstruct;
    }

    protected $search = [
        'name',
        'username',
        'email'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $User = User::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where("$this->UserTable.id", $request->user()->id);
                } else {
                    $query->where("$this->UserTable.id", $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where("$this->UserTable.username", $request->user()->username);
                } else {
                    $query->where("$this->UserTable.username", $request->ArrQuery->username);
                }
            }
            // if (isset($request->ArrQuery->search)) {
            //     $query->where(function ($query) use($request) {
            //         $query->where("$this->UserTable.username", 'like', '%'.$request->ArrQuery->search.'%')
            //                 ->orWhere("$this->UserTable.id", 'like', '%'.$request->ArrQuery->search.'%');
            //     });
            // }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->UserTable.username", 'like', '%'.$request->get('q').'%')
                        ->orWhere("$this->UserTable.id", 'like', '%'.$request->get('q').'%')
                        ->orWhere("$this->UserTable.name", 'like', '%'.$request->get('q').'%')
                        ->orWhere("$this->PositionTable.name", 'like', '%'.$request->get('q').'%');
                });
            }
            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->user_ids)) {
                $query->whereIn("$this->UserTable.id", $request->ArrQuery->user_ids);
            }

            //mail_destination
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'send_mail')) {
                $query->whereNotIn("$this->UserTable.id", [Auth::user()->id]);
            }

            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        if($value == 'name') $query->orWhere($this->UserTable.".".$value, 'like', $search);
                        else $query->orWhere($value, 'like', $search);

                    }
               });
            }
       })
       ->leftJoin($this->PositionTable, "$this->PositionTable.id", "$this->UserTable.position_id")
       ->select(
            // User
            "$this->UserTable.id as user.id",
            "$this->UserTable.name as user.name",
            "$this->UserTable.username as user.username",
            "$this->UserTable.nik as user.nik",
            "$this->UserTable.email as user.email",
            "$this->UserTable.gender as user.gender",
            "$this->UserTable.position_id as user.position_id",
            "$this->UserTable.address as user.address",
            "$this->UserTable.remember_token as user.remember_token",
            "$this->UserTable.updated_at as user.updated_at",
            "$this->UserTable.created_at as user.created_at",
            "$this->UserTable.deleted_at as user.deleted_at",
            "$this->UserTable.satker as user.satker",
            "$this->UserTable.status as user.status",
            "$this->UserTable.golongan as user.golongan",
            "$this->UserTable.jenis_user as user.jenis_user",

            // User
            "$this->PositionTable.id as position.id",
            "$this->PositionTable.name as position.name"
       )->with('profile_picture');


        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
                if ($request->get('sort') == 'id') $User->orderBy("$this->UserTable.id", $request->get('sort_type'));
                else if ($request->get('sort') == 'name') $User->orderBy("$this->UserTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'nip') $User->orderBy("$this->UserTable.username", $request->get('sort_type'));
                else if($request->get('sort') == 'jabatan') $User->orderBy("$this->PositionTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'terbuat_pada') $User->orderBy("$this->UserTable.created_at", $request->get('sort_type'));
            }
        } else {
            $User->orderBy("$this->UserTable.created_at", 'desc');
        }

       $Browse = $this->Browse($request, $User, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($User) {
                   return [ 'value' => $User->id, 'label' => $User->name ];
               });
           } else {
               $data = $this->GetUserDetails($data);
           }
           return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        $position = [];
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'user.', $item);
                $this->Group($position, $key, 'position.', $item);
            }
            $item->position = $position;
            return $item;
        });
    }
}
