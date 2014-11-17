<?php
	$manifest = array (
		 'acceptable_sugar_versions' => 
		  array (
	     	
		  ),
		  'acceptable_sugar_flavors' =>
		  array(
		  	'CE',
		  ),
		  'readme'=>'README.txt',
		  'key'=>'acl',
		  'author' => 'Ivan_Stroilov',
		  'description' => 'Package to add field level access control to SugarCRM CE',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'SugarFieldManager',
		  'published_date' => '2014-06-25 15:49:00',
		  'type' => 'module',
		  'version' => '0.31',
		  'remove_tables' => 'prompt',
		  );
$installdefs = array (
  'id' => 'FieldLevelAccess',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'acl_fields',
      'class' => 'acl_fields',
      'path' => 'modules/acl_fields/acl_fields.php',
      'tab' => false,
    ),
  ),
  'layoutdefs' => 
  array (
  ),
  'relationships' => 
  array (
  ),
  'image_dir' => '<basepath>/icons',
  'administration' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/administration/FieldsACLAdmin.menu.php',
    ),
  ),
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/acl_fields',
      'to' => 'modules/acl_fields',
    ),
    1 => 
    array (
      'from' => 'include/EditView/EditView.tpl',
      'to' => 'include/EditView/EditView.tpl.orig',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/include/EditView/EditView.tpl',
      'to' => 'include/EditView/EditView.tpl',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/include/EditView/EditView.tpl',
      'to' => 'custom/include/EditView/EditView.tpl',
    ),
    4 => 
    array (
      'from' => 'include/DetailView/DetailView.tpl',
      'to' => 'include/DetailView/DetailView.tpl.orig',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/include/DetailView/DetailView.tpl',
      'to' => 'include/DetailView/DetailView.tpl',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/include/DetailView/DetailView.tpl',
      'to' => 'custom/include/DetailView/DetailView.tpl',
    ),
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    1 => 
    array (
	'from'=> '<basepath>/language/en_us.FieldsACLAdmin.php',
	'to_module'=> 'Administration',
	'language'=>'en_us'
    ),
    2 => 
    array (
	'from'=> '<basepath>/language/ru_ru.FieldsACLAdmin.php',
	'to_module'=> 'Administration',
	'language'=>'ru_ru'
    ),
    3 => 
    array (
	'from'=> '<basepath>/SugarModules/language/application/ru_ru.lang.php',
	'to_module'=> 'application',
	'language'=>'ru_ru'
    ),
  ),
);
