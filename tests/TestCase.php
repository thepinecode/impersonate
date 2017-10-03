<?php

namespace Pine\Impersonate\Test;

use Illuminate\Support\Facades\Route;
use Pine\Impersonate\ImpersonateServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $admin, $user;

    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/factories');
        $this->loadLaravelMigrations(['--database' => 'testing']);

        $this->setUpDatabase();

        Route::auth();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('impersonate.model', Models\User::class);
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
