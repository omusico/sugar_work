<?php
// created: 2014-03-20 16:31:32
$dictionary["request_activities_1_emails"] = array (
  'relationships' => 
  array (
    'request_activities_1_emails' => 
    array (
      'lhs_module' => 'Request',
      'lhs_table' => 'request',
      'lhs_key' => 'id',
      'rhs_module' => 'Emails',
      'rhs_table' => 'emails',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
      'relationship_role_column' => 'parent_type',
      'relationship_role_column_value' => 'Request',
    ),
  ),
  'fields' => '',
  'indices' => '',
  'table' => '',
);