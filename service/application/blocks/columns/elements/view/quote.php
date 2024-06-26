<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<blockquote class="quote">
    <svg width="60" height="52"  class="quote__icon">
        <use xlink:href="/application/themes/rawnet/app/images/sprite.svg#quote"></use>
    </svg>
    <q class="quote__copy">
        <?php echo $item['quote']; ?>
    </q>
    <cite class="quote__cite"><?php echo $item['author']; ?></cite>
</blockquote>