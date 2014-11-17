<?php
$module_name = 'OfficeReportsHistory';
$searchdefs [$module_name] =
array (
  'layout' =>
  array (
    'basic_search' =>
    array (
      'name' =>
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      /*'parent_name' =>
      array (
        'type' => 'parent',
        'label' => 'LBL_PARENT_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'parent_name',
      ),*/
      'assigned_user_name' =>
      array (
        'link' => 'assigned_user_link',
        'type' => 'relate',
        'label' => 'LBL_ASSIGNED_TO_NAME',
        'width' => '10%',
        'default' => true,
        'name' => 'assigned_user_name',
      ),
      'date_entered' =>
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
    ),
    'advanced_search' =>
    array (
      'name' =>
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      /*'parent_name' =>
      array (
        'type' => 'parent',
        'label' => 'LBL_LIST_RELATED_TO',
        'width' => '10%',
        'default' => true,
        'name' => 'parent_name',
      ),*/
      'file_mime_type' =>
      array (
        'type' => 'varchar',
        'label' => 'LBL_FILE_MIME_TYPE',
        'width' => '10%',
        'default' => true,
        'name' => 'file_mime_type',
      ),
      'send_on_email' =>
      array (
        'type' => 'bool',
        'label' => 'LBL_SEND_ON_EMAIL',
        'width' => '10%',
        'default' => true,
        'name' => 'send_on_email',
      ),
      'email_addrs' =>
      array (
        'type' => 'text',
        'label' => 'LBL_EMAIL_ADDR',
        'sortable' => false,
        'width' => '10%',
        'default' => true,
        'name' => 'email_addrs',
      ),
      'download_on_pc' =>
      array (
        'type' => 'bool',
        'label' => 'LBL_DOWNLOAD_ON_PC',
        'width' => '10%',
        'default' => true,
        'name' => 'download_on_pc',
      ),
      'attach_to_notes' =>
      array (
        'type' => 'bool',
        'label' => 'LBL_ATTACH_TO_NOTES',
        'width' => '10%',
        'default' => true,
        'name' => 'attach_to_notes',
      ),
      'date_entered' =>
      array (
        'type' => 'datetime',
        'label' => 'LBL_DATE_ENTERED',
        'width' => '10%',
        'default' => true,
        'name' => 'date_entered',
      ),
      'assigned_user_id' =>
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' =>
        array (
          'name' => 'get_user_array',
          'params' =>
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
    ),
  ),
  'templateMeta' =>
  array (
    'maxColumns' => '3',
    'widths' =>
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
