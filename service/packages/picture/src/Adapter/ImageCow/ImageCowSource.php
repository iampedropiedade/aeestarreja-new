<?php

namespace Concrete\Package\Picture\Adapter\ImageCow;

use Concrete\Package\Picture\Adapter\AbstractSource;

class ImageCowSource extends AbstractSource {

    public function getImageEditorClass():string
    {
        return ImageCow::class;
    }
}
