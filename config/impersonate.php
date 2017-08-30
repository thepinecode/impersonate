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

   'model' => App\User::class,

    /*
    |--------------------------------------------------------------------------
    | Middlewares
    |--------------------------------------------------------------------------
    |
    | You can define the middlewares, what you want to bind to the package's
    | controllers. By default, only the "auth" middleware is present. When
    | you need more security (we're sure you need), you can add them here.
    |
    */

    'middlewares' => [
        'web',
        'auth',
        // 'can:impersonate',
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    |
    | This is the route, where the controller action will redirect the user
    | after impersonating or reverting.
    |
    */

    'redirect' => '/home',

];
