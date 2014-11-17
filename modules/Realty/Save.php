<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Realty/RealtyFormBase.php');
$realtyForm = new RealtyFormBase();
$prefix = empty($_REQUEST['dup_checked']) ? '' : 'Realty';
$realtyForm->handleSave($prefix, true, false);