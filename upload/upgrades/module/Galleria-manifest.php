<?php
/**
 * @file
 * 	File for install GalleryField module in SugarCRM
 * @author Dima Zubakin
 */
$manifest = array (
	'acceptable_sugar_versions' =>
    array (
        2 => "6\.0.*",
        3 => "6\.1.*",
        4 => "6\.2.*",
        5 => "6\.3.*",
        6 => "6\.4.*",
        7 => "6\.5.*",
    ),
    'acceptable_sugar_flavors' =>
    array(
        'CE', 'PRO', 'ENT'
    ),
    'key' => '',
    'author' => 'Dima Zubakin &lt;admin@sugartalk.ru&gt;',
    'description' => 'Module for create field type GalleryField to download pictures and show gallery.',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'GalleryField',
    'published_date' => '2012-04-25 13:13:13',
    'type' => 'module',
    'version' => '2.0.0',
    'remove_tables' => 'prompt',
);
$installdefs = array (
  'id' => 'GalleryField',

  'layoutdefs' => array ( ),

  'relationships' => array ( ),



    'copy' => array(
        array('from'=> '<basepath>/custom/include/GalleryField/',
            'to'=> 'custom/include/GalleryField/',
        ),
        array('from'=> '<basepath>/include/SugarFields/Fields/Gallery/',
            'to'=> 'include/SugarFields/Fields/Gallery/',
        ),
        array('from'=> '<basepath>/modules/DynamicFields/templates/Fields/TemplateGallery.php',
            'to'=> 'modules/DynamicFields/templates/Fields/TemplateGallery.php',
        ),
        array('from'=> '<basepath>/modules/DynamicFields/templates/Fields/Forms/gallery.php',
            'to'=> 'modules/DynamicFields/templates/Fields/Forms/gallery.php',
        ),
        array('from'=> '<basepath>/modules/DynamicFields/templates/Fields/Forms/gallery.tpl',
            'to'=> 'modules/DynamicFields/templates/Fields/Forms/gallery.tpl',
        ),
        array('from'=> '<basepath>/images',
            'to'=> 'custom/themes/default/images',
        ),
    ),



    'language'=> array(
        array(
            'from'=> '<basepath>/language/application.ru_ru.php',
            'to_module'=> 'application',
            'language'=>'ru_ru'
        ),
        array(
            'from'=> '<basepath>/language/application.en_us.php',
            'to_module'=> 'application',
            'language'=>'en_us'
        ),
        array(
            'from'=> '<basepath>/language/gallery.ru_ru.php',
            'to_module'=> 'DynamicFields',
            'language'=>'ru_ru'
        ),
        array(
            'from'=> '<basepath>/language/gallery.en_us.php',
            'to_module'=> 'DynamicFields',
            'language'=>'en_us'
        ),
        array(
            'from'=> '<basepath>/language/modulebuilder.ru_ru.php',
            'to_module'=> 'ModuleBuilder',
            'language'=>'ru_ru'
        ),
        array(
            'from'=> '<basepath>/language/modulebuilder.en_us.php',
            'to_module'=> 'ModuleBuilder',
            'language'=>'en_us'
        ),
    ),

  'vardefs' => array ( ),

  'custom_fields' => array( ),
);
