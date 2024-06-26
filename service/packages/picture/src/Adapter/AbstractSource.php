<?php

namespace Concrete\Package\Picture\Adapter;

use Concrete\Core\Entity\File\File;
use Concrete\Core\File\Service\Mime;
use Concrete\Core\Http\Request;
use Concrete\Core\Http\Service\Ajax;
use Concrete\Package\Picture\RequiresAttributeMarkup;
use Concrete\Core\Page\Page;

abstract class AbstractSource implements SourceInterface
{
    const TAG_IMG = 'img';
    const TAG_SOURCE = 'source';
    const TAG_TYPE = 'type';

    const BASE_IMG = '/application/themes/rawnet/app/images/interface/base.svg';
    protected $fill = '#209092';

    /** @var File */
    protected $file;

    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /** @var array */
    protected $attributes;

    /** @var string */
    protected $tag = self::TAG_SOURCE;

    /** @var string */
    protected $description = '';

    /** @var string */
    protected $alternativeSrc = '';

    /** @var bool */
    protected $lazyLoaded = true;

    /** @var bool */
    protected $retinaImage = true;

    /** @var bool */
    protected $webp = true;

    /** @var bool */
    protected $currentPageIsEditMode;

    use RequiresAttributeMarkup;

    /**
     * Source constructor.
     * @param File|null $file
     * @param int|null $width
     * @param int|null $height
     * @param array $attributes
     */
    public function __construct(?File $file, int $width = null, int $height = null, array $attributes = array())
    {
        $this->file = $file;
        $this->width = $width;
        $this->height = $height;
        $this->attributes = $attributes;

        $currentPage = Page::getCurrentPage();
        $this->currentPageIsEditMode = $currentPage ? $currentPage->isEditMode() : false;

        /** @var Ajax $ajax */
        $ajax = \Core::make(Ajax::class);

        if ($ajax->isAjaxRequest(Request::getInstance())) {
            $this->lazyLoaded = false;
        }
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description = '')
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $tag
     * @return $this
     * @throws \Exception
     */
    public function setTag($tag = self::TAG_SOURCE)
    {
        if (!in_array($tag, [self::TAG_IMG, self::TAG_SOURCE]))
            throw new \Exception('Only ' . self::TAG_SOURCE . ' and ' . self::TAG_IMG . ' tags are allowed');
        $this->tag = $tag;
        return $this;
    }

    /**
     * @param string $src
     * @return $this
     */
    public function setAlternativeSrc($src = '')
    {
        $this->alternativeSrc = $src;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLazyLoaded()
    {
        return $this->lazyLoaded && !$this->currentPageIsEditMode;
    }

    /**
     * @param bool $lazyLoaded
     * @return $this
     */
    public function setLazyLoaded(bool $lazyLoaded)
    {
        $this->lazyLoaded = $lazyLoaded;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasRetinaImage()
    {
        return $this->retinaImage;
    }

    /**
     * @param bool $retinaImage
     * @return $this
     */
    public function setRetinaImage(bool $retinaImage)
    {
        $this->retinaImage = $retinaImage;
        return $this;
    }

    /**
     * @return string
     */
    public function getMarkup()
    {
        $markup = '';
        $src = '';

        if ($file = $this->file) {

            if ($this->getExtension($file->getApprovedVersion()->getFileName()) !== 'svg') {

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
            } else {
                $this->alternativeSrc = $file->getApprovedVersion()->getRelativePath();
            }
        }

        if ($alternate = $this->alternativeSrc) {
            $src = $alternate;
            $this->lazyLoaded = false;
        }

        if ($src)
            $markup .= call_user_func([$this, $this->tag . 'Markup'], $src);

        return $markup;
    }

    /**
     * @param string $src
     * @return string
     */
    protected function sourceMarkup(string $src)
    {
        $allowedAttributes = [
            'media'
        ];

        $attributes = array_filter($this->commonAttributes(), function ($k) use ($allowedAttributes) {
            return in_array($k, $allowedAttributes);
        }, ARRAY_FILTER_USE_KEY);

        if ($this->isLazyLoaded()) {
            $attributes['srcset'] = $this->getBaseImg();
            $attributes['data-src'] = $src;
        } else {
            $attributes['srcset'] = $src;
        }

        $attributes['type'] = preg_match('/\.webp/', $src) ? 'image/webp' : $this->type();

        return '<source ' . $this->attributes($attributes) . '/>';
    }

    protected function getBaseImg()
    {
        return "data:image/svg+xml,".rawurlencode("<svg width='{$this->width}' height='{$this->height}' viewBox='0 0 {$this->width} {$this->height}' xmlns='http://www.w3.org/2000/svg'><rect x='0' y='0' width='{$this->width}' height='{$this->height}' rx='5' ry='5' fill='{$this->fill}' /></svg>");
    }

    /**
     * @param string $src
     * @return string
     */
    protected function imgMarkup(string $src)
    {
        $attributes = $this->commonAttributes();

        if ($this->isLazyLoaded()) {
            $attributes['src'] = $this->getBaseImg();
            $attributes['data-src'] = $src;
        } else {
            $attributes['src'] = $src;
        }

        $attributes['alt'] = $this->alt();
        return '<img ' . $this->attributes($attributes) . '/>';
    }

    /**
     * @return array
     */
    private function commonAttributes()
    {
        $attributes = $this->attributes;
        if ($this->isLazyLoaded()) {
            $attributes = $attributes + ['data-lazyload'=>'image', 'loading'=>'lazy'];
        }
        return $attributes;
    }

    /**
     * @return mixed|string
     */
    private function alt()
    {
        if (!$this->file) {
            return $this->description;
        }
        /** @var \Concrete\Core\Entity\File\Version $approvedFile */
        $approvedFile = $this->file->getApprovedVersion();

        return $approvedFile->getDescription() ?:
            str_replace(['-', '_'], ' ', preg_replace('/\.[a-z]+$/i', '', $approvedFile->getTitle()));
    }

    /**
     * @return mixed|string
     */
    private function type()
    {
        if (!$this->file) {
            return '';
        }
        /** @var \Concrete\Core\Entity\File\Version $approvedFile */
        $approvedFile = $this->file->getApprovedVersion();

        return (new Mime)->mimeFromExtension($this->getExtension($approvedFile->getFileName()));
    }

    /**
     * @param $filename
     * @return string
     */
    protected function getExtension($filename)
    {
        preg_match('/(?:.*)\.(.+)$/', $filename, $matches);

        return $matches[1] ?? '';
    }

    public function getImageEditor(?File $file = null, ?int $width = null, ?int $height = null, ?array $attributes = null)
    {
        $reflection = new \ReflectionClass($this->getImageEditorClass());
        return $reflection->newInstance($file ?: $this->file, $width ?: $this->width, $height ?: $this->height, $attributes ?: $this->attributes);
    }

    public function __toString()
    {
        return $this->getMarkup();
    }
}
