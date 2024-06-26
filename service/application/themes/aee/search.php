<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Area\Area;
use Application\Models\Page\Generic as SearchModel;
use Concrete\Core\Search\Pagination\Pagination;

$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true, 'headingReduced' => true]);

/** @var Pagination $pagination */
/** @var array $pages */
?>
<main id="main">

    <?php $this->inc('elements/widgets/errors.php'); ?>

    <section class="pb-5">
        <div class="container">
            <form method="get" action="<?php echo (new SearchModel())->getIndexPage()->getCollectionLink(); ?> " class="">
                <input class="search__input search__input--dark"
                       name="q"
                       type="search"
                       placeholder="pesquisar"
                       autocomplete="off"
                       autocorrect="off"
                       autocapitalize="off"
                       spellcheck="false"
                       value="<?php echo $query; ?>"
                />
            </form>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <?php if($query) : ?>
                <h2 class="heading--2 mb-3">Resultados de pesquisa para &ldquo;<?php echo $query; ?>&rdquo;</h2>
            <?php endif; ?>

            <div class="form" action="<?php echo $c->getCollectionLink(); ?>" method="get">
                <label for="q" class="sr-only">Search</label>
                <input type="hidden" name="q" id="q" value="<?php echo $query; ?>" data-element="text-input">
            </div>

            <div class="results-container">
                <?php if($pages) : ?>
                    <?php $this->inc('elements/pages/list.php'); ?>
                <?php else : ?>
                    <h5 class="heading--5 mb-5">Não foram encontrados resultados para a sua pesquisa, por favor tente por outras palavras.</h5>
                <?php endif; ?>
            </div>
            <?php if($pagination && $pagination->getTotalPages() > 1) : ?>
                <div class="text-xs-center mt-5">
                    <?php echo $pagination->renderDefaultView(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    $a = new Area('Main');
    $a->display($c);
    ?>

</main>

<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
