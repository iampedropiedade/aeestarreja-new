<?php
defined('C5_EXECUTE') or die('Access Denied.');
$editor = \Core::make('editor')->outputStandardEditor('wysiwyg_editor_init', '');
?>
<script>
$(document).ready(function() {

    let $itemListContainerWrapper = $('[data-behaviour="item-list-block"]');
    let $itemListContainer = $itemListContainerWrapper.find('[data-target="list-container"]');
    let maxItems = <?php echo $maxNumberOfItems; ?>

    function minimizeCards() {
        $('[data-target="list-container"] .list_item').addClass("inactive");
        return true;
    }

    function updateCards() {
        $('[data-target="list-container"] .list_item').each(function() {
            if($(this).hasClass('inactive')) {
                $(this).find('i').removeClass('fa-angle-double-up');
                $(this).find('i').addClass('fa-angle-double-down');
            }
            else {
                $(this).find('i').removeClass('fa-angle-double-down');
                $(this).find('i').addClass('fa-angle-double-up');
            }
            $("[data-behaviour='select2']").select2();
        })
        return true;
    }

    function init() {

        // Unregister events should they already exist
        $itemListContainerWrapper.off("click");

        $('[data-behaviour="item-list-block"] .card-item-list-block').sortable({
            items : '.sortable_item',
            handle: '.sort_handle',
            axis: 'y',
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            start: function() {
                $('[data-target="list-container"] .list_item').addClass("sortable_item-smaller");
            },
            stop: function() {
                $('[data-target="list-container"] .list_item').removeClass("sortable_item-smaller");
            }
        });

        $itemListContainerWrapper.on("click", "[data-behaviour='item-list-add-item']", function() {
            let count = $itemListContainer.children().length;
            if(count>=maxItems) {
                alert("<?php echo t('This block allows up to %s items.', $maxNumberOfItems) ?>");
                return false;
            }
            $('[data-target="list-container"] .list_item').addClass("inactive");
            $.ajax({
                url: "<?php echo $view->action('load_list_item'); ?>",
                dataType: 'json',
                contentType: 'application/json',
                data: {'type': $(this).attr('data-item-type')}
            })
                .done(
                    function(data) {
                        if(data.markup) {
                            $itemListContainer.append(data.markup);
                            updateCards();
                        }
                        else {
                            alert("<?php echo t('There was an error when trying to insert a new item, please try again.') ?>");
                        }
                    });
        });

        $($itemListContainerWrapper).on("click", "[data-behaviour='item-list-expand-item']", function() {
            let $wrapper = $(this).closest('.list_item');
            if($wrapper.hasClass('inactive')) {
                $wrapper.removeClass('inactive');
                $(this).find('i').removeClass('fa-angle-double-down');
                $(this).find('i').addClass('fa-angle-double-up');
            }
            else {
                $wrapper.addClass('inactive');
                $(this).find('i').removeClass('fa-angle-double-up-up');
                $(this).find('i').addClass('fa-angle-double-down');
            }
        });

        $itemListContainerWrapper.on("click", ".list_item-main", function() {
            let $listItem = $(this).closest('.list_item');
            let $icon = $listItem.find('[data-behaviour="item-list-expand-item"] i');
            $listItem.removeClass("inactive").find();
            $icon.removeClass('fa-angle-double-down');
            $icon.addClass('fa-angle-double-up');
        });

        $itemListContainerWrapper.on("click", "[data-behaviour='item-list-remove-item']", function(event) {
            let $item = $(this).closest(".list_item");
            let confirmResult = confirm("<?php echo t('Are you sure you want to remove this item?') ?>");
            if(confirmResult) {
                for(let name in CKEDITOR.instances) {
                    if($item.has("#" + name).length) {
                        CKEDITOR.instances[name].destroy()
                    }
                }
                $(this).closest(".list_item").remove();
            }
        });
        minimizeCards();
        $("[data-behaviour='select2']").select2();
    }

    init();

});
</script>