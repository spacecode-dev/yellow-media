<?php

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var string
     */
    protected string $login = 'user@gmail.com';

    /**
     * @var string
     */
    protected string $password = 'password';

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
