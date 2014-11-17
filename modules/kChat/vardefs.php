<?php
/*$dictionary['kChat'] = array(
	'fields'=>array(
		'room'=>array(
			'name' => 'room',
			'type' => 'varchar',
		),
	),
	/*'relationships'=>array(
		
	),*/
//);
if($_REQUEST['action']=='repair'){
	if (!class_exists('VardefManager'))
		require_once('include/SugarObjects/VardefManager.php');
	VardefManager::createVardef('kChat','kChat', array('basic','assignable'));
}
?>