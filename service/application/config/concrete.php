<?php
$concreteSettings = [
    'locale' => 'pt_PT',
    'version_installed' => '8.5.1',
    'version_db_installed' => '20190301133300',
    'misc' => [
        'login_redirect' => 'CUSTOM',
        'access_entity_updated' => 1571429263,
        'latest_version' => '8.5.1',
        'do_page_reindex_check' => false,
        'login_redirect_cid' => 889,
    ],
    'seo' => [
        'redirect_to_canonical_url' => 1,
        'url_rewriting' => true,
    ],
    'user' => [
        'registration' => [
            'email_registration' => true,
            'type' => 'disabled',
            'captcha' => false,
            'display_username_field' => true,
            'display_confirm_password_field' => true,
            'enabled' => false,
            'notification' => false,
        ],
    ],
    'cache' => [
        'last_cleared' => 1719401142,
        'blocks' => false,
        'assets' => true,
        'theme_css' => false,
        'overrides' => true,
        'pages' => 'all',
        'full_page_lifetime' => 'default',
        'full_page_lifetime_block' => false,
    ],
    'email' => [
        'default' => [
            'address' => 'website@aeestarreja.pt',
            'name' => 'Agrupamento de Escolas de Estarreja',
        ],
        'forgot_password' => [
            'address' => 'website@aeestarreja.pt',
            'name' => 'Agrupamento de Escolas de Estarreja',
        ],
        'workflow_notification' => [
            'address' => 'website@aeestarreja.pt',
            'name' => 'Agrupamento de Escolas de Estarreja',
        ],
    ],
    'theme' => [
        'compress_preprocessor_output' => false,
        'generate_less_sourcemap' => false,
    ],
    'upload' => [
        'extensions' => '*.flv;*.jpg;*.gif;*.jpeg;*.ico;*.docx;*.xla;*.png;*.psd;*.swf;*.doc;*.txt;*.xls;*.xlsx;*.csv;*.pdf;*.tiff;*.rtf;*.m4a;*.mov;*.wmv;*.mpeg;*.mpg;*.wav;*.3gp;*.avi;*.m4v;*.mp4;*.mp3;*.qt;*.ppt;*.pptx;*.kml;*.xml;*.svg;*.webm;*.ogg;*.ogv;*.zip',
    ],
    'security' => [
        'session' => [
            'invalidate_on_ip_mismatch' => false,
        ],
    ],
];

$secrets_file = dirname(__FILE__) . '/secrets.php';
if (file_exists($secrets_file)) include $secrets_file;

return $concreteSettings;