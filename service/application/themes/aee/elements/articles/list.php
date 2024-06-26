<?php
defined('C5_EXECUTE') or die('Access Denied.');

/** @var ?array $newsArticles */
if(empty($newsArticles) || !is_array($newsArticles)) {
    return;
}
?>
<div class="row d-flex">
    <?php foreach($newsArticles as $page) : ?>
        <?php $this->inc('elements/articles/article.php', ['page'=>$page, 'defaultImage'=>$this->getThemePath() . '/app/images/news_article_default_banner.jpg']); ?>
    <?php endforeach; ?>
</div>
