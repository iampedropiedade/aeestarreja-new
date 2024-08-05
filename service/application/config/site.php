<?php
$siteSettings = [];

$secrets_file = dirname(__FILE__) . '/secrets.php';
if (file_exists($secrets_file)) include $secrets_file;

return $siteSettings;