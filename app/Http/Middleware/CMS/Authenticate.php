<?php

namespace App\Http\Middleware\CMS;

use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\BaseMiddleware;
use Illuminate\Contracts\Auth\Factory as Auth;

use App\Http\Controllers\Mail\MailBrowseController;
use App\Http\Controllers\Permission\PermissionBrowseController;

class Authenticate extends BaseMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, Request $request)
    {
        $TokenType = $request->cookie('TokenType');
        $AccessToken = $request->cookie('AccessToken');
        $request->headers->set('Authorization', $TokenType.' '.$AccessToken);

        parent::__construct($request);
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!empty ($_COOKIE['AccessToken'])) {
            setcookie("AccessToken", $_COOKIE['AccessToken'], time() + (6000 * 10), '/');
        }
        if ($this->auth->guard($guard)->guest()) {
            return redirect()->route('login');
        }
        $Me = (object)[ 'account' => $request->user(), 'type' => 'user'];
        $this->_Request->merge(['Me' => $Me]);
        $Counter = \App\Support\Counter::Init();

        // $MailSuratKeluar = MailBrowseController::FetchBrowse($request)
        //     ->where('with.total', 'true')
        //     ->where('for', 'surat_keluar')
        //     ->get('count');

        // $MailUnunreadApproval = MailBrowseController::FetchBrowse($request)
        //     ->where('with.total', 'true')
        //     ->where('for', 'approval')
        //     ->where('is_unread', 'y')
        //     ->get('count');

        $MailUnapproved = MailBrowseController::FetchBrowse($request)
            ->where('with.total', 'true')
            ->where('for', 'approval')
            ->where('is_unapproved', 'y')
            ->get('count');

        $MailSuratMasuk = MailBrowseController::FetchBrowse($request)
            ->where('with.total', 'true')
            ->where('for', 'surat_masuk')
            ->where('is_unread', 'y')
            ->get('count');

        // $MailDisposition = MailBrowseController::FetchBrowse($request)
        //     ->where('with.total', 'true')
        //     ->where('for', 'disposition')
        //     ->get('count');

        $PermissionId = $Me->account->position_id;
        $Permission = PermissionBrowseController::FetchBrowse($request)
        ->where('orderBy.created_at', 'desc')
        ->where('position_id', $PermissionId)
        ->where('with.total', 'true')
        ->where('take', 'all')
        ->get('fetch');

        $request->permissions = $Permission['records']->toArray();
        $Permission = \App\Support\Permission::Init();
        $Permission->InitAllPermission($request->permissions);

        $Counts = [
            // 'surat_keluar_count' => $MailSuratKeluar['total'] ? $MailSuratKeluar['total'] : '',
            // 'unread_approval_count' => $MailUnunreadApproval['total'] ? $MailUnunreadApproval['total'] : '',
            'unapproved_count' => $MailUnapproved['total'] ? $MailUnapproved['total'] : '',
            'surat_masuk_count' => $MailSuratMasuk['total'] ? $MailSuratMasuk['total'] : ''
            // 'disposition_count' => $MailDisposition['total'] ? $MailDisposition['total'] : '',
        ];
        $Counter->InitAllCounter($Counts);

        return $next($request);
    }
}
