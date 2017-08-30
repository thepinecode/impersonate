<?php

Route::prefix('impersonate')->group(function ($router) {
    # Revert
    $router->get('revert', 'Pine\Impersonate\Http\Controllers\ImpersonateController@revert')->name('impersonate.revert');
    # Impersonate
    $router->get('{user}', 'Pine\Impersonate\Http\Controllers\ImpersonateController@impersonate')->name('impersonate.impersonate');
});
