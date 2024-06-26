<?php
namespace Concrete\Package\Dropbox\Dropbox;

use Exception;

class DropboxException extends Exception
{
    private $tag;

    public function __construct($resp = null, $context = null)
    {
        if (is_null($resp)) {
            $el = error_get_last();
            $this->message = $el['message'];
            $this->file = $el['file'];
            $this->line = $el['line'];
        } else {
            $this->message = json_encode($resp) . ($context ? ", in $context" : "");
            $this->tag = $resp->error->{'.tag'};
        }
    }

    public function getTag()
    {
        return $this->tag;
    }
}