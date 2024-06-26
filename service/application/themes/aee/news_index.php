<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Area\Area;
$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true]);;
?>
<main>

    <?php if(is_array($tagsList) && count($tagsList) > 0) : ?>
        <section class="py-5">
            <div class="container container-fluid">
                <div class="text-xs-center">
                    <form method="get">
                        <select name="tags[]" data-behaviour="select2" class="form-control form-control-lg" onchange="this.form.submit()">
                            <?php foreach($tagsList as $key=>$tag): ?>
                                <option value="<?php echo $key; ?>" <?php echo is_array($tags) && in_array($key, $tags) ? 'selected' : ''; ?>><?php echo $tag; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <?php if(is_array($tags) && count($tags) > 0) : ?>
                    <div class="py-2">
                        <?php $this->inc('elements/articles/tags_filter.php', ['tags'=>$tags]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if($newsArticles) : ?>
        <section class="ftco-section ftco-section py-5">
            <div class="container container-fluid">
                <?php $this->inc('elements/articles/list.php', ['newsArticles'=>$newsArticles]); ?>
                <div class="text-xs-center mt-5">
                    <?php echo $pagination->renderDefaultView(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    $a = new Area('Main');
    $a->display($c);
    ?>
</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
