<?php

namespace Concrete\Package\Picture;

trait RequiresAttributeMarkup
{
    /**
     * @param array $attributes
     * @return string
     */
    public function attributes(array $attributes)
    {
        return implode(' ', array_map(function ($k, $v) {
            return $k . '="' . htmlspecialchars($v, ENT_QUOTES) . '"';
        }, array_keys($attributes), $attributes));
    }
}