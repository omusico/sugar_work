<?php 
// created: 2013-02-08 11:13:42
$dictionary['meeting_sugartalk_sms'] =  array(
							  'relationships' => array (
								'meeting_sugartalk_sms' => 
								array (
								'lhs_module'=> 'Meetings', 
								'lhs_table'=> 'meetings', 
								'lhs_key' => 'id',
								'rhs_module'=> 'sugartalk_SMS', 
								'rhs_table'=> 'sugartalk_sms', 
								'rhs_key' => 'parent_id',
								'relationship_type'=>'one-to-many', 
								'relationship_role_column'=>'sugartalk_sms.parent_type',
								'relationship_role_column_value'=>'Meetings',
									),
								  ),
								'fields' => '',
							  'indices' => '',
							  'table' => '',								
							);
							?>