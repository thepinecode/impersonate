<?php

namespace Pine\Impersonate\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Pine\Impersonate\Events\ChangedToUser;
use Pine\Impersonate\Events\Reverted;

class ImpersonateController extends BaseController
{
    use AuthorizesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        foreach (config('impersonate.middlewares') as $middleware) {
            $this->middleware($middleware);
        }
    }

    /**
     * Impersonate the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        Session::put('original_user', Auth::user()->id);

        Auth::login($user = config('impersonate.model')::findOrFail($id));

        event(new ChangedToUser($user));

        return redirect(config('impersonate.redirect.impersonate'));
    }

    /**
     * Revert to the original user.
     *
     * @return \Illuminate\Http\Response
     */
    public function revert()
    {
        Auth::loginUsingId(Session::get('original_user'));

        Session::forget('original_user');

        event(new Reverted);

        return redirect(config('impersonate.redirect.revert'));
    }
}
