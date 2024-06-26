<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Models\Page\Navigation;
use Application\Constants\Attributes;

$navigation = new Navigation();
$breadcrumbs = $navigation->getBreadcrumbs();
?>
<?php if($breadcrumbs) : ?>
    <section class="ftco-section py-0">
        <nav aria-label="breadcrumb">
            <div class="container">
                <ol class="breadcrumb breadcrumbs--style">
                    <?php foreach($breadcrumbs as $breadcrumb) : ?>
                        <?php $active = $breadcrumb->cID === $c->cID; ?>
                        <li class="breadcrumb-item <?php echo $active ? 'active' : ''; ?>" <?php echo $active ? 'aria-current="page"' : ''; ?>>
                            <?php if(!$active) : ?>
                                <a href="<?php echo $breadcrumb->getCollectionLink(); ?>"><?php echo $breadcrumb->getCollectionName(); ?></a>
                            <?php else : ?>
                                <?php echo $breadcrumb->getCollectionName(); ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </nav>
    </section>
<?php endif; ?>