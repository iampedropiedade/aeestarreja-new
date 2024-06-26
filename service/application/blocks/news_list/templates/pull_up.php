<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;
?>
<?php if($newsArticles) : ?>
    <section class="ftco-section bg-light ftco-event" id="section-block-<?php echo $bID; ?>">
        <div class="container container-fluid px-4 ftco-to-top">
            <div class="row justify-content-center mb-5 pb-5">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading"><?php echo $subtitle; ?></span>
                    <h2 class="mb-4"><?php echo $title; ?></h2>
                </div>
            </div>
            <?php $pageView->inc('elements/articles/list.php', ['newsArticles'=>$newsArticles]); ?>
            <?php if($indexPageUrl) : ?>
                <div class="row justify-content-center mb-0 pb-0">
                    <div class="col-md-8 text-center ftco-animate mt-5 fadeInUp ftco-animated">
                        <p><a href="<?php echo $indexPageUrl; ?>" class="btn btn-primary py-2 px-4"><?php echo $buttonCaption ?: t('Mais notícias'); ?></a></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>