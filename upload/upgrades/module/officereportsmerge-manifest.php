<?php
/**
 * @file
 * 	File for install OfficeReports module in SugarCRM
 * @author Malik Eduard
 */
$manifest = array (
	'acceptable_sugar_versions' =>
    array (
        2 => "6\.0.*",
        3 => "6\.1.*",
        4 => "6\.2.*",
        5 => "6\.3.*",
        6 => "6\.4.*",
    ),
    'acceptable_sugar_flavors' =>
    array(
        'CE', 'PRO', 'ENT'
    ),
    'key' => '',
    'author' => 'Malik Eduard &lt;admin@sugartalk.ru&gt;',
    'description' => 'Module for add, edit, generate report. Send by email, save in history and etc.',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'OfficeReports',
    'published_date' => '2012-04-05 20:40:00',
    'type' => 'module',
    'version' => '0.3.2',
    'remove_tables' => 'prompt',
);
$installdefs = array (
  'id' => 'OfficeReports',
  'beans' =>
  array (
    0 =>
    array (
      'module' => 'OfficeReportsMerge',
      'class' => 'OfficeReportMerge',
      'path' => 'modules/OfficeReportsMerge/OfficeReportMerge.php',
      'tab' => true,
    ),
    1 =>
    array (
      'module' => 'OfficeReportsHistory',
      'class' => 'OfficeReportHistory',
      'path' => 'modules/OfficeReportsHistory/OfficeReportHistory.php',
      'tab' => true,
    ),
    2 =>
    array (
      'module' => 'OfficeReportsVariables',
      'class' => 'OfficeReportVariable',
      'path' => 'modules/OfficeReportsVariables/OfficeReportVariable.php',
      'tab' => false,
    ),
  ),

  'layoutdefs' => array ( ),

  'relationships' => array ( ),

  'image_dir' => '<basepath>/icons',

  'administration' =>
  array (
    0 =>
    array (
      'from' => '<basepath>/install/administration/OfficeReportsAdmin.menu.php',
    ),
  ),

  'copy' =>
  array (
    0 =>
    array (
      'from' => '<basepath>/install/modules/OfficeReportsHistory',
      'to' => 'modules/OfficeReportsHistory',
    ),
    1 =>
    array (
      'from' => '<basepath>/install/modules/OfficeReportsMerge',
      'to' => 'modules/OfficeReportsMerge',
    ),
    2 =>
    array (
      'from' => '<basepath>/install/modules/OfficeReportsVariables',
      'to' => 'modules/OfficeReportsVariables',
    ),
    3 =>
    array (
	  'from' => '<basepath>/install/custom/include/OfficeReportsMerge',
	  'to' => 'custom/include/OfficeReportsMerge',
    ),
  ),
  'language' =>
  array (
    0 =>
    array (
      'from' => '<basepath>/install/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    1 =>
    array (
      'from' => '<basepath>/install/language/application/ru_ru.lang.php',
      'to_module' => 'application',
      'language' => 'ru_ru',
    ),
    2 =>
    array (
	  'from'=> '<basepath>/install/administration/language/en_us.OfficeReportsAdmin.php',
	  'to_module'=> 'Administration',
	  'language'=>'en_us'
    ),
    3 =>
    array (
	  'from'=> '<basepath>/install/administration/language/ru_ru.OfficeReportsAdmin.php',
	  'to_module'=> 'Administration',
	  'language'=>'ru_ru'
    ),
  ),

  'vardefs' => array ( ),

  'custom_fields' => array( ),

  'logic_hooks' => array(
	array(
	  'module' => '',
	  'hook' => 'after_ui_frame',
	  'order' => 10000,
	  'description' => 'Add Button for load form with reports settings',
	  'file' => 'modules/OfficeReportsMerge/ReportHook.php',
	  'class' => 'ReportHook',
	  'function' => 'addButton',
	),
  ),
);
