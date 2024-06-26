<?php

namespace Concrete\Package\Picture\Adapter;

use Concrete\Core\Entity\File\File;

interface ImageEditorInterface {
    /**
     * ImageEditorInterface constructor.
     * @param File|null $file
     * @param int $width
     * @param int $height
     * @param array $attributes
     */
    public function __construct(?File $file, int $width = 0, int $height = 0, array $attributes = []);

    /**
     * @param bool $webp
     * @return string
     */
    public function zoomCrop(bool $webp = false): string;
}
