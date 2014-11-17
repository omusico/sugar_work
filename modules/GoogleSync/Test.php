<?php
ini_set('display_errors', 'On');
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once "modules/GoogleSync/GoogleSync.php";

GoogleSync::init();
GoogleSync::test();

?>