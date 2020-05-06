<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    protected $middleware = [
        \Barryvdh\Cors\HandleCors::class
    ];

    protected $routeMiddleware = [
        // Web Middleware
        'cookies.encrypt' => \App\Http\Middleware\EncryptCookies::class,
        'auth.web' => \App\Http\Middleware\AuthenticateForWeb::class,
        'subtitue.bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'throttle' => \App\Http\Middleware\ThrottleRequests::class,

        'auth.api' => \App\Http\Middleware\Authenticate::class,
        'auth.cms' => \App\Http\Middleware\CMS\Authenticate::class,
        'cors' => \Barryvdh\Cors\HandleCors::class,
        'ArrQuery' => \App\Http\Middleware\QueryRoute::class,
        'AuthenticatePage' => \App\Http\Middleware\AuthenticatePage::class,

        'Authentication.Login' => \App\Http\Middleware\Authentication\Login::class,

        'Account.SignUp' => \App\Http\Middleware\Account\SignUp::class,

        'Account.SignUp' => \App\Http\Middleware\Account\SignUp::class,

        'User.Insert' => \App\Http\Middleware\User\Insert::class,
        'User.Update' => \App\Http\Middleware\User\Update::class,
        'User.ChangePassword' => \App\Http\Middleware\User\ChangePassword::class,
        'User.ResetPassword' => \App\Http\Middleware\User\ResetPassword::class,
        'User.ChangeStatus' => \App\Http\Middleware\User\ChangeStatus::class,
        'User.Password' => \App\Http\Middleware\User\Password::class,
        'User.Delete' => \App\Http\Middleware\User\Delete::class,

        'Information.Insert' => \App\Http\Middleware\Information\Insert::class,
        'Information.Update' => \App\Http\Middleware\Information\Update::class,
        'Information.Delete' => \App\Http\Middleware\Information\Delete::class,

        'MailNumberClassification.Insert' => \App\Http\Middleware\MailNumberClassification\Insert::class,
        'MailNumberClassification.Update' => \App\Http\Middleware\MailNumberClassification\Update::class,
        'MailNumberClassification.Delete' => \App\Http\Middleware\MailNumberClassification\Delete::class,

        'Config.Insert' => \App\Http\Middleware\Config\Insert::class,
        'Config.Update' => \App\Http\Middleware\Config\Update::class,
        'Config.Delete' => \App\Http\Middleware\Config\Delete::class,

        'ConfigNumbering.Update' => \App\Http\Middleware\ConfigNumbering\Update::class,

        'Position.Insert' => \App\Http\Middleware\Position\Insert::class,
        'Position.Update' => \App\Http\Middleware\Position\Update::class,
        'Position.Delete' => \App\Http\Middleware\Position\Delete::class,
        'Position.ChangeStatus' => \App\Http\Middleware\Position\ChangeStatus::class,

        'Mail.Insert' => \App\Http\Middleware\Mail\Insert::class,
        'Mail.InsertUploadSuratMasuk' => \App\Http\Middleware\Mail\InsertUploadSuratMasuk::class,
        'Mail.Update' => \App\Http\Middleware\Mail\Update::class,
        'Mail.Delete' => \App\Http\Middleware\Mail\Delete::class,
        'Mail.Approve' => \App\Http\Middleware\Mail\Approve::class,
        'Mail.RequestMailNumber' => \App\Http\Middleware\Mail\RequestMailNumber::class,
        'Mail.CancelRequestMailNumber' => \App\Http\Middleware\Mail\CancelRequestMailNumber::class,
        'Mail.SaveMailNumber' => \App\Http\Middleware\Mail\SaveMailNumber::class,
        'Mail.Reject' => \App\Http\Middleware\Mail\Reject::class,
        'Mail.Dispose' => \App\Http\Middleware\Mail\Dispose::class,
        'Mail.MakerSend' => \App\Http\Middleware\Mail\MakerSend::class,

        'MailDispositionReply.Insert' => \App\Http\Middleware\MailDispositionReply\Insert::class,

        'User.Developer.Token' => \App\Http\Middleware\User\Developer\Token::class,

        'LogActivity' => \App\Http\Middleware\LogActivity::class,

        'File.Upload' => \App\Http\Middleware\Upload\File::class,

        'Storage.Save' => \App\Http\Middleware\Storage\Save::class,
        'Storage.Fetch' => \App\Http\Middleware\Storage\Fetch::class,
        'Storage.FetchTmp' => \App\Http\Middleware\Storage\FetchTmp::class,
        'Storage.Delete' => \App\Http\Middleware\Storage\Delete::class,
        'Storage.FetchThumb' => \App\Http\Middleware\Storage\FetchThumb::class,

    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->middleware($this->middleware);
        $this->app->routeMiddleware($this->routeMiddleware);
    }
}
