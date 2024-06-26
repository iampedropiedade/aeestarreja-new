<?php

namespace Concrete\Package\Picture\Adapter\PicSum;

use Concrete\Package\Picture\Adapter\AbstractImageEditor;
use Imagecow\Image;

class PicSum extends AbstractImageEditor
{

    private const SOURCE_URL = 'https://picsum.photos/';

    /**
     * @param bool $webp
     * @return string
     */
    public function zoomCrop(bool $webp = false): string
    {
        return self::SOURCE_URL."{$this->width}/{$this->height}?random";
    }

}
