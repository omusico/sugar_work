<?php
$module_name = 'Department';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'BRANCH_NAME' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BRANCH_NAME',
    'id' => 'BRANCH_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
  ),
  'KIND_OF_REALTY' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_KIND_OF_REALTY',
    'width' => '10%',
    'default' => false,
  ),
);
?>
