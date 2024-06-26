<?php

namespace Application\Constants;

use Concrete\Package\RelatedPages\Controller;
use \ORM;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Attribute\Select\Controller as SelectController;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueUsedOption;

/**
 * Class Attributes
 * @package Application\Constants
 */
class Attributes
{
    protected $em;

    // Website
    public const WEBSITE_PHONE = 'website_phone';
    public const WEBSITE_EMAIL = 'website_email';
    public const WEBSITE_ADDRESS = 'website_address';

    // Generic, navigation & banner
    public const ADDITIONAL_NAV_CLASSES = 'additional_nav_classes';
    public const MAIN_IMAGE = 'main_image';
    public const PAGE_HEADING = 'page_heading';
    public const PAGE_HEADING_DARK = 'page_heading_dark_color';
    public const PAGE_INTRO = 'page_intro';
    public const PAGE_TITLE_OVERRIDE = 'page_title_override';
    public const REDIRECT_TO_EXTERNAL_URL = 'redirect_to_external_url';
    public const SLIDESHOW_IMAGES = 'slideshow_images';

    public const SELECTED_PAGE_TYPE_HANDLE = 'selected_page_type_handle';
    public const TAGS = 'tags';

    // Article
    public const ARTICLE_TYPE = 'article_type';

    // Users
    public const USER_NAME = 'name';


    public function __construct()
    {
        $this->em = ORM::entityManager();
    }

    public function getSelectOptionById($id)
    {
        $repository = $this->em->getRepository(SelectValueOption::class);
        return $repository->findOneBy(['avSelectOptionID' => $id]);
    }

    public static function getSiteAttributeValue($attributeHandle)
    {
        return \Core::make('site')->getSite()->getAttribute($attributeHandle);
    }

    public function getSelectUsedOptions($attributeHandle, $asArray = false)
    {
        $attributeKey = $this->getAttributeKeyByHandle($attributeHandle);
        if (!$attributeKey) {
            return [];
        }
        $settings = $attributeKey->getAttributeKeySettings();
        $controller = $settings->getController();
        if (!($controller instanceof SelectController)) {
            return [];
        }
        $controller->setAttributeKey($settings->getAttributeKey());
        $optionList = $controller->getOptionUsageArray();
        if (!$asArray) {
            return $optionList;
        }

        $itemsList = [];
        /** @var SelectValueUsedOption $item */
        foreach ($optionList as $item) {
            $option = $this->em->getRepository(SelectValueOption::class)->find($item->getSelectAttributeOptionID());
            if(($option instanceof SelectValueOption) && !$option->isOptionDeleted()) {
                $itemsList[$option->getDisplayOrder()] = ['id' => $item->getSelectAttributeOptionID(), 'value' => $item->getSelectAttributeOptionValue()];
            }
        }
        $list = [];
        foreach ($itemsList as $item) {
            $list[$item['id']] = $item['value'];
        }
        asort($list);
        return $list;
    }

    public function getSelectOptions($attributeHandle, $alphaSort = false): array
    {
        $attributeKey = $this->getAttributeKeyByHandle($attributeHandle);
        if (!$attributeKey) {
            return [];
        }
        $controller = $attributeKey->getController();
        if (!($controller instanceof SelectController)) {
            return [];
        }

        $list = [];
        $optionList = $controller->getOptions();
        foreach ($optionList as $item) {
            $list[$item->getSelectAttributeOptionID()] = $item->getSelectAttributeOptionValue();
        }
        if ($alphaSort) {
            asort($list);
        }
        return $list;
    }

    public function getSelectOptionByValue($value)
    {
        return $this->em->getRepository(SelectValueOption::class)->findOneByValue($value);
    }

    public function getAttributeKeyByHandle($attributeHandle)
    {
        return $this->em->getRepository(Key::class)->findOneBy(['akHandle' => $attributeHandle]);
    }

    public function getPageOptions($attributeHandle): array
    {
        $attributeKey = $this->getAttributeKeyByHandle($attributeHandle);
        if (!$attributeKey) {
            return [];
        }
        $controller = $attributeKey->getController();

        if (!($controller instanceof \Concrete\Package\RelatedPages\Attribute\RelatedPages\Controller)) {
            return [];
        }
        $optionList = $controller->getPagesAsArray();
        return $optionList;
    }

    public static function getSelectOptionsAsQuery($queryParam, $options)
    {
        if(!is_array($options)) {
            return '';
        }
        $paramValues = [];
        foreach($options as $key=>$option) {
            $paramValues[$queryParam . '[' . $key . ']'] = $option;
        }
        return http_build_query($paramValues);
    }

}
