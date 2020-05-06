<?php

namespace App\Http\Controllers\Position;

use App\Models\Position;

use App\Traits\Browse;
use App\Traits\Position\PositionCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class PositionBrowseController extends Controller
{
    use Browse, PositionCollection {
        PositionCollection::__construct as private __PositionCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PositionCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = Position::tree();
        } else  {
            $Now = Carbon::now();

            $PositionParent = [];
            if (isset($request->ArrQuery->criteria) && !empty($request->get('source_position_id')))
            {
                if($request->ArrQuery->criteria == 'nota_dinas')
                {
                    $PositionParent = Position::find($request->get('source_position_id'));
                }
            }

            $Position = Position::where(function ($query) use($request, $PositionParent) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->PositionTable.id", $request->ArrQuery->id);
                    $request->ArrQuery->set = 'first';
                }

                if (isset($request->ArrQuery->parent_id)) {
                    $query->where("$this->PositionTable.parent_id", $request->ArrQuery->parent_id);
                }

                if (!empty($request->get('q'))) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->PositionTable.name", 'like', '%'.$request->get('q').'%');
                        $query->orWhere("$this->UserTable.name", 'like', '%'.$request->get('q').'%');
                        $query->orWhere("$this->UserTable.username", 'like', '%'.$request->get('q').'%');
                    });
                }

                if (!empty($request->ArrQuery->search)) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->PositionTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                        $query->orWhere("$this->UserTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                        $query->orWhere("$this->UserTable.username", 'like', '%'.$request->ArrQuery->search.'%');
                    });
                }

                if (isset($request->ArrQuery->status)) {
                    $query->where("$this->PositionTable.status", $request->ArrQuery->status);
                }

                if (isset($request->ArrQuery->parent_id_in)) {
                    $query->whereIn("$this->PositionTable.parent_id", $request->ArrQuery->parent_id_in);
                }



                // if (isset($request->ArrQuery->criteria) && !empty($request->get('source_position_id')))
                // {
                //     if($request->ArrQuery->criteria == 'surat')
                //     {
                //         $query->where("$this->PositionTable.parent_id", $request->get('source_position_id'));
                //     }
                //     else if($request->ArrQuery->criteria == 'nota_dinas')
                //     {
                //         $query->where(function ($query) use($request, $PositionParent) {
                //             $query->where("$this->PositionTable.id", $PositionParent->parent_id);
                //             $query->orWhere("$this->PositionTable.parent_id", $PositionParent->parent_id);
                //         });
                //     }
                // }
           })
           ->select(
                // Position
                "$this->PositionTable.id as id",
                "$this->PositionTable.eselon_id as user.eselon_id",
                "$this->PositionTable.id as user.id",
                "$this->PositionTable.name as user.name",
                "$this->PositionTable.code as user.code",
                "$this->PositionTable.mail_number_suffix_code as user.mail_number_suffix_code",
                "$this->PositionTable.signing_template as user.signing_template",
                "$this->PositionTable.shortname as user.shortname",
                "$this->PositionTable.parent_id as user.parent_id",
                "$this->PositionTable.status as user.status",
                "$this->PositionTable.kunker as user.kunker",
                "$this->PositionTable.updated_at as user.updated_at",
                "$this->PositionTable.created_at as user.created_at",
                "$this->PositionTable.deleted_at as user.deleted_at"
           )
           ->leftJoin($this->UserTable, "$this->UserTable.position_id", "$this->PositionTable.id")
           ->with('user')
           ->with('parent')
           ->with('parents')
           ->groupBy('position_id')
           ->orderBy($this->PositionTable.'.kunker')
           ;

           $Browse = $this->Browse($request, $Position, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($Position) {
                       return [ 'value' => $Position->id, 'label' => $Position->name. 'asdasdasd' ];
                   });
               } else if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select2')) {
                   return $data->map(function($Position) {
                       return [ 'value' => $Position->id, 'label' => $Position->name. 'asdasdasd' ];
                   });
               } else {
                   $data = $this->GetPositionDetails($data);
               }
               return $data;
           });


            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'selection')) {
                $data_selection = [];

                $PositionMe = Position::where('id', $request->Me->account->position_id)->first();
                $data_selection[] = $PositionMe->toArray();
                if(!empty($Browse['records']->parent->user->position)) {
                    $data_selection = $this->getSelection($Browse['records']->parent->user->position->toArray(), $data_selection);
                }


                Json::set('data', $data_selection);
                return response()->json(Json::get(), 200);
            }
        }

        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'user.', $item);
            }
            return $item;
        });
    }
}
