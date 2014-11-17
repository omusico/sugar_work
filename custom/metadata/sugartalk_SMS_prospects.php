<?php 
// created: 2013-02-08 11:13:25
$dictionary['prospect_sugartalk_sms'] =  array(
							  'relationships' => array (
								'prospect_sugartalk_sms' => 
								array (
								'lhs_module'=> 'Prospects', 
								'lhs_table'=> 'prospects', 
								'lhs_key' => 'id',
								'rhs_module'=> 'sugartalk_SMS', 
								'rhs_table'=> 'sugartalk_sms', 
								'rhs_key' => 'parent_id',
								'relationship_type'=>'one-to-many', 
								'relationship_role_column'=>'parent_type',
								'relationship_role_column_value'=>'Prospects',
									),
								  ),
								'fields' => '',
							  'indices' => '',
							  'table' => '',								
							);
							?>