<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-15
 * Time: 17:30
 */
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Page\Page;
use \Concrete\Core\File\File;
use \Application\Constants\Attributes;
use \Concrete\Package\Picture\Picture;

$page = Page::getByID($item['pageId']);
if(!($page instanceof Page)) {
    return false;
}

$mainImage = null;
if($item['imageId']) {
    $mainImage = File::getByID($item['imageId']);
}
if(!$mainImage) {
    $mainImage = $page->getAttribute(Attributes::MAIN_IMAGE);
}
if(!$mainImage) {
    $mainImage = $page->getAttribute(Attributes::BANNER_IMAGE);
}
?>
<article class="article article--small article--card">
    <a class="article__link" href="<?echo $page->getCollectionLink(); ?>">
        <?php if($mainImage) : ?>
            <figure class="article__figure">
                <?php echo new Picture([[$mainImage, 1024, 573, ['class' => 'article__img']]]); ?>
            </figure>
        <?php endif; ?>
        <div class="article__body">
            <h3 class="article__title"><?php echo $item['title'] ?: $page->getCollectionName(); ?></h3>
            <p><?php echo $item['description'] ?: $page->getCollectionDescription(); ?></p>
        </div>
    </a>
</article>

