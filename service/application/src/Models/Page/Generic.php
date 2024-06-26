<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-06
 * Time: 14:21
 */
namespace Application\Models\Page;

/**
 * Class Generic
 * @package Application\Models\Page
 */
class Generic extends AbstractModel
{
    protected static $modelIndexPageTypeHandle = 'search';

    protected function setDefaults() : void
    {
        $this->itemsPerPage = 10;
        $this->modelPageType = false;
    }

    public static function getIndexPage()
    {
        return parent::getIndexPageByHandle(self::$modelIndexPageTypeHandle);
    }

}