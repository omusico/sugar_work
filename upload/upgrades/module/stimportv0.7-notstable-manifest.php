<?php
$manifest = array(
	'acceptable_sugar_versions' => array(
		'regex_matches' => array(
			'6\.*',
		),
	),
	'acceptable_sugar_flavors' => array(
		0 => 'OS',
		1 => 'PRO',
		2 => 'ENT',
		3 => 'CE',
	),
	'readme' => '',
	'name' => 'SugarTalkImport',
	'description' => 'SugarTalk csv import',
	'author' => 'sugartalk.ru',
	'published_date' => '19/06/2014',
	'version' => '0.7',
	'type' => 'module',
	'is_uninstallable' => true,
);

$installdefs = array(
	'id' => 'SugarTalkImport',
	'copy' => array(
		array(
			'from' => '<basepath>/modules/Import/DoImport.php',
			'to' => 'modules/Import/DoImport.php',
		),
		array(
			'from' => '<basepath>/modules/Import/GetModules.php',
			'to' => 'modules/Import/GetModules.php',
		),
		array(
			'from' => '<basepath>/modules/Import/stimport.js',
			'to' => 'modules/Import/stimport.js',
		),
		array(
			'from' => '<basepath>/modules/Import/stimport1.php',
			'to' => 'modules/Import/stimport1.php',
		),
		array(
			'from' => '<basepath>/modules/Import/stimport2.php',
			'to' => 'modules/Import/stimport2.php',
		),
		array(
			'from' => '<basepath>/modules/Import/stimport3.php',
			'to' => 'modules/Import/stimport3.php',
		),
		array(
			'from' => '<basepath>/modules/Import/ImportUtils.php',
			'to' => 'modules/Import/ImportUtils.php',
		),
		array(
			'from' => '<basepath>/modules/Import/importajax.js',
			'to' => 'modules/Import/importajax.js',
		),
		array(
			'from' => '<basepath>/modules/Import/importajax.php',
			'to' => 'modules/Import/importajax.php',
		),
		array(
			'from' => '<basepath>/custom/include/globalControlLinks.php',
			'to' => 'custom/include/globalControlLinks.php',
		),
	),
);