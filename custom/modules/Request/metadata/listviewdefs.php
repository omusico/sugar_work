<?php
$module_name = 'Request';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'OPERATION' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_OPERATION',
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
  'COST_TO' => 
  array (
    'type' => 'float',
    'label' => 'LBL_COST_TO',
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
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '10%',
    'default' => true,
  ),
);
?>
