<?php
defined('C5_EXECUTE') or die('Access Denied.');

?>
<section class="ftco-section contact-section ftco-no-pb bg-light" id="section-block-<?php echo $bID; ?>">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading"><?php echo $heading; ?></span>
                <h2 class="mb-4"><?php echo $title; ?></h2>
            </div>
        </div>

        <div class="row block-9">
            <div class="col-md-4 d-flex">
                <div class="row box d-flex contact-info mb-5">
                    <div class="icon mr-3">
                        <span class="icon-map-signs"></span>
                    </div>
                    <div>
                        <h3 class="mb-3">Endereço</h3>
                        <p>
                            <?php echo nl2br($address); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="row box d-flex contact-info mb-5">
                    <div class="icon mr-3">
                        <span class="icon-phone2"></span>
                    </div>
                    <div>
                        <h3 class="mb-3">Telefone</h3>
                        <p><a href="tel://<?php echo str_replace(['+', ' '], ['00', ''], $phone); ?>"><?php echo $phone; ?></a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="row box d-flex contact-info mb-5">
                    <div class="icon mr-3">
                        <span class="icon-paper-plane"></span>
                    </div>
                    <div>
                        <h3 class="mb-3">Email</h3>
                        <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
