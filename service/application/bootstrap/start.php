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
    array(
        'local' => array(
            'hostname',
        ),
        'staging' => array(
            'aeestarreja.staging.pedropiedade.com',
        ),
        'production' => array(
            'www.aeestarreja.pt',
        ),
    ));

return $app;
