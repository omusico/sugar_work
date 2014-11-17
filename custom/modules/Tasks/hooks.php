<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
class processRecord{

    function statusColorize(&$bean){
		if($bean->status=='Completed')
			$bean->name .= "<img style='display:none;' src='themes/default/images/help.gif' width='0' height='0' onload=\"this.parentNode.parentNode.parentNode.parentNode.style.backgroundColor = '#ddd';\" />";
		elseif($bean->status=='In Progress')
			$bean->name .= "<img style='display:none;' src='themes/default/images/help.gif' width='0' height='0' onload=\"this.parentNode.parentNode.parentNode.parentNode.style.backgroundColor = '#cfc';\" />";
    }
}