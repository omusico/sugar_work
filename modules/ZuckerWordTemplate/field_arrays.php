<?php
$fields_array['WordTemplate'] = array (
	'column_fields' => array(
		"id",
		"name",
		"sql",
		"description",		
		"date_entered",
		"date_modified",
		"created_by",
		"modified_user_id",
		'team_id',
		'assigned_user_id',
	),
        'list_fields' =>  array(
		"id",
		"name",
		"sql",
		"description",		
		"date_entered",
		"date_modified",
		"created_by",
		"modified_user_id",
		'team_id',
		'assigned_user_id',
	),
    	'required_fields' =>  array('name'=>1, 'sql'=>1),
);
?>