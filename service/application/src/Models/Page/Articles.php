<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-11
 * Time: 11:16
 */
namespace Application\Models\Page;

use Application\Constants\Attributes;
use Concrete\Core\Page\Page;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;

/**
 * Class Articles
 * @package Application\Models\Page
 */
class Articles extends AbstractModel
{
    protected static $modelIndexPageTypeHandle = 'news_index';


    public static function getIndexPage()
    {
        return parent::getIndexPageByHandle(self::$modelIndexPageTypeHandle);
    }

    protected function setDefaults() : void
    {
        $this->itemsPerPage = 12;
        $this->modelPageType = ['news_article'];
    }

    public function filterBySelectMultipleOr($attributeHandle, $selectIds, $like=true)
    {
        if(!is_array($selectIds) || empty($selectIds)) {
            return;
        }
        $filter = $like ? 'like' : 'notLike';

        $expressions = array();
        $em = \Database::connection()->getEntityManager();
        $repository = $em->getRepository(SelectValueOption::class);
        foreach ($selectIds as $key => $selectId) {
            $option = $repository->findOneBy(['avSelectOptionID' => $selectId]);
            $column = 'ak_' . $attributeHandle;
            $expressions[] = $this->query->expr()->{$filter}($column, ':option_' . $attributeHandle . '_' . $key);
            $this->query->setParameter('option_' . $attributeHandle . '_' . $key, "%\n" . $option->getSelectAttributeOptionValue(false) . "\n%");
        }
        if (count($expressions)) {
            $this->query->andWhere(call_user_func_array(array($this->query->expr(), 'orX'), $expressions));
        }
    }

}