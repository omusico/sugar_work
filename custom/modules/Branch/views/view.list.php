<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class BranchViewList extends ViewList {

	public function preDisplay()
	{
		parent::preDisplay();
		$this->lv->delete=false;
	}
}
