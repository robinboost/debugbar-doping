<?php

namespace Robinboost\DebugbarDoping\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Robinboost\DebugbarDoping\DebugbarDopingServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            DebugbarDopingServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
