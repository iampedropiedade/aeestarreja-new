<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Area\Area;
$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true]);
?>
<main>
    <?php
    $a = new Area('Main');
    $a->display($c);
    ?>

    <?php if($meetings || $addMeeting) : ?>
        <section class="ftco-section py-5">
            <div class="container container-fluid">
                <div class="col-md-12 text-center ftco-animate mb-5 fadeInUp ftco-animated">
                    <?php if($addMeeting) : ?>
                        <a class="btn btn-primary py-2 px-4" href="<?php echo $addMeeting->getCollectionLink(); ?>"><?php echo $addMeeting->getCollectionName(); ?></a>
                    <?php endif; ?>
                </div>
                <?php if($meetings) : ?>
                    <?php $this->inc('elements/meetings/list.php', ['meetings'=>$meetings]); ?>
                    <div class="text-xs-center mt-5">
                        <?php echo $pagination->renderDefaultView(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
