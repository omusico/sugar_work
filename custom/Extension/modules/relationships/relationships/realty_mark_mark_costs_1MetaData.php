<?php
// created: 2014-03-17 16:54:24
$dictionary["realty_mark_mark_costs_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'realty_mark_mark_costs_1' => 
    array (
      'lhs_module' => 'Realty',
      'lhs_table' => 'realty',
      'lhs_key' => 'id',
      'rhs_module' => 'mark_mark_costs',
      'rhs_table' => 'mark_mark_costs',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'realty_mark_mark_costs_1_c',
      'join_key_lhs' => 'realty_mark_mark_costs_1realty_ida',
      'join_key_rhs' => 'realty_mark_mark_costs_1mark_mark_costs_idb',
    ),
  ),
  'table' => 'realty_mark_mark_costs_1_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'realty_mark_mark_costs_1realty_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'realty_mark_mark_costs_1mark_mark_costs_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'realty_mark_mark_costs_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'realty_mark_mark_costs_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'realty_mark_mark_costs_1realty_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'realty_mark_mark_costs_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'realty_mark_mark_costs_1mark_mark_costs_idb',
      ),
    ),
  ),
);