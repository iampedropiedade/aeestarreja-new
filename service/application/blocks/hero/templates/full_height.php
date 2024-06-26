<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;

$image = (new ImageCow(File::getById($this->controller->get('backgroundImageFileId')), 2545, 1264))->zoomCrop();
?>
<section class="hero-banner js-fullheight" id="section-block-<?php echo $this->controller->get('bID'); ?>">
    <div class="slider-item js-fullheight" style="background-image:url(<?php echo $image; ?>);">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
                <div class="col-md-8 text-center ftco-animate mt-5">
                    <div class="text">
                        <div class="subheading">
                            <span><?php echo $this->controller->get('subtitle'); ?></span>
                        </div>
                        <h1 class="mb-4"><?php echo $this->controller->get('title'); ?></h1>
                        <?php echo $this->controller->get('content'); ?>
                        <?php if($this->controller->get('buttonCaption')) : ?>
                            <p><a href="<?php echo $this->controller->get('buttonLink'); ?>" class="scrollto btn btn-primary py-2 px-4"><?php echo $this->controller->get('buttonCaption'); ?></a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
