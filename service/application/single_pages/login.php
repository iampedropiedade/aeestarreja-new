<?php
use Concrete\Core\Attribute\Key\Key;
use Concrete\Core\Http\ResponseAssetGroup;
defined('C5_EXECUTE') or die('Access denied.');
$r = ResponseAssetGroup::get();
$r->requireAsset('javascript', 'underscore');
$r->requireAsset('javascript', 'core/events');
$form = Loader::helper('form');
if (isset($authType) && $authType) {
    $active = $authType;
    $activeAuths = array($authType);
} else {
    $active = null;
    $activeAuths = AuthenticationType::getList(true, true);
}
if (!isset($authTypeElement)) {
    $authTypeElement = null;
}
if (!isset($authTypeParams)) {
    $authTypeParams = null;
}
?>
<?php
$a = new Area('Login');
$a->display($c);
?>
<?php foreach ($activeAuths as $auth) : ?>
    <div data-handle="<?php echo $auth->getAuthenticationTypeHandle() ?>"
        class="authentication-type authentication-type-<?php echo $auth->getAuthenticationTypeHandle() ?>">
        <?php $auth->renderForm($authTypeElement ?: 'form', $authTypeParams ?: array()) ?>
    </div>
<?php endforeach; ?>
