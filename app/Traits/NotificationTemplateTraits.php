<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Position;
use App\Models\MailTemplate;
use App\Models\NotificationTemplate;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

trait NotificationTemplateTraits
{
    public function createNotif($mail_id, $code, $template_id, $dispose_id = '')
    {
        $CurrentPosition = Position::where('id', Auth::user()->position_id)->first();
        $MailTemplate = MailTemplate::where('id', $template_id)->first();
        $NotificationTemplate = NotificationTemplate::where('code', $code)->first();

        $text = $NotificationTemplate->text;

        if($code == 'DISPOSED') {
            $text = str_replace('{{ disposition_id }}', $dispose_id, $text);
        } else {
            $text = str_replace('{{ mail_id }}', $mail_id, $text);
        }

        $text = str_replace('{{ mail_template_name }}', $MailTemplate->name, $text);
        $text = str_replace('{{ position_name }}', $CurrentPosition->shortname, $text);

        $Notification = new Notification();
        $Notification->notification_type = $code;
        $Notification->notification_master_id = $mail_id;
        $Notification->notification_text = $text;
        $Notification->save();

        return $Notification->id;
    }

    public function sendNotifUser($id, $position_id, $user_id = '')
    {

        if (!empty($position_id)) {
            $UserInPosition = User::where('position_id', $position_id)->get();
            foreach ($UserInPosition as $key => $user) {
                $NotificationUser = new NotificationUser();
                $NotificationUser->notification_id = $id;
                $NotificationUser->user_id = !empty($user->id) ? $user->id : 0;
                $NotificationUser->save();
            }
        } else if (!empty($user_id)) {
            $NotificationUser = new NotificationUser();
            $NotificationUser->notification_id = $id;
            $NotificationUser->user_id = $user_id;
            $NotificationUser->save();
        }
    }
}
