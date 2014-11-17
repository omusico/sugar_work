<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$layout_defs['Coupons'] = array(
    'subpanel_setup' => array(
        'orders_coupons' =>
        array (
            'order' => 100,
            'refresh_page'=>1,
            'module' => 'ECommerce_Orders',
            'subpanel_name' => 'default',
            'sort_order' => 'desc',
            'sort_by' => 'date_entered',
            'title_key' => 'LBL_ORDERS_COUPONS',
            'get_subpanel_data' => 'orders_coupons',
            'top_buttons' =>
            array (
                0 =>
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                    'mode' => 'MultiSelect',
                ),
            ),
        ),

    ),
);
?>