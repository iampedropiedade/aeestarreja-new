<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php echo $this->controller->getEditAssets($view); ?>
<div class="form-group">
    <h4><?php echo t('Images'); ?></h4>
</div>
<div class="form-group" data-behaviour="item-list-block">
    <div class="card-item-list-block"> 
    	<div data-target="list-container">
            <?php foreach($items as $key=>$value) : ?>
                <?php echo $controller->action_load_list_item($value, false); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div>
        <?php echo $this->controller->getEditButtons(); ?>
    </div>
</div>