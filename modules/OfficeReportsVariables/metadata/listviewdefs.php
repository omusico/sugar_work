<?php
$module_name = 'OfficeReportsVariables';
$listViewDefs [$module_name] = 
array (
  'FRIENDLY_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FRIENDLY_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'FOR_MODULES' => 
  array (
    'type' => 'multienum',
    'label' => 'LBL_FOR_MODULES',
    'width' => '10%',
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '8%',
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '9%',
    'default' => false,
  ),
  'CODE' => 
  array (
    'type' => 'text',
    'label' => 'LBL_CODE',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
);
?>
