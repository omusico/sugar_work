<?php
// created: 2013-10-17 13:32:34
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '10%',
    'default' => true,
  ),
  'operation' => 
  array (
    'vname' => 'LBL_OPERATION',
    'width' => '10%',
    'default' => true,
  ),
  'totalcost' => 
  array (
    'vname' => 'LBL_TOTALCOST',
    'width' => '10%',
    'default' => true,
  ),
  'currency' => 
  array (
    'vname' => 'LBL_CURRENCY',
    'width' => '10%',
    'default' => true,
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
  'square' => 
  array (
    'vname' => 'LBL_SQUARE',
    'width' => '5%',
    'default' => true,
  ),
  'address_street' => 
  array (
    'vname' => 'LBL_ADDRESS_STREET',
    'width' => '15%',
    'default' => true,
  ),
	'request'=>array(
	'vname' => 'LBL_REQUEST',
	'width' => '15%',
	),
  'last_contact' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_LAST_CONTACT',
    'width' => '10%',
    'default' => true,
  ),
  'realty_status' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_REALTY_STATUS',
    'width' => '10%',
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'Realty',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'Realty',
    'width' => '5%',
    'default' => true,
  ),
);