<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/RealtyTemplates/RealtyTemplatesFormBase.php');
$realtyForm = new RealtyTemplatesFormBase();
$prefix = empty($_REQUEST['dup_checked']) ? '' : 'RealtyTemplates';
$realtyForm->handleSave($prefix, true, false);