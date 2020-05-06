<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Satellite'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'domain' => env('APP_DOMAIN', 'localhost.loc'),
    'domain_dock' => env('APP_DOMAIN_DOCK', 'localhost.dock'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('Timezone', 'Asia/Jakarta'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'notification' => [
        'url' => env('APP_URL', 'http://satellite.loc'),
    ],
    'mail_approval_status' => [
        0 => 'Pending',
        1 => 'Receive',
        2 => 'Read',
        3 => 'Approved',
        4 => 'Receive Rejected',
        5 => 'Read Rejected',
        6 => 'Rejected'
    ],
    'mail_approval_color' => [
        0 => 'warning', //'Pending',
        1 => 'warning', //'Receive',
        2 => 'primary', //'Read',
        3 => 'success', //'Approved',
        4 => 'danger', //'Receive Reject',
        4 => 'danger', //'Read Rejected Message',
        6 => 'danger', //'Rejected'
    ],
    'mail_maker_status' => [
        0 => 'Draft',
        1 => 'Approved',
        2 => 'Approved',
        3 => 'Approved',
        4 => 'Approved',
        5 => 'Approved',
        6 => 'Receive Rejected'
    ],
    'mail_number_status' => [
        0 => 'Pending',
        1 => 'Received',
        2 => 'Read',
        3 => 'Approved'
    ],
    'mail_out_status' => [
        0 => 'Draft',
        1 => 'Pending',
        2 => 'Terkirim',
        3 => 'Terbaca',
        4 => 'Cancel',
        6 => 'Reject'
    ],
    'mail_in_status' => [
        '0' => 'Unread',
        '1' => 'Read'
    ],
    'mail_approval_type' => [
        0 => '',
        1 => 'Checker',
        2 => 'Signer'
    ],
    'jenis_user' => [
        1 => 'Admin Surat',
        2 => 'User',
        3 => 'Superadmin'
    ],
    'mail_to_type' => [
        1 => 'inbox',
        2 => 'disposition'
    ],
    'mail_to_status' => [
        0 => 'Unread',
        1 => 'Read'
    ],
    'mail_privacy_type' => [
        1 => 'Sangat Segera',
        2 => 'Segera',
        3 => 'Biasa',
        4 => 'Penting',
        5 => 'Rahasia'
    ],
    'mail_copy_to_status' => [
        0 => '',
        1 => ''
    ],
    'mail_out_status_color' => [
        0 => 'warning', //'Draft',
        1 => 'success', //'Menunggu Persetujuan',
        2 => 'primary', //'Terkirim',
        3 => 'primary', //'Terbaca',
        4 => 'danger', //'Cancel',
        6 => 'danger', //'Reject'
    ]
];
