<?php

namespace Juno\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Juno\Providers\JunoServiceProvider::class
        ];
    }
}
