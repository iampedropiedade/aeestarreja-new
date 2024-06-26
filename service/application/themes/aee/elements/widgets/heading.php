<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;
use Application\Constants\Attributes;

$image = false;
if(isset($headingImage)) {
    $imageFileAttr = $c->getAttribute(Attributes::MAIN_IMAGE);
    if ($imageFileAttr) {
        $imageFile = File::getById($imageFileAttr);
        if ($imageFile) {
            $image = (new ImageCow($imageFile, 2545, 1440))->zoomCrop();
        }
    }
}
if(!$image && isset($defaultImage)) {
    $image = $defaultImage;
}
$heading = $c->getAttribute(Attributes::PAGE_HEADING);
$headingDark = $c->getAttribute(Attributes::PAGE_HEADING_DARK);
?>
<section class="ftco-intro <?php echo $image ? 'img' : 'ftco-intro__short'; ?>"
         <?php if ($image) : ?>
            style="background-image: url(<?php echo $image; ?>);"
         <?php endif; ?>
>
    <?php if ($image) : ?>
        <div class="overlay"></div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 heading-section <?php echo ($headingDark || !$image) ? 'heading-section__dark' : ''; ?> text-center">
                <?php if($heading) : ?>
                    <span class="subheading"><?php echo $heading; ?></span>
                <?php endif; ?>
                <h1 class="mb-4"><?php echo $c->getAttribute(Attributes::PAGE_TITLE_OVERRIDE) ?: $c->getCollectionName(); ?></h1>
                <?php echo $c->getAttribute(Attributes::PAGE_INTRO); ?>
            </div>
        </div>
    </div>
</section>
<?php $this->inc('elements/widgets/breadcrumbs.php'); ?>