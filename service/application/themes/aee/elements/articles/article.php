<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Core\Page\Page;
use Concrete\Core\Utility\Service\Text;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;
use Application\Constants\Attributes;
use Concrete\Core\Localization\Service\Date;

/** @var Page $page */
if(!$page || $page->isInTrash()) {
    return;
}
$text = new Text();
if($imageFile = $page->getAttribute(Attributes::MAIN_IMAGE)) {
    $image = (new ImageCow(File::getById($page->getAttribute(Attributes::MAIN_IMAGE)), 344, 350))->zoomCrop();
}
if(!isset($image)) {
    $image = $this->getThemePath() . '/app/images/news_article_default_listing.jpg';
}
/** @var Date $dateHelper */
$dateHelper = \Core::make('helper/date');
?>
<div class="col-md-4 d-flex ftco-animate">
    <div class="blog-entry justify-content-end">
        <?php if($image) : ?>
            <a href="<?php echo $page->getCollectionLink(); ?>" class="block-20" style="background-image: url('<?php echo $image; ?>');"></a>
        <?php endif; ?>

        <div class="text float-right d-block">
            <div class="d-flex align-items-center pt-2 mb-4 topp">
                <div class="one mr-2">
                    <span class="day"><?php echo $page->getCollectionDatePublicObject()->format('d'); ?></span>
                </div>
                <div class="two">
                    <span class="mos"><?php echo $dateHelper->date('F', $page->getCollectionDatePublicObject()->getTimestamp()); ?></span>
                    <span class="yr"><?php echo $page->getCollectionDatePublicObject()->format('Y'); ?></span>
                </div>
            </div>
            <?php $this->inc('elements/articles/tags.php', ['page'=>$page]); ?>
            <h3 class="heading"><a href="<?php echo $page->getCollectionLink(); ?>"><?php echo $page->getCollectionName(); ?></a></h3>
        </div>
    </div>
</div>
