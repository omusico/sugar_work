<?php 
// created: 2013-02-12 12:59:27
$dictionary['account_sugartalk_sms'] =  array(
							  'relationships' => array (
								'account_sugartalk_sms' => 
								array (
								'lhs_module'=> 'Accounts', 
								'lhs_table'=> 'accounts', 
								'lhs_key' => 'id',
								'rhs_module'=> 'sugartalk_SMS', 
								'rhs_table'=> 'sugartalk_sms', 
								'rhs_key' => 'parent_id',
								'relationship_type'=>'one-to-many', 
								'relationship_role_column'=>'parent_type',
								'relationship_role_column_value'=>'Accounts',
									),
								  ),
								'fields' => '',
							  'indices' => '',
							  'table' => '',								
							);
							?>