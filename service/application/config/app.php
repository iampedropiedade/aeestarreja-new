<?php
$appSettings = [
    'theme_paths' =>
        [
            '/login'     => 'aee',
            '/register'  => 'aee',
            '/account/*' => 'aee',
            '\Throwable' => 'aee',
        ],
    'server_timezone' => 'Europe/Lisbon',
    'api_keys' => [
        'google' => [
            'maps' => 'AIzaSyAPNFa-Cn1voBzqE0cvTda2ONF9DkIIl_I'
        ]
    ],
    'sentry' => [
        'environment' => 'production',
    ],
];

$secrets_file = dirname(__FILE__) . '/secrets.php';
if (file_exists($secrets_file)) include $secrets_file;

return $appSettings;