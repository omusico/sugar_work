<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class OfficeReportsVariablesViewEdit extends ViewEdit
{

 	function OfficeReportsVariablesViewEdit()
 	{
 		parent::ViewEdit();
 	}

	function preDisplay()
	{
		if(file_exists("cache/modules/OfficeReportsVariables/EditView.tpl"))
		       unlink("cache/modules/OfficeReportsVariables/EditView.tpl");

		parent::preDisplay();
	}

 	function display()
 	{
 		global $current_language;

 		$this->ev->process();

		$this->ss->assign('CURRENT_LANG', substr($current_language, 0, 2));

		$json = getJSONobj();
		$this->ss->assign('field_name_exceptions',  $json->encode(Reports_Utils::getNameException()) );

 		echo $this->ev->display();
 	}
}
?>