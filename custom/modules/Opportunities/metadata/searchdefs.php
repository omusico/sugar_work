<?php
$searchdefs ['Opportunities'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'amount_usdollar' => 
      array (
        'type' => 'currency',
        'studio' => 
        array (
          'editview' => false,
          'detailview' => false,
          'quickcreate' => false,
        ),
        'label' => 'LBL_AMOUNT_USDOLLAR',
        'currency_format' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'amount_usdollar',
      ),
      'contact_name' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT_NAME',
        'id' => 'CONTACT_ID',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'contact_name',
      ),
      'account_name' => 
      array (
        'name' => 'account_name',
        'default' => true,
        'width' => '10%',
      ),
      'type_of_opportunity' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE_OF_OPPORTUNITY',
        'width' => '10%',
        'default' => true,
        'name' => 'type_of_opportunity',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'account_name' => 
      array (
        'name' => 'account_name',
        'default' => true,
        'width' => '10%',
      ),
      'contact_name' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_CONTACT_NAME',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'id' => 'CONTACT_ID',
        'name' => 'contact_name',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
      'sales_stage' => 
      array (
        'name' => 'sales_stage',
        'default' => true,
        'width' => '10%',
      ),
      'amount' => 
      array (
        'name' => 'amount',
        'default' => true,
        'width' => '10%',
      ),
      'type_of_realty' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE_OF_REALTY',
        'width' => '10%',
        'default' => true,
        'name' => 'type_of_realty',
      ),
      'opportunity_type' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'opportunity_type',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
