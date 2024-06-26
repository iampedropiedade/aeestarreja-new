<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Application\Constants\Attributes;
use Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value\MultipleFilesValue;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;

/** @var MultipleFilesValue $slideshowImages */
$slideshowImages = $c->getAttribute(Attributes::SLIDESHOW_IMAGES);
if(!$slideshowImages) {
    return;
}
?>
<section class="mb-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="owl-carousel" data-behaviour="carousel">
                    <?php foreach($slideshowImages->getFileObjects() as $slideshowImage) : ?>
                        <?php $image = (new ImageCow($slideshowImage, 1110, 700))->zoomCrop(); ?>
                        <img src="<?php echo $image; ?>" />
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
