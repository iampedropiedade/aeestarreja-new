<?php

namespace Concrete\Package\Picture\Adapter\PicSum;

use Concrete\Package\Picture\Adapter\AbstractSource;

class PicSumSource extends AbstractSource
{

    public function getImageEditorClass(): string
    {
        return PicSum::class;
    }

    public function getMarkup()
    {
        $markup = '';
        $src = '';

        $standard = $this->getImageEditor();

        if ($this->webp) {
            $standardWebpSrc = $standard->zoomCrop(true);
        }

        $src = $standard->zoomCrop();

        if ($this->retinaImage) {
            $retina = $this->getImageEditor(null, $this->width * 2, $this->height * 2);

            if ($this->webp) {
                $standardWebpSrc .= ' 1x, ' . $retina->zoomCrop(true) . ' 2x';
            }

            if ($this->tag === self::TAG_SOURCE) {
                $src .= ' 1x, ' . $retina->zoomCrop() . ' 2x';
            } else {
                $markup .= $this->sourceMarkup($src . ' 1x, ' . $retina->zoomCrop() . ' 2x');
            }
        }

        if ($this->webp) {
            $markup = $this->sourceMarkup($standardWebpSrc) . $markup;
        }


        if ($alternate = $this->alternativeSrc) {
            $src = $alternate;
            $this->lazyLoaded = false;
        }

        if ($src)
            $markup .= call_user_func([$this, $this->tag . 'Markup'], $src);

        return $markup;
    }

}
