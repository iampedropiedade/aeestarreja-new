<?php

namespace Concrete\Package\Picture\Adapter\PlaceImg;

use Concrete\Package\Picture\Adapter\AbstractImageEditor;

class PlaceImg extends AbstractImageEditor
{

    private const SOURCE_URL = 'http://placeimg.com/';

    /**
     * @param bool $webp
     * @return string
     */
    public function zoomCrop(bool $webp = false): string
    {
        return self::SOURCE_URL."{$this->width}/{$this->height}";
    }

}
