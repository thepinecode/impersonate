<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | The class of the model what you want to impersonate. By default we use
    | the basic user class what Laravel provides.
    |
    */

   'model' => \App\User::class,

    /*
    |--------------------------------------------------------------------------
    | Middlewares
    |--------------------------------------------------------------------------
    |
    | You can define the middlewares, what you want to bind to the package's
    | controllers. By default, only the "auth" middleware is present. When
    | you need more security, you can add them here.
    |
    */

    'middlewares' => [
        'web',
        'auth',
        \Pine\Impersonate\Http\Middleware\CannotImpersonateItself::class,
        // 'can:impersonate,\App\User',
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    |
    | This is the route, where the controller action will redirect the user
    | after impersonating or reverting. You may use the route() helper,
    | for named routes.
    */

    'redirect' => [
        'impersonate' => '/home',
        'revert' => '/home',
    ],

];
