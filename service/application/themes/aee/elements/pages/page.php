<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;
use Application\Constants\Attributes;

$imageFileAttr = $page->getAttribute(Attributes::MAIN_IMAGE);
if($imageFileAttr) {
    $imageFile = File::getById($imageFileAttr);
    if ($imageFile) {
        $image = (new ImageCow($imageFile, 1525, 1525))->zoomCrop();
    }
}
if(!isset($image)) {
    $image = $this->getThemePath() . '/app/images/page_default.jpg';
}
/** var Page $page; */

$href = $page->getCollectionLink();
if($externalUrl = $page->getAttribute(Attributes::REDIRECT_TO_EXTERNAL_URL)) {
    $href = $externalUrl;
}
?>
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="page-wrap ftco-animate fadeInUp ftco-animated">
        <a href="<?php echo $href; ?>" <?php echo $externalUrl ? 'target="_blank"' : ''; ?>>
            <div class="img d-flex align-items-center justify-content-center" style="background-image: url(<?php echo $image; ?>);">
                <div class="text-content p-4 text-center">
                    <h3><?php echo $page->getCollectionName(); ?></h3>
                </div>
            </div>
        </a>
    </div>
</div>