<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;

$image = (new ImageCow(File::getById($backgroundImageFileId), 2545, 1264))->zoomCrop();
?>
<section class="ftco-intro img" id="section-block-<?php echo $bID; ?>" style="background-image: url(<?php echo $image; ?>);">
    <div class="overlay"></div>
    <div class="container">
    </div>
</section>
