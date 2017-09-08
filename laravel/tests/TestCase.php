<?php namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BasetestCase
{
    use CreatesApplication;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('DB_CONNECTION=integration_testing');

        $app = require __DIR__ . '/../../laravel/bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        \Artisan::call('migrate');
    }

    public function tearDown()
    {
        \Artisan::call('migrate:reset');
        parent::tearDown();
    }
}