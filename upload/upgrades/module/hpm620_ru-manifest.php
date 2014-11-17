<?PHP
	$manifest = array(
		'acceptable_sugar_versions' => array(
			'regex_matches' => array(
				0 => "6\.2\.*",
				1 => "6\.1\.*",
				2 => "6\.2\.*",
				3 => "6\.5\.*",
			),
		),
		'acceptable_sugar_flavors' => array (
			0 => 'CE',
			1 => 'PRO',
			2 => 'ENT',
		),
		'name'             => 'Ken Brill: Homepage Manager',
		'description'      => 'An Upgrade Safe Homepage Manager',
		'is_uninstallable' => true,
		'author'           => 'Ken Brill',
		'published_date'   => '2011/04/15',
		'version'          => '6.20',
		'type'             => 'module',
		'icon'             => '',
	);

	$installdefs = array(
		'id'   => 'hpm_kbrill',
		'copy' => array(
			array(
				'from' => '<basepath>/files/modules/Users/EditHomepageSettings.php',
				'to'   => 'custom/modules/Users/EditHomepageSettings.php'
			),
			array(
				'from' => '<basepath>/files/modules/Users/homepage_manager.php',
				'to'   => 'custom/modules/Users/homepage_manager.php'
			),
		),
		'language'=> array (
			array(
				'from'=> '<basepath>/files/Language/Administration/en_us.lang.php',
				'to_module'=> 'Administration',
				'language'=>'en_us'
			),
			array(
				'from'=> '<basepath>/files/Language/Users/en_us.lang.php',
				'to_module'=> 'Users',
				'language'=>'en_us'
			),
		),
 		'custom_fields'=>array (
			array (
				'name'=> 'hm_default_homepage',
				'label'=>'LBL_DEFAULT_HOMEPAGE',
				'type'=>'varchar',
				'max_size'=>255,
				'require_option'=>'optional',
				'default_value'=>'',
				'ext1' => '',
				'ext2' => '',
				'ext3' => ' ',
				'audited'=>1,
				'module'=>'Users',
				),
			array (
				'name'=> 'hm_only_once',
				'label'=>'LBL_HOMEPAGE_MANAGER_ONLY_ONCE',
				'type'=>'bool',
				'max_size'=>1,
				'require_option'=>'optional',
				'default_value'=>'0',
				'ext1' => '',
				'ext2' => '',
				'ext3' => ' ',
				'audited'=>1,
				'module'=>'Users',
				),
			array (
				'name'=> 'hm_toggle',
				'label'=>'LBL_HOMEPAGE_TOGGLE',
				'type'=>'bool',
				'max_size'=>1,
				'require_option'=>'optional',
				'default_value'=>'0',
				'ext1' => '',
				'ext2' => '',
				'ext3' => ' ',
				'audited'=>0,
				'module'=>'Users',
				),			
			array (
				'name'=> 'hm_lockhomepage',
				'label'=>'LBL_LOCK_HOMEPAGE',
				'type'=>'varchar',
				'max_size'=>25,
				'require_option'=>'optional',
				'default_value'=>'',
				'ext1' => '',
				'ext2' => '',
				'ext3' => ' ',
				'audited'=>1,
				'module'=>'Users',
				),				
			),
			'administration'=> array(  //this adds an entry to the Admin page
				array('from'=>'<basepath>/files/modules/Administration/Administration/administration.ext.php',
				),
			),		
			 'logic_hooks' => array(
				array(
					'module' => 'Users',
					'hook' => 'after_login',
					'order' => 67,
					'description' => 'Check users Homepage',
					'file' => 'custom/modules/Users/homepage_manager.php',
					'class' => 'defaultHomepage',
					'function' => 'afterLogin',
					),
				array(
					'module' => '', //no module means all modules
					'hook' => 'after_ui_frame',
					'order' => 67,
					'description' => 'Add Tab to User Editor',
					'file' => 'custom/modules/Users/homepage_manager.php',
					'class' => 'defaultHomepage',
					'function' => 'addTab',
					),					
				array(
					'module' => '', //no module means all modules
					'hook' => 'after_retrieve',
					'order' => 68,
					'description' => 'Lock Individual Homepages',
					'file' => 'custom/modules/Users/homepage_manager.php',
					'class' => 'defaultHomepage',
					'function' => 'resetConfig',
					),					
				),		
	);
?>
