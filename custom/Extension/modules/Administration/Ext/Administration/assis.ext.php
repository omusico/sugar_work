<?php 
			
$admin_option_defs = array();

$admin_option_defs['Administration']['config5'] = array(
				'',
				'Войти в Assis',
				"Войти в Assis",
				'./index.php?module=Realty&action=LoginAssis'
		); 

$admin_option_defs['Administration']['config6']= array(
				'',
				'Выйти из Assis',
				'Выйти из Assis',
				'./index.php?module=Administration&action=customUsage'
		);

$admin_group_header[]= array(
				'Assis JSON',
				'',
				false,
				$admin_option_defs, 
				'Модуль интеграции Assis.'
		);
		
?>
