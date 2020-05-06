<?php

namespace App\Http\Controllers\CMS\User;

use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\Blast\UserPhoneNumber\UserPhoneNumberBrowseController;
use App\Http\Controllers\Blast\Category\CategoryBrowseController;
use App\Http\Controllers\Blast\UserPhoneNumber\View\NotesBrowseController;

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

class UserController extends Controller
{
    public function Home(Request $request)
    {
        $TableKey = 'user-table';

        $filter_search = $request->input($TableKey . '-filter_search');

        if (isset($request['user-table-show'])) {
            $selected = $request['user-table-show'];
        }
        else {
            $selected = 10;
        }
        $options = array(5,10,15,20);
        $User = UserBrowseController::FetchBrowse($request)
            ->where('orderBy.blast_users.created_at', 'desc')
            ->where('with.total', 'true');

        if (isset($filter_search)) {
            $User = $User->where('search', $filter_search);
        }

        $User = $User->middleware(function($fetch) use($request, $TableKey) {
                $fetch->equal('skip', ___TableGetSkip($request, $TableKey, $fetch->QueryRoute->ArrQuery->take));
                return $fetch;
            })
            ->get('fetch');

        $Take = ___TableGetTake($request, $TableKey);
        $DataTable = [
            'key' => $TableKey,
            'filter_search' => $filter_search,
            'placeholder_search' => "Nama, NIP, Email",
            'pageNow' => ___TableGetCurrentPage($request, $TableKey),
            'paginate' => ___TablePaginate((int)$User['total'], (int)$User['query']->take, ___TableGetCurrentPage($request, $TableKey)),
            'selected' => $selected,
            'options' => $options,
            'heads' => [
                (object)['name' => 'id', 'label' => 'ID'],
                (object)['name' => 'name', 'label' => 'Name'],
                (object)['name' => 'nip', 'label' => 'NIP'],
                (object)['name' => 'jabatan', 'label' => 'Jabatan'],
                (object)['name' => 'terbuat_pada', 'label' => 'Terbuat Pada'],
                (object)['name' => 'action', 'label' => 'ACTION']
            ],
            'records' => []
        ];

        if ($User['records']) {
            $DataTable['records'] = $User['records'];
            $DataTable['total'] = $User['total'];
            $DataTable['show'] = $User['show'];
        }

        $ParseData = [
            'data' => $DataTable,
            'result_total' => isset($DataTable['total']) ? $DataTable['total'] : 0
        ];
        return view('app.user.home.index', $ParseData);
    }

    public function New(Request $request)
    {

        return view('app.user.new.index', [
        ]);
    }

    public function Detail(Request $request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = $id;
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $UserBrowseController = new UserBrowseController($QueryRoute);
        $data = $UserBrowseController->get($QueryRoute);

        return view('app.user.detail.home.index', [ 'data' => $data->original['data']['records'] ]);
    }

    public function Profile(Request $request)
    {

        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->id = 'my';
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->{'with.total'} = 'true';
        $UserBrowseController = new UserBrowseController($QueryRoute);
        $data = $UserBrowseController->get($QueryRoute);

        $profile_picture_key = "";
        if(!empty($data->original['data']['records']->profile_picture->storage->key))
        $profile_picture_key = $data->original['data']['records']->profile_picture->storage->key;

        return view('app.user.profile.index', [
            'data' => $data->original['data']['records'],
            'profile_picture_key' => $profile_picture_key
        ]);
    }

    public function ChangePassword(Request $request)
    {
        return view('app.user.change_password.index');
    }

    public function Edit(Request $request, $id)
    {
        $User = UserBrowseController::FetchBrowse($request)
            ->equal('id', $id)->get('first');

        $CategoryIds = [];
        try {
            foreach (explode(',', str_replace(' ', '', $User['records']->category_id)) as $key => $value) {
                $CategoryIds[] = $value;
            }
        } catch (\Exception $e) {
        }

        if (!isset($User['records']->id)) {
            throw new ModelNotFoundException('Not Found Batch');
        }
        return view('app.user.edit.index', [
            'categoryIds' => $CategoryIds,
            'data' => $User['records']
        ]);
    }

}
