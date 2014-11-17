<?php
$popupMeta = array (
    'moduleMain' => 'Department',
    'varName' => 'Department',
    'orderBy' => 'department.name',
    'whereClauses' => array (
  'name' => 'department.name',
  'assigned_user_id' => 'department.assigned_user_id',
  'branch_name' => 'department.branch_name',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'assigned_user_id',
  5 => 'branch_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
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
  'branch_name' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_BRANCH_NAME',
    'id' => 'BRANCH_ID',
    'link' => true,
    'width' => '10%',
    'name' => 'branch_name',
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
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
    'name' => 'assigned_user_name',
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
),
);
