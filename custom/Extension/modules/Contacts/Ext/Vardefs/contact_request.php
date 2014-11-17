<?php
$dictionary['Contact']['fields']['requests'] =
    array (
      'name' => 'requests',
      'type' => 'link',
      'relationship' => 'account_requests',
      'module'=>'Request',
      'bean_name'=>'Request',
      'source'=>'non-db',
      'vname'=>'LBL_REQUESTS',
    );

$dictionary['Contact']['relationships']['account_requests'] =
    array(
        'lhs_module'=> 'Contacts',
        'lhs_table'=> 'contacts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Request',
        'rhs_table'=> 'request',
        'rhs_key' => 'parent_id',
        'relationship_type'=>'one-to-many',
        'relationship_role_column'=>'parent_type',
        'relationship_role_column_value'=>'Contacts'
    );