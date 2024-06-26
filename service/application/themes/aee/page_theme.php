<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-14
 * Time: 10:11
 */
namespace Application\Theme\Rawnet;

use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;

class PageTheme extends Theme implements ThemeProviderInterface
{
    public function getThemeAreaLayoutPresets()
    {
        $presets = [
            [
                'handle' => 'two_col',
                'name' => 'Two Columns',
                'container' => '<div class="grid grid--2-col grid--gutter-small wysiwyg"></div>',
                'columns' => [
                    '<div class="grid__item"></div>',
                    '<div class="grid__item"></div>'
                ],
            ],
        ];

        return $presets;
    }

    public function getThemeEditorClasses()
    {
        $styles = [
            [
                'title' => 'Unordered list',
                'element' => 'ul',
                'attributes' => ['class' => 'list-group']
            ],
            [
                'title' => 'Unordered list item',
                'element' => 'li',
                'attributes' => ['class' => 'list-group-item']
            ],
            [
                'title' => 'Underline',
                'element' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                'attributes' => ['class' => 'heading--underline']
            ],
            [
                'title' => 'Underline center',
                'element' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                'attributes' => ['class' => 'heading--underline heading--underline-center']
            ],
            [
                'title' => 'Light',
                'element' => 'hr',
                'attributes' => ['class' => 'hr--light']
            ],
            [
                'title' => 'Default button',
                'element' => ['button', 'a'],
                'attributes' => ['class' => 'button']
            ],
            [
                'title' => 'Button secondary',
                'element' => ['button', 'a'],
                'attributes' => ['class' => 'button button--secondary']
            ],
            [
                'title' => 'Img Center',
                'element' => 'img',
                'attributes' => ['class' => 'u-img-center']
            ],
            [
                'title' => 'Img left',
                'element' => 'img',
                'attributes' => ['class' => 'u-img-left']
            ],
            [
                'title' => 'Img right',
                'element' => 'img',
                'attributes' => ['class' => 'u-img-right']
            ],


        ];
        return array_merge($styles, $this->getColors(), $this->getSizes());
    }

    protected function getColors() : array
    {
        $colors = [];
        $colorNames = ['red'];
        foreach($colorNames as $color) {
            $colors[] = [
                'title' => sprintf('Color %s', ucwords(str_replace('-', ' ', $color))),
                'element' => 'span',
                'attributes' => ['class' => sprintf('u-color-%s', $color)]
                ];
        }
        return $colors;
    }


}
