<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Area\Area;
use Application\Constants\Attributes;
use Application\Models\Page\Articles;

$model = new Articles();
$indexPageLink = $model::getIndexPage()->getCollectionLink();

$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true, 'defaultImage'=>$this->getThemePath() . '/app/images/news_article_default_banner.jpg']);
?>
<main>
    <?php if($tags = $c->getAttribute(Attributes::TAGS)) : ?>
        <section class="pt-1">
            <div class="container">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <?php foreach($tags as $tag) : ?>
                            <?php $filters = Attributes::getSelectOptionsAsQuery(Attributes::TAGS, [$tag->getSelectAttributeOptionID()]); ?>
                            <a class="badge badge-info px-4 py-3 badge-pill" href="<?php echo $indexPageLink . ($filters ? '?' . $filters : ''); ?>"><?php echo $tag; ?></a>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <a class="btn btn-sm btn-primary py-2 px-4" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $c->getCollectionLink(); ?>" target="_blank"><i class="fa-brands fa-facebook mr-2"></i> Partilhar</a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php if($content = $c->getAttribute('content')) : ?>
        <section class="ftco-section py-5">
            <div class="container">
                <div class="row">
                    <?php echo $content; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $a = new Area('Main');
    $a->display($c);
    ?>

    <?php $this->inc('elements/widgets/slideshow.php'); ?>

    <?php
    $a = new Area('Bottom');
    $a->display($c);
    ?>

</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
