<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Package\Dropbox\Model\Folder;

assert(isset($folders));
/** @var Folder $folders */
?>
<section class="ftco-section my-5 py-0">
    <div class="container">
        <div class="row">
            <?php if($folders->hasContent()) : ?>
                <?php foreach($folders->getFolders() as $folder) : ?>
                    <div class="col-md-12 col-lg-6 col-xl-4">
                        <div class="file-wrap ftco-animate">
                            <a href="?path=<?php echo rawurlencode($folder->getPath()); ?>">
                                <div class="text p-4 d-flex align-items-center">
                                    <div class="file-content">
                                        <span class="time">
                                            <i class="fa-regular fa-folder"></i>
                                        </span>
                                        <h3><?php echo $folder->getDisplayName(); ?></h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php foreach($folders->getFiles() as $file) : ?>
                    <div class="col-md-12 col-lg-6 col-xl-4">
                        <div class="file-wrap ftco-animate">
                            <a href="<?php echo $file->getLink(); ?>" target="_blank">
                                <div class="text p-4 d-flex align-items-center">
                                    <div class="file-content">
                                        <span class="time"><i class="fa-regular fa-file-<?php echo $file->getIconExtension(); ?>"></i></span>
                                        <h3><?php echo $file->getDisplayName(); ?></h3>
                                        <div class="meta">
                                            <small><?php echo $file->getSize(); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <?php echo t('Não existem items para visualizar.'); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
