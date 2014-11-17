<?php 
 // created: 2013-02-12 12:59:27

							$layout_defs['Realty']['subpanel_setup']['realty_sugartalk_sms'] = array (
							  'order' => 250,
							  'module' => 'sugartalk_SMS',
							  'subpanel_name' => 'default',
							  'sort_order' => 'asc',
							  'sort_by' => 'date_entered',
							  'title_key' => 'LBL_SUGARTALK_SMS',
							  'get_subpanel_data' => 'realty_sugartalk_sms',
							  'top_buttons' =>
							  array (
								    array('widget_class' => 'SubPanelSMSButton')
							  ),
							);
							?>