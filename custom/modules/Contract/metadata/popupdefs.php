<?php
$popupMeta = array (
    'moduleMain' => 'Contract',
    'varName' => 'Contract',
    'orderBy' => 'contract.name',
    'whereClauses' => array (
  'name' => 'contract.name',
  'assigned_user_name' => 'contract.assigned_user_name',
  'assigned_user_id' => 'contract.assigned_user_id',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'assigned_user_name',
  5 => 'assigned_user_id',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'assigned_user_name' => 
  array (
    'link' => true,
    'type' => 'relate',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'id' => 'ASSIGNED_USER_ID',
    'width' => '10%',
    'name' => 'assigned_user_name',
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
);
