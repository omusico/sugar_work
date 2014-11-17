<?php
$module_name = 'OfficeReportsMerge';
$listViewDefs [$module_name] =
array (
  'NAME' =>
  array (
    'width' => '10%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'REPORT_MODULE' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_REPORT_MODULE',
    'width' => '10%',
    'default' => true,
  ),
  'FILENAME' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_TEMPLATENAME',
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
  'CREATED_BY_NAME' =>
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '9%',
    'default' => true,
  ),
  'MODIFIED_BY_NAME' =>
  array (
    'type' => 'relate',
    'link' => 'modified_user_link',
    'label' => 'LBL_MODIFIED_NAME',
    'width' => '9%',
    'default' => false,
  ),
  'DATE_MODIFIED' =>
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_MODIFIED',
    'width' => '8%',
    'default' => false,
  ),
  'DATE_ENTERED' =>
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '8%',
    'default' => true,
  ),
  'DESCRIPTION' =>
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
);
?>
