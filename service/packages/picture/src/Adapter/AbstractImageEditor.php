<?php

namespace Concrete\Package\Picture\Adapter;

use Concrete\Core\Entity\File\File;

abstract class AbstractImageEditor implements ImageEditorInterface
{
    /** @var ?File $file */
    protected $file;
    /** @var int  */
    protected $width;
    /** @var int  */
    protected $height;
    /** @var array */
    protected $attributes;

    /**
     * CloudfrontSource constructor.
     * @param File|null $file
     * @param int $width
     * @param int $height
     * @param array $attributes
     */
    public function __construct(?File $file, int $width = 0, int $height = 0, array $attributes = [])
    {
        $this->file = $file;
        $this->width = $width;
        $this->height = $height;
        $this->attributes = $attributes;
    }
}
