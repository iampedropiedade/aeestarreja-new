<?php

namespace Concrete\Package\Picture;

use Concrete\Package\Picture\Adapter\AbstractSource;

class Picture
{
    /** @var AbstractSource[]|array */
    private $sources;

    /** @var string */
    private $description;

    /** @var array */
    private $attributes;

    use RequiresAttributeMarkup;

    /**
     * Picture constructor.
     * @param array $sources
     * @param string $description
     * @param array $attributes
     */
    public function __construct(array $sources, string $description = '', array $attributes = [])
    {
        $this->sources = $this->setSourcesDriver($sources);
        $this->description = $description;
        $this->attributes = $attributes;
    }

    private function setSourcesDriver($sources)
    {
        $packageObject = \Package::getByHandle('picture');
        $driverClass = $packageObject->getFileConfig()->get('picture.driver');

        foreach ($sources as &$source) {
            $source = new $driverClass(...$source);
        }

        return $sources;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMarkup()
    {
        $sources = $this->sources;
        $imgSource = array_pop($sources);

        $markup = '<picture ' . $this->attributes($this->attributes) . '>';

        foreach ($sources as $source) {
            if (is_subclass_of($source, AbstractSource::class))
                $markup .= $source;
        }

        if ($imgSource && is_subclass_of($imgSource, AbstractSource::class))
            $markup .= $imgSource->setTag(AbstractSource::TAG_IMG)->setDescription($this->description);

        $markup .= '</picture>';

        return $markup;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        return $this->getMarkup();
    }

}
