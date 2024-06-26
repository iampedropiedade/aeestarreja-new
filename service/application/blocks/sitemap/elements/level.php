<?php
defined('C5_EXECUTE') or die('Access Denied.');
$env = Environment::get();
?>
<?php if($sitemapPageList) : ?>
    <ul class="list">
        <?php foreach($sitemapPageList as $page) : ?>
            <li class="">
                <a class="list__link" href="<?php echo $page['page']->getCollectionLink(); ?>"><?php echo $page['page']->getCollectionName(); ?></a>
                <?php
                    if($page['children'] && is_array($page['children']) && !empty($page['children'])) {
                        $sitemapPageList = $page['children'];
                        include $env->getPath(DIRNAME_BLOCKS . '/sitemap/elements/level.php');
                    }
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>