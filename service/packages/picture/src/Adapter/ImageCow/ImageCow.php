<?php

namespace Concrete\Package\Picture\Adapter\ImageCow;

use Concrete\Package\Picture\Adapter\AbstractImageEditor;
use Imagecow\Image;

class ImageCow extends AbstractImageEditor
{
    /**
     * @param bool $crop
     * @return string
     */
    public function zoomCrop($crop=true): string
    {
        $cached = $this->cachedFilePath($crop);

        if (file_exists($cached)) {
            return $this->relativePath($cached);
        }
        if (!file_exists($file = DIR_BASE . $this->file->getApprovedVersion()->getRelativePath())) {
            return '';
        }
        $image = Image::fromFile($file);

        if($crop) {
            $image->resizeCrop($this->width, $this->height);
        }
        else {
            $image->resize($this->width);
        }

        $image->quality(\Config::get('concrete.misc.default_jpeg_image_compression'));
        $image->save($cached);
        return $this->relativePath($cached);
    }


    /**
     * @param string|null $crop
     * @return string
     */
    private function cachedFilePath(?string $crop = null)
    {
        $attributes = [
            $this->file->getFileID(),
            $this->file->getApprovedVersion()->getFileVersionID(),
            $this->width,
            $this->height,
            \Config::get('concrete.misc.default_jpeg_image_compression')
        ];

        $name = md5(serialize($attributes)) . ($crop ? '.crop.' : '') . '.' . $this->getExtension();
        return DIR_BASE . REL_DIR_FILES_CACHE . '/thumbnails/' . $name;
    }

    private function relativePath(string $fullpath) {
        return str_replace(DIR_BASE, '', $fullpath);
    }

    /**
     * @return string|string[]|null
     */
    private function getExtension()
    {
        return preg_replace('/[^\.]*\.([a-z0-9]+)$/i', '$1',$this->file->getApprovedVersion()->getFileName());
    }
}
