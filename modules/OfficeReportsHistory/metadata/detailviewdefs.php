<?php
$module_name = 'OfficeReportsHistory';
$viewdefs [$module_name] =
array (
  'DetailView' =>
  array (
    'templateMeta' =>
    array (
      'form' =>
      array (
        'buttons' =>
        array (
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array (
        0 =>
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
    ),
    'panels' =>
    array (
      'default' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 =>
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'parent_name',
            'label' => 'LBL_PARENT_NAME',
          ),
          1 =>
          array (
          ),
        ),
        2 =>
        array (
          0 =>
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
      ),
      'lbl_detailview_panel_settings' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'send_on_email',
            'label' => 'LBL_SEND_ON_EMAIL',
          ),
          1 =>
          array (
            'name' => 'download_on_pc',
            'label' => 'LBL_DOWNLOAD_ON_PC',
          ),
        ),
        1 =>
        array (
          0 =>
          array (
            'name' => 'email_addrs',
            'label' => 'LBL_EMAIL_ADDR',
          ),
          1 =>
          array (
            'name' => 'attach_to_notes',
            'label' => 'LBL_ATTACH_TO_NOTES',
          ),
        ),
      ),
      'lbl_detailview_panel_attach' =>
      array(
        0 =>
        array (
          0 =>
          array (
            'name' => 'filename',
            'label' => 'LBL_FILENAME',
            'type' => 'file',
            'displayParams' =>
            array (
              'id' => 'id',
              'link' => 'filename',
            ),
          ),
          1 =>
          array (
            'name' => 'file_mime_type',
            'label' => 'LBL_FILE_MIME_TYPE',
          ),
        ),
      ),
    ),
  ),
);
?>
