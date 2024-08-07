<?php
namespace Concrete\Package\Dropbox\OAuth;

use \Exception;

class OAuthSimpleException extends Exception
{

    public function __construct($err, $isDebug = FALSE)
    {
        parent::__construct();
        self::log_error($err);
        if ($isDebug) {
            self::display_error($err, TRUE);
        }
    }

    public static function log_error($err)
    {
        error_log($err, 0);
    }

    public static function display_error($err, $kill = FALSE)
    {
        print_r($err);
        if($kill === FALSE) {
            die();
        }
    }
}