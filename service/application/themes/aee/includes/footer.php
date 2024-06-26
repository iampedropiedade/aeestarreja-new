<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Constants\Attributes;
use Application\Models\Page\Navigation;

$navigation = new Navigation();
$navItems = $navigation->getNodes();
?>
<footer class="ftco-footer ftco-bg-dark ftco-section pt-5 pb-2">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md">
                <div class="ftco-footer-widget mb-3">
                    <h2 class="ftco-heading-2">Agrupamento</h2>
                    <p>Na <span>aventura</span> da aprendizagem!</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-left">
                        <li class="ftco-animate"><a href="https://www.facebook.com/AgrupamentoEscolasEstarreja/"><span class="fa-brands fa-facebook"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-3 ml-md-5">
                    <h2 class="ftco-heading-2">Morada</h2>
                    <p><?php echo nl2br(Attributes::getSiteAttributeValue(Attributes::WEBSITE_ADDRESS)); ?></p>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-3">
                    <h2 class="ftco-heading-2">Contactos</h2>
                    <p><a href="tel:<?php echo Attributes::getSiteAttributeValue(Attributes::WEBSITE_PHONE); ?>"><?php echo Attributes::getSiteAttributeValue(Attributes::WEBSITE_PHONE); ?></a></p>
                    <p><?php echo Attributes::getSiteAttributeValue(Attributes::WEBSITE_EMAIL); ?></p>
                    <p>secretaria@aeestarreja.pt</p>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-3">
                    <h2 class="ftco-heading-2">RGPD</h2>
                    <p><a href="/agrupamento/politica-de-privacidade">RGPD e política de privacidade</a></p>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p><small>Copyright &copy;<script>document.write(new Date().getFullYear());</script> AEE, todos os direitos reservados.</small></p>
            </div>
        </div>
    </div>
</footer>
