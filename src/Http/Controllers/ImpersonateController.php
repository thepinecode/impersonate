<?php

namespace Pine\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ImpersonateController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
        $this->model = config('auth.providers.users.model');
    }

    /**
     * Impersonate the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        $user = $this->model::firstOrFail($id);
    }

    /**
     * Revert to the original user.
     *
     * @return \Illuminate\Http\Response
     */
    public function revert()
    {
        //
    }
}
