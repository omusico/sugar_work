<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
class Presentation
{ 
    function row(&$bean, $event, $arguments){
		if ($_REQUEST['return_module'] == "Contacts" || $_REQUEST['module'] == "Contacts"){
			$bean->presentation_checked = "<input type=checkbox name=done id='{$bean->id}' value='{$bean->id}' class='presentationC' >"; 
			$this->get_presentation_text($bean);
		}
		if ($_REQUEST['return_module'] == "Accounts" || $_REQUEST['module'] == "Accounts"){
			$bean->presentation_checked = "<input type=checkbox name=done id='{$bean->id}' value='{$bean->id}' class='presentationA' >"; 
			$this->get_presentation_text($bean);
		}
		if ($_REQUEST['return_module'] == "Realty" || $_REQUEST['module'] == "Realty"){
			$bean->presentation_checked = "<input type=checkbox name=done id='{$bean->id}' value='{$bean->id}' class='presentationR' >"; 
			$this->get_presentation_text($bean);
		}
    }
	
	function get_presentation_text(&$bean){
		global $db;
		$sql = "SELECT rrit.presentation_text FROM realty_requests_interest_table as rrit LEFT JOIN request as r ON r.id = rrit.request_id  WHERE r.parent_id = '{$_GET['record']}' AND rrit.realty_id = '{$bean->id}' AND rrit.deleted = 0";
		$res = $db->query($sql);
		if($row = $db->fetchByAssoc($res))
			$bean->presentation_text = $row['presentation_text'];
	}
}