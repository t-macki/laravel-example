<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static $migrated = false;

    public function setUp()
    {
        if (!$this->app) {
            $this->refreshApplication();
        }
        if (!static::$migrated) {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');

            Artisan::call('migrate:refresh');
            Artisan::call('db:seed');
        }
        self::$migrated = true;

        parent::setUp();
    }
}
