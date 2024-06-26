<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Models\Page\Navigation;
use Application\Constants\Attributes;
use Concrete\Core\User\User;
use Concrete\Core\Validation\CSRF\Token;
use Application\Models\Page\Generic as SearchModel;

$navigation = new Navigation();
$navItems = $navigation->getNodes();
$navStyle = $navStyle ?? 'navbar-dark-faded';
$user = new User();

?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light site-navbar-target <?php echo $navStyle; ?>" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/"><img src='<?php echo $this->getThemePath() ?>/app/images/logo_aee_sublogos_left.png' style="width: 200px" alt="logo"></a>
        <button class="navbar-toggler js-fh5co-nav-toggle fh5co-nav-toggle" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
            <?php if(is_array($navItems) && !empty($navItems)) : ?>
                <ul class="navbar-nav nav ml-auto">
                    <?php foreach($navItems as $item) : ?>
                        <li class="nav-item">
                            <a href="<?php echo $item->getCollectionLink(); ?>" class="nav-link <?php echo $item->getAttribute(Attributes::ADDITIONAL_NAV_CLASSES); ?>"><span><?php echo $item->getCollectionName(); ?></span></a>
                            <?php
                            $navSubItems = $navigation->getNodes($item->cID);
                            ?>
                            <?php if($navSubItems) : ?>
                                <div class="dropdown-menu">
                                    <div class="row">
                                        <?php foreach($navSubItems as $subItem) : ?>
                                            <div class="col-xl-6 col-lg-12"><a href="<?php echo $subItem->getCollectionLink(); ?>"><?php echo $subItem->getCollectionName(); ?></a></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    <li class="nav-item">
                        <a id="btn-search" class="nav-link text-uppercase pb_letter-spacing-2 nav-button nav-search px-3" href="javascript:">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </li>
                    <?php if($user->isRegistered()) : ?>
                        <?php $url = URL::to('/login', 'do_logout', id(new Token())->generate('do_logout')); ?>
                        <li class="nav-item">
                            <a href="<?php echo $url; ?>" class="nav-link"><span><?php echo t('Logout'); ?></span></a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="/ccm/system/authentication/oauth2/google/attempt_auth" class="nav-link"><span><?php echo t('Login'); ?></span></a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="search">
    <div class="container">
        <div class="row">
            <button id="btn-search-close" class="btn--search-close" aria-label="Close search form">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <form method="get" action="<?php echo (SearchModel::getIndexPage())->getCollectionLink(); ?> " class="search__form">
                <input class="search__input" name="q" type="search" placeholder="pesquisar" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                <span class="search__info">Pressione ENTER para procurar ou ESC para sair</span>
            </form>
        </div>
        <div class="row">
            <div class="search__suggestion">
                <h3>Podemos sugerir...</h3>
                <p>projeto educativo, oferta formativa, convocatórias, contactos</p>
            </div>
        </div>
    </div>
</div>
