<?php 
// created: 2013-02-12 12:59:27
$dictionary['realty_sugartalk_sms'] =  array(
							  'relationships' => array (
								'realty_sugartalk_sms' => 
								array (
								'lhs_module'=> 'Realty', 
								'lhs_table'=> 'realty', 
								'lhs_key' => 'id',
								'rhs_module'=> 'sugartalk_SMS', 
								'rhs_table'=> 'sugartalk_sms', 
								'rhs_key' => 'parent_id',
								'relationship_type'=>'one-to-many', 
								'relationship_role_column'=>'parent_type',
								'relationship_role_column_value'=>'Realty',
									),
								  ),
								'fields' => '',
							  'indices' => '',
							  'table' => '',								
							);
							?>