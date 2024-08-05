<?php

use Concrete\Core\Application\Application;

/*
 * ----------------------------------------------------------------------------
 * Instantiate concrete5
 * ----------------------------------------------------------------------------
 */
$app = new Application();

/*
 * ----------------------------------------------------------------------------
 * Detect the environment based on the hostname of the server
 * ----------------------------------------------------------------------------
 */
$app->detectEnvironment(
    [
        'development' => [
            'localhost',
        ],
        'staging' => [
            'aeestarreja.pedropiedade.com',
        ],
        'production' => [
            'aeestarreja.pt',
            'www.aeestarreja.pt',
        ],
    ]);
return $app;
