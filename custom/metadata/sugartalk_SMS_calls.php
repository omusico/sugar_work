<?php 
// created: 2013-02-08 11:13:42
$dictionary['call_sugartalk_sms'] =  array(
							  'relationships' => array (
								'call_sugartalk_sms' => 
								array (
								'lhs_module'=> 'Calls', 
								'lhs_table'=> 'calls', 
								'lhs_key' => 'id',
								'rhs_module'=> 'sugartalk_SMS', 
								'rhs_table'=> 'sugartalk_sms', 
								'rhs_key' => 'parent_id',
								'relationship_type'=>'one-to-many', 
								'relationship_role_column'=>'sugartalk_sms.parent_type',
								'relationship_role_column_value'=>'Calls',
									),
								  ),
								'fields' => '',
							  'indices' => '',
							  'table' => '',								
							);
							?>