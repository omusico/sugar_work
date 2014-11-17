<?php
$module_name = 'OfficeReportsHistory';
$listViewDefs [$module_name] =
array (
  'NAME' =>
  array (
    'width' => '10%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PARENT_NAME' =>
  array (
    'type' => 'parent_type',
    'label' => 'LBL_PARENT_NAME',
    'width' => '10%',
	'dynamic_module' => 'PARENT_TYPE',
	'id' => 'PARENT_ID',
	'link' => true,
	'default' => true,
	'sortable' => false,
	'ACLTag' => 'PARENT',
	'related_fields' => array('parent_id', 'parent_type'),
  ),
  'DOWNLOAD_ON_PC' =>
  array (
    'type' => 'bool',
    'label' => 'LBL_DOWNLOAD_ON_PC',
    'width' => '10%',
    'default' => true,
  ),
  'SEND_ON_EMAIL' =>
  array (
    'type' => 'bool',
    'label' => 'LBL_SEND_ON_EMAIL',
    'width' => '10%',
    'default' => true,
  ),
  'ATTACH_TO_NOTES' =>
  array (
    'type' => 'bool',
    'label' => 'LBL_ATTACH_TO_NOTES',
    'width' => '10%',
    'default' => true,
  ),
  'FILE_MIME_TYPE' =>
  array (
    'type' => 'varchar',
    'label' => 'LBL_FILE_MIME_TYPE',
    'width' => '10%',
    'default' => true,
  ),
  'CREATED_BY_NAME' =>
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '9%',
    'default' => true,
  ),
  'DATE_ENTERED' =>
  array (
    'type' => 'datetime',
    'label' => 'LBL_DATE_ENTERED',
    'width' => '8%',
    'default' => true,
  ),
  'EMAIL_ADDRS' =>
  array (
    'type' => 'text',
    'label' => 'LBL_EMAIL_ADDR',
    'sortable' => false,
    'width' => '10%',
    'default' => false,
  ),
);
?>
