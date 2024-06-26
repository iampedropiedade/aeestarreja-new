<?php
defined('C5_EXECUTE') or die("Access Denied.");
$f = $controller->getFileObject();
$c = Page::getCurrentPage();
$fp = new Permissions($f);
?>

<?php if(($f && $fp->canViewFile()) || $c->isEditMode()) : ?>
    <section class="ftco-section py-5">
        <div class="container">
            <?php if($f && $fp->canViewFile()) : ?>
                <div class="text-center">
                    <a href="<?php echo $forceDownload ? $f->getForceDownloadURL() : $f->getDownloadURL(); ?>" class="btn btn-primary py-2 px-4"><?php echo stripslashes($controller->getLinkText()) ?></a></p>
                </div>
            <?php else : ?>
                <div class="ccm-edit-mode-disabled-item"><?=t('Empty Content Block.')?></div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
