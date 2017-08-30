<?php

namespace Pine\Impersonate\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Pine\Impersonate\Events\Reverted;
use Illuminate\Support\Facades\Session;
use Pine\Impersonate\Events\ChangedToUser;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ImpersonateController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs;

    /**
     * The user model class.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = config('impersonate.model');

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
        if ($id !== ($original = Auth::user()->id)) {
            Session::put('original_user', $original);

            Auth::login($user = $this->model::findOrFail($id));

            event(new ChangedToUser($user));
        }

        return redirect(config('impersonate.redirect'));
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

        return redirect(config('impersonate.redirect'));
    }
}
