<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.list.php');

class acl_fieldsViewList extends ViewList
{
 	public function preDisplay()
 	{

 		parent::preDisplay();
 		$this->lv->targetList = true;
        echo('<script src="modules/acl_fields/js/acl_fields.js"></script>');
 	}
}
