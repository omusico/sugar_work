<?php

$dictionary["User"]["fields"]["auth_time"] =
    array (
        'name' => 'auth_time',
        'vname' => '',
        'type' => 'datetimecombo',
        'dbType' => 'datetime',
        'enable_range_search' => true,
    );


$dictionary["User"]["fields"]["auth_action"] =
    array (
        'required' => false,
        'name' => 'auth_action',
        'vname' => '',
        'type' => 'enum',
        'options' => 'auth_action_category',
        'massupdate' => 0,
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => '0',
        'audited' => true,
        'reportable' => true,
        'len' => '255',
        'size' => '20',
    );



