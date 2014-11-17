<?php
$module_name = 'Buildings';
$listViewDefs [$module_name] = 
array (
  'CODE_INC' => 
  array (
    'type' => 'int',
    'label' => 'LBL_CODE',
    'width' => '4%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CURRENT_SQUARE' => 
  array (
    'type' => 'int',
    'label' => 'LBL_CURRENT_SQUARE',
    'width' => '10%',
    'default' => true,
  ),
  'TYPE_OF_BUILDING' => 
  array (
    'type' => 'enum',
    'default' => true,
    'label' => 'LBL_TYPE_OF_BUILDING',
    'width' => '10%',
  ),
  'NUMBER_OF_FLOORS' => 
  array (
    'type' => 'int',
    'label' => 'LBL_NUMBER_OF_FLOORS',
    'width' => '10%',
    'default' => true,
  ),
  'FLATS_QUANTITY' => 
  array (
    'type' => 'int',
    'label' => 'LBL_FLATS_QUANTITY',
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
  ),
);
?>
