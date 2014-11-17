<?php
$popupMeta = array (
    'moduleMain' => 'Realty',
    'varName' => 'Realty',
    'orderBy' => 'realty.name',
    'whereClauses' => array (
  'name' => 'realty.name',
  'operation' => 'realty.operation',
  'assigned_user_id' => 'realty.assigned_user_id',
  'operation_status' => 'realty.operation_status',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'operation',
  5 => 'assigned_user_id',
  6 => 'operation_status',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'operation' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_OPERATION',
    'width' => '10%',
    'name' => 'operation',
  ),
  'operation_status' => 
  array (
    'type' => 'enum',
    'label' => 'LBL_OPERATION_STATUS',
    'width' => '10%',
    'name' => 'operation_status',
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
 'templateForm' => 'custom/modules/Realty/test.html',
);
