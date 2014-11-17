<?php

$dictionary['Contract']['fields']['auto_name'] =
    array (
        'required' => true,
        'name' => 'auto_name',
        'vname' => 'LBL_AUTO_NAME',
        'type' => 'int',
        'massupdate' => 0,
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => 0,
        'audited' => 0,
        'reportable' => 0,
        'len' => '11',
        'studio' => false,
        'isnull' => 'false',
        'auto_increment'=>true,
);


$dictionary['Contract']['indices'][] =

    array(
        'name' => 'auto_name',
        'type' => 'index',
        'fields' => array('auto_name'),
);
