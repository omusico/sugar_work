<?php
global $dictionary;

$dictionary['GoogleSync'] = array(
    'table' => 'GoogleSync',
    'fields' => array(
        /* felder */
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'required' => true,
            'type' => 'id',
            'reportable'=>false,
        ),
        'date_entered' => array(
            'name' => 'date_entered',
            'vname' => 'LBL_DATE_ENTERED',
            'type' => 'datetime',
            'required' => true,
        ),
        'created_by' => array(
            'name' => 'created_by',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_CREATED_BY',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'vname' => 'LBL_DATE_MODIFIED',
            'type' => 'datetime',
            'required' => true,
        ),
        'modified_user_id' => array(
            'name' => 'modified_user_id',
            'rname' => 'user_name',
            'id_name' => 'modified_user_id',
            'vname' => 'LBL_MODIFIED_USER_ID',
            'type' => 'assigned_user_name',
            'table' => 'users',
            'isnull' => 'false',
            'dbType' => 'id',
            'required' => true,
            'default' => '',
            'reportable'=>true,
        ),
        'deleted' => array(
            'name' => 'deleted',
            'vname' => 'LBL_DELETED',
            'type' => 'bool',
            'required' => true,
            'default' => '0',
        ),
        'parent_name' => array(
            'name' => 'parent_name',
            'type' => 'varchar',
            'len' => '255',
        ),
        'parent_id' => array(
            'name' => 'parent_id',
            'type' => 'varchar',
            'len' => '36',
        ),
        'user_id' => array(
            'name' => 'user_id',
            'type' => 'varchar',
            'len' => '36',
        ),
        'google_id' => array(
            'name' => 'google_id',
            'type' => 'text',
        ),
        /*
        'antwort1' => array(
            'name' => 'antwort1',
            'vname' => 'Antwort 1',
            'type' => 'text',
            'len' => '1024',
        ),
        'kommentar' => array(
            'name' => 'kommentar',
            'vname' => 'Kommentar',
            'type' => 'text',
            'len' => '1024',
        ),*/
    ),
    
    'indices' => array(
        array('name' =>'pages_primary_key_index',
            'type' =>'primary',
            'fields'=>array('id')
        ),
    ),
);
?>
