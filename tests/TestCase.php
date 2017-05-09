<?php

namespace Xuplau\Test;

use Silex\WebTestCase;
use Xuplau\Provider\CacheServiceProvider;
use Xuplau\Provider\RouteServiceProvider;
use Xuplau\Provider\TwigServiceProvider;

class TestCase extends WebTestCase
{
    /**
     * Creates the application.
     * @return \Silex\Application
     *
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap.php';
        $app->register(new RouteServiceProvider);
        $app->register(new CacheServiceProvider);
        $app->register(new TwigServiceProvider);
        return $app;

    }


}
