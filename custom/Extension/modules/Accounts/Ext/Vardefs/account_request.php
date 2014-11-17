<?php
$dictionary['Account']['fields']['account_request'] =
    array (
      'name' => 'account_request',
      'type' => 'link',
      'relationship' => 'account_request',
      'module'=>'Request',
      'bean_name'=>'Request',
      'source'=>'non-db',
      'vname'=>'LBL_REQUESTS',
    );

$dictionary['Account']['relationships']['account_request'] =
    array(
        'lhs_module'=> 'Accounts',
        'lhs_table'=> 'accounts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Request',
        'rhs_table'=> 'request',
        'rhs_key' => 'parent_id',
        'relationship_type'=>'one-to-many',
        'relationship_role_column'=>'parent_type',
        'relationship_role_column_value'=>'Accounts'
    );