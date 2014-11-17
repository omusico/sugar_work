<?php

$module_name='Realty';
$subpanel_layout = array(
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $module_name),
	),
	'where' => '',
	'list_fields' => array(
		'name'=>array(
	 		'vname' => 'LBL_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
	 		'width' => '15%',
		),
        'totalcost'=>array(
            'vname' => 'LBL_TOTALCOST',
            'width' => '15%',
        ),
        'currency'=> array
         (
                'vname'=>'LBL_CURRENCY',
                'width'=>'10%',
          ),		
        'square'=>array(
            'vname' => 'LBL_SQUARE',
            'width' => '15%',
        ),
        'operation'=>array(
            'vname' => 'LBL_OPERATION',
            'width' => '15%',
        ),
        'address_street'=>array(
            'vname' => 'LBL_ADDRESS_STREET',
            'width' => '15%',
        ),
        'date_entered'=>array(
            'vname' => 'LBL_DATE_ENTERED',
            'width' => '15%',
        ),
        'date_modified'=>array(
                'vname' => 'LBL_DATE_MODIFIED',
                'width' => '15%',
        ),
        
        'edit_button'=>array(
        'vname' => 'LBL_EDIT_BUTTON',
                'widget_class' => 'SubPanelEditButton',
                'module' => $module_name,
                'width' => '4%',
        ),
        'remove_button'=>array(
        'vname' => 'LBL_REMOVE',
                'widget_class' => 'SubPanelRemoveButton',
                'module' => $module_name,
                'width' => '5%',
        ),
    ),
);