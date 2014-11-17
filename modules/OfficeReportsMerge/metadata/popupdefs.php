<?php
$popupMeta = array (
    'moduleMain' => 'OfficeReportsMerge',
    'varName' => 'OfficeReportsMerge',
    'orderBy' => 'OfficeReportsMerge.name',
    'whereClauses' => array (
  'name' => 'OfficeReportsMerge.name',
  'report_module' => 'officereportsmerge.report_module',
  'assigned_user_id' => 'officereportsmerge.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'report_module',
  5 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'report_module' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REPORT_MODULE',
    'width' => '10%',
    'name' => 'report_module',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'REPORT_MODULE' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_REPORT_MODULE',
    'width' => '10%',
    'default' => true,
    'name' => 'report_module',
  ),
  'FILENAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_TEMPLATENAME',
    'width' => '10%',
    'default' => true,
    'name' => 'filename',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'name' => 'assigned_user_name',
  ),
  'CREATED_BY_NAME' => 
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '10%',
    'default' => true,
    'name' => 'created_by_name',
  ),
),
);
