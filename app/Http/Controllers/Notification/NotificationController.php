<?php

namespace App\Http\Controllers\Notification;

use App\Models\NotificationUser;

use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    use Browse;

    public function ReadNotification(Request $request)
    {
        $NotificationUser = NotificationUser::where('user_id', MyAccount()->id)
            ->where('status', '0')
            ->get();

        foreach ($NotificationUser as $key => $value) {
            $NotificationUserUpd = NotificationUser::find($value->id);
            $NotificationUserUpd->status = '1';
            $NotificationUserUpd->save();
        }

        Json::set('data', 'ok');
        return response()->json(Json::get(), 202);
    }

}
