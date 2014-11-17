<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$layout_defs["Realty"]["subpanel_setup"]["activities"] = array (
	'order' => 10,
	'sort_order' => 'desc',
	'sort_by' => 'date_start',
	'title_key' => 'LBL_ACTIVITIES_SUBPANEL_TITLE',
	'type' => 'collection',
	'subpanel_name' => 'activities',   //this values is not associated with a physical file.
	'module'=>'Activities',

	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopCreateTaskButton'),
		array('widget_class' => 'SubPanelTopScheduleMeetingButton'),
		array('widget_class' => 'SubPanelTopScheduleCallButton'),
		array('widget_class' => 'SubPanelTopComposeEmailButton'),
	),

	'collection_list' => array(
		'realty_meetings' => array(
			'module' => 'Meetings',
			'subpanel_name' => 'ForActivities',
			'get_subpanel_data' => 'realty_meetings',
		),
		'realty_tasks' => array(
			'module' => 'Tasks',
			'subpanel_name' => 'ForActivities',
			'get_subpanel_data' => 'realty_tasks',
		),
		'realty_calls' => array(
			'module' => 'Calls',
			'subpanel_name' => 'ForActivities',
			'get_subpanel_data' => 'realty_calls',
		),
	)
);