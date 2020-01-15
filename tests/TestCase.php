<?php

namespace Pine\Impersonate\Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Pine\Impersonate\ImpersonateServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected $admin, $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/factories');
        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->setUpDatabase();

        View::addNamespace('impersonate', __DIR__.'/views');

        Route::get('/impersonate-test', function () {
            return view("impersonate::impersonate");
        });

        Route::auth();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('impersonate.model', Models\User::class);
        $app['config']->set('impersonate.redirect.impersonate', '/impersonate-test');
        $app['config']->set('impersonate.redirect.revert', '/impersonate-test');
        $app['config']->set('auth.providers.users.model', Models\User::class);
    }

    protected function getPackageProviders($app)
    {
        return [ImpersonateServiceProvider::class];
    }

    protected function setUpDatabase()
    {
        $this->admin = factory(Models\User::class)->create();

        $this->user = factory(Models\User::class)->create();
    }
}
