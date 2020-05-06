<?php

namespace App\Http\Controllers\Notification;

use App\Models\Notification;

use App\Traits\Browse;
use App\Traits\Notification\NotificationCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Auth;

class NotificationBrowseController extends Controller
{
    use Browse, NotificationCollection {
        NotificationCollection::__construct as private __NotificationCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__NotificationCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Notification = Notification::where(function ($query) use($request) {
            $query->where("$this->NotificationUserTable.user_id", Auth::user()->id);

            if (isset($request->ArrQuery->status)) {
                $query->where("$this->NotificationUserTable.status", $request->ArrQuery->status);
            }

        })
        ->leftJoin("$this->NotificationUserTable", "$this->NotificationUserTable.notification_id", "$this->NotificationTable.id")
        ->select(
            // Notification
            "$this->NotificationTable.id as notification.id",
            "$this->NotificationTable.notification_type as notification.notification_type",
            "$this->NotificationTable.notification_text as notification.notification_text",
            "$this->NotificationTable.notification_master_id as notification.notification_master_id",
            "$this->NotificationTable.created_at as notification.created_at"
        );
        $Notification->orderBy("$this->NotificationTable.id", 'DESC');

        $Browse = $this->Browse($request, $Notification, function ($data) use($request) {
            $data = $this->Manipulate($data);
            $data = $this->GetNotificationDetails($data);

            return $data;
        });

        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'notification.', $item);
            }
            return $item;
        });
    }
}
