<?php

namespace Concrete\Package\Picture\Adapter\Cloudfront;

use Concrete\Core\Entity\File\File;
use Concrete\Package\Picture\Adapter\AbstractImageEditor;

class Cloudfront extends AbstractImageEditor
{
    /** @var string */
    private $url;

    public function __construct(?File $file, int $width = 0, int $height = 0, array $attributes = [])
    {
        parent::__construct($file, $width, $height, $attributes);

        $this->url = \Config::get('app.cloudfrontUrl');
    }

    /**
     * @param bool $webp
     * @return string
     */
    public function zoomCrop(bool $webp = false): string
    {
        $prefix = $this->url . '/';

        if($this->width && $this->height) {
            $prefix .= $this->width . 'x' . $this->height;
        }

        if (is_string($this->file)) {
            $path = $this->file;
        }
        elseif(is_object($this->file)) {
            $version = $this->file->getApprovedVersion();

            /** @var \Concrete\Core\File\Service\Application $cf */
            $cf = \Core::make('helper/concrete/file');

            $path = $cf->prefix($version->getPrefix(), $version->getFileName());
        }
        else {
            return "";
        }

        if ($webp) {
            preg_match('/\.([a-z]+)$/i', $path, $matches);

            $ext = $matches[1];

            $prefix = $prefix . '/' . $ext;

            $path = preg_replace('/'.$ext.'$/', 'webp', $path);
        }

        return $prefix . $path;
    }
}
