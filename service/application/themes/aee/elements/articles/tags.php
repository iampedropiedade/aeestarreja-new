<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Application\Constants\Attributes;
use Application\Models\Page\Articles;
use Concrete\Core\Page\Page;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValue;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;

/** @var Page $page */
if(!$page->cID) {
    return;
}

/** @var SelectValueOption $tag */
$tags = $page->getAttribute(Attributes::TAGS);
if(!($tags instanceof SelectValue)) {
    return;
}
$model = new Articles();
$indexPageLink = $model::getIndexPage()->getCollectionLink();
?>
<div class="topg">
    <?php foreach($tags as $tag) : ?>
        <?php $filters = Attributes::getSelectOptionsAsQuery(Attributes::TAGS, [$tag->getSelectAttributeOptionID()]); ?>
        <a class="badge badge-info px-4 py-2 badge-pill" href="<?php echo $indexPageLink . ($filters ? '?' . $filters : ''); ?>"><?php echo $tag; ?></a>
    <?php endforeach; ?>
</div>