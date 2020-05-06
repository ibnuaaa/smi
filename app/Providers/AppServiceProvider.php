<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Support\Response\Json;
use App\Support\Realtime\Realtime;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Configs
        $this->app->configure('app');
        $this->app->configure('auth');
        $this->app->configure('cors');
        $this->app->configure('database');
        $this->app->configure('hashing');
        $this->app->configure('filesystems');

        // Providers
        $this->app->register(\App\Providers\AuthServiceProvider::class);
        $this->app->register(\App\Providers\EventServiceProvider::class);
        $this->app->register(\App\Providers\MiddlewareServiceProvider::class);
        $this->app->register(\Laravel\Passport\PassportServiceProvider::class);
        $this->app->register(\Dusterio\LumenPassport\PassportServiceProvider::class);
        $this->app->register(\Barryvdh\Cors\ServiceProvider::class);

        // $this->app->register(\Vueone\CaptchaLumen\CaptchaServiceProvider::class);
        // class_alias('Vueone\CaptchaLumen\Facades\Captcha', 'Captcha');

        // \Dusterio\LumenPassport\LumenPassport::routes($this->app, ['prefix' => 'v1/oauth']);
        $this->app->singleton('filesystem', function ($app) {
            return $app->loadComponent('filesystems', 'Illuminate\Filesystem\FilesystemServiceProvider', 'filesystem');
        });

        $this->app->withEloquent();

        Json::set('timestamp', Carbon::now());
        Json::set('environment', env('APP_ENV'));
        app('translator')->setLocale('id');

        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
                return $value;
            });
        });
        \Illuminate\Support\Collection::macro('toArrayDeep', function () {
            return json_decode(json_encode($this), true);
        });
        $this->routes();
    }

    public function boot()
    {
        // Passport::tokensCan([
        //     'blast' => 'Blast'
        // ]);

        app('view');
        app('blade.compiler')->directive('scopedslot', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);
            // Ensure that the directive's arguments array has 3 elements - otherwise fill with `null`
            $directiveArguments = array_pad($directiveArguments, 3, null);
            // Extract values from the directive's arguments array
            [$name, $functionArguments, $functionUses] = $directiveArguments;
            // Connect the arguments to form a correct function declaration
            if ($functionArguments) $functionArguments = "function {$functionArguments}";
            if ($functionUses) $functionUses = " use {$functionUses}";
            return "<?php \$__env->slot({$name}, {$functionArguments}{$functionUses} { ?>";
        });
        app('blade.compiler')->directive('endscopedslot', function () {
            return "<?php }); ?>";
        });
    }

    private function routes()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $DOMAIN = $_SERVER['HTTP_HOST'];
            if ($DOMAIN === 'satellite-' . config('app.domain') || $DOMAIN === 'satellite.' . config('app.domain_dock')) {
                $this->apiRoute();
            } else {
                $this->webRoute();
            }
        } else {
            $this->webRoute();
        }
    }

    private function webRoute()
    {
        $this->app->router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
            require __DIR__.'/../../routes/webPublic.php';
        });
        $this->app->router->group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth.cms']], function ($router) {
            require __DIR__.'/../../routes/web.php';
        });
    }

    private function apiRoute()
    {
        $this->app->router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
            require __DIR__.'/../../routes/apiPublic.php';
        });

        $this->app->router->group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth.api']], function ($router) {
            require __DIR__.'/../../routes/api.php';
        });
    }
}
