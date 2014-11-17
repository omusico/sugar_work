<?php
$module_name = 'RealtyTemplates';
$listViewDefs [$module_name] = 
array (
  'ACTIVITY_STATUS' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_ACTIVITY_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'LAST_CONTACT' => 
  array (
    'type' => 'date',
    'label' => 'LBL_LAST_CONTACT',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'TYPE_OF_REALTY' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_TYPE_OF_REALTY',
    'width' => '10%',
    'default' => true,
  ),
  'KIND_OF_REALTY' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_KIND_OF_REALTY',
    'width' => '10%',
    'default' => true,
  ),
  'OPERATION' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_OPERATION',
    'width' => '10%',
    'default' => true,
  ),
  'ROOMS_QUANTITY' => 
  array (
    'type' => 'int',
    'label' => 'LBL_ROOMS_QUANTITY',
    'width' => '10%',
    'default' => true,
  ),
  'SQUARE' => 
  array (
    'type' => 'int',
    'label' => 'LBL_SQUARE',
    'width' => '10%',
    'default' => true,
  ),
  'FLOOR' => 
  array (
    'type' => 'int',
    'label' => 'LBL_FLOOR',
    'width' => '10%',
    'default' => true,
  ),
  'TOTALCOST' => 
  array (
    'type' => 'int',
    'label' => 'LBL_TOTALCOST',
    'width' => '10%',
    'default' => true,
  ),
  'BUILDING_NAME' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BUILDING_NAME',
    'id' => 'BUILDING_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'RESERVED' => 
  array (
    'type' => 'bool',
    'label' => 'LBL_RESERVED',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => false,
  ),
  'REALTY_STATUS' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_REALTY_STATUS',
    'width' => '10%',
    'default' => false,
  ),
);
?>
