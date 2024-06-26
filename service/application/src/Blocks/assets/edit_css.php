<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<style>
.card-item-list-block {
    margin-bottom: 20px;
    position: relative;
}

.card-item-list-block .list_item {
    padding: 0;
    border: 1px solid #dadada;
    position: relative;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 4px;
}

.list_item-title {
    padding: 10px;
    margin-bottom: 5px;
    background-color: #3f9edc;
    cursor: move;
}

.list_item-title h3 {
    margin: 0;
    color: #fff;
    font-size: 18px;
    font-weight: 200;
}

.list_item-main {
    padding: 20px;
}

.card-item-list-block .list_item.inactive {
    height: 180px;
    overflow: hidden;
}

.card-item-list-block .form-group-control-buttons {
    position: absolute;
    top: 0;
    right: 5px;
    margin: 5px;
}

.form-group-control-buttons .btn {
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 2px;
}

.card-item-list-block- .ui-sortable-helper, .card-item-list-block .sortable_item-smaller {
    height: 125px !important;
    overflow: hidden;
    width: 100% !important;
}

.card-item-list-block .ui-sortable-placeholder {
    height: 125px !important;
    background-color: #f3f3f3;
    border: 1px dotted #ccc;
    visibility: visible !important;
}

.ccm-ui .form-control.custom-select2 {
    border: none;
    padding: 0;
}

</style>