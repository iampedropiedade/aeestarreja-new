<?php
$appSettings = [];

return [
    'theme_paths' =>
        [
            '/login'     => 'aee',
            '/register'  => 'aee',
            '/account/*' => 'aee',
            '\Throwable' => 'aee',
        ],
    'server_timezone' => 'Europe/Lisbon',
    'api_keys' =>
        [
            'google' =>
                [
                    'maps' => 'AIzaSyAPNFa-Cn1voBzqE0cvTda2ONF9DkIIl_I'
                ]
        ]
];