<?php

Route::group(['prefix' => 'impersonate'], function () {
    # Revert
    Route::get('revert', 'Pine\Impersonate\Http\Controllers\ImpersonateController@revert')->name('impersonate.revert');
    # Impersonate
    Route::get('{user}', 'Pine\Impersonate\Http\Controllers\ImpersonateController@impersonate')->name('impersonate.impersonate');
});
