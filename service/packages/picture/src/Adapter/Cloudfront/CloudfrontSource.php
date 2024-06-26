<?php

namespace Concrete\Package\Picture\Adapter\Cloudfront;

use Concrete\Package\Picture\Adapter\AbstractSource;

class CloudfrontSource extends AbstractSource {

    public function getImageEditorClass():string
    {
        return Cloudfront::class;
    }
}
