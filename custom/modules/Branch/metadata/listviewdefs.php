<?php
$module_name = 'Branch';
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
  'EMAIL1' => 
  array (
    'type' => 'varchar',
    'studio' => 'visible',
    'label' => 'LBL_EMAIL',
    'width' => '10%',
    'default' => true,
  ),
  'CONTACT_PHONE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_CONTACT_PHONE',
    'width' => '10%',
    'default' => true,
  ),
  'ADDRESS_COUNTRY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_COUNTRY',
    'width' => '10%',
    'default' => true,
  ),
  'ADDRESS_CITY' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_CITY',
    'width' => '10%',
    'default' => true,
  ),
  'ADDRESS_STREET' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_STREET',
    'width' => '10%',
    'default' => true,
  ),
  'ADDRESS_HOUSE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_HOUSE',
    'width' => '10%',
    'default' => true,
  ),
);
?>
