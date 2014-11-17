<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$module_name='Realty';
$subpanel_layout = array(

	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopInterestButton',),
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
		  
        'presentation_checked' =>array (
                'vname' => 'LBL_PRESENTATION_CHECKED',
                'width' => '5%',
                'default' => true,
                'sortable' => false,
        ),
        'presentation_text' => array (
                'type' => 'varchar',
                'vname' => 'LBL_PRESENTATION_TEXT',
                'width' => '10%',
                'default' => true,
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
          'interest_button'=>array
            (
              'vname'=>'LBL_INTEREST',
              'module'=> $module_name,
              'width'=>'5%',
              'widget_class' => 'SubPanelInterestButton',
            ),

	),
);

?>