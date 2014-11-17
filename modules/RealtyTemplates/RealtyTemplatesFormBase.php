<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * Description:  Base form for realtytemplates
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/SugarObjects/forms/PersonFormBase.php');

class RealtyTemplatesFormBase extends PersonFormBase {

var $moduleName = 'RealtyTemplates';
var $objectName = 'RealtyTemplates';

/**
 * getDuplicateQuery
 *
 * This function returns the SQL String used for initial duplicate RealtyTemplates check
 *
 * @see checkForDuplicates (method), RealtyTemplatesFormBase.php, LeadFormBase.php, ProspectFormBase.php
 * @param $focus sugarbean
 * @param $prefix String value of prefix that may be present in $_POST variables
 * @return SQL String of the query that should be used for the initial duplicate lookup check
 */
public function getDuplicateQuery($focus, $prefix='')
{
	$query = "SELECT realtytemplates.id, realtytemplates.address_street, realtytemplates.owner_phone FROM realtytemplates
	 WHERE realtytemplates.deleted = 0 AND (";

    if(!empty($_POST[$prefix.'record'])) {
        $query .= "realtytemplates.id != '". $_POST[$prefix.'record'] ."' AND (";
    }

    if(isset($_POST[$prefix.'owner_phone']) && strlen($_POST[$prefix.'owner_phone']) != 0) {
        $query .= "realtytemplates.owner_phone LIKE '". $_POST[$prefix.'owner_phone'] . "' ";
    }

    if(isset($_POST[$prefix.'address_street']) && strlen($_POST[$prefix.'address_street']) != 0) {
        $query .= "OR realtytemplates.address_street LIKE '". $_POST[$prefix.'address_street'] . "' ";
    }

    if(!empty($_POST[$prefix.'record'])) {
        $query .= ')';
    }

    $query .= ')';

    return $query;
}

    function checkForDuplicates($prefix)
    {
        parent::checkForDuplicates($prefix);

        require_once('include/formbase.php');
        require_once('include/MVC/SugarModule.php');
        $focus = SugarModule::get($this->moduleName)->loadBean();

        $query = $this->getDuplicateQuery($focus, $prefix);

        if(empty($query))
        {
            return null;
        }

        $rows = array();

        global $db;
        $result = $db->query($query);

        //Loop through the results and store
        while (($row = $db->fetchByAssoc($result)) != null)
        {
            if(!isset($rows[$row['id']])) {
                $rows[]=$row;
            }
        }

        //Now check for duplicates using email values supplied
        $count = 0;
        $emails = array();
        $emailStr = '';
        while(isset($_POST["{$this->moduleName}{$count}emailAddress{$count}"]))
        {
            $emailStr .= ",'" . strtoupper(trim($_POST["{$this->moduleName}{$count}emailAddress" . $count++])) . "'";
        } //while

        if(!empty($emailStr))
        {
            $emailStr = substr($emailStr, 1);
            $query = 'SELECT DISTINCT er.bean_id AS id FROM email_addr_bean_rel er, ' .
                'email_addresses ea WHERE ea.id = er.email_address_id ' .
                'AND ea.deleted = 0 AND er.deleted = 0 AND er.bean_module = \'' . $this->moduleName . '\' ' .
                'AND email_address_caps IN (' . $emailStr . ')  AND er.bean_id != "' . $_REQUEST['record'] . '"' ;

            $result = $db->query($query);
            while (($row = $db->fetchByAssoc($result)) != null)
            {
                if(!isset($rows[$row['id']])) {
                    $query2 = "SELECT id, name FROM {$focus->table_name} WHERE deleted=0 AND id = '" . $row['id'] . "'";
                    $result2 = $db->query($query2);
                    $r = $db->fetchByAssoc($result2);
                    if(isset($r['id'])) {
                        $rows[]=$r;
                    }
                } //if
            }
        } //if

        return !empty($rows) ? $rows : null;
    }

function handleSave($prefix, $redirect=true, $useRequired=false){
	global $theme, $current_user;

	require_once('include/formbase.php');
        $galleria = $_POST['galleria_c'];
	$focus = new RealtyTemplates();

    if (!empty($_POST[$prefix.'new_reports_to_id'])) {
        $focus->retrieve($_POST[$prefix.'new_reports_to_id']);
        $focus->reports_to_id = $_POST[$prefix.'record'];
    } else {
        $focus = populateFromPost($prefix, $focus);
    }
        if(isset($galleria))
        {
            $focus->galleria_c = $galleria;
        }
	if($useRequired &&  !checkRequired($prefix, array_keys($focus->required_fields))){
		return null;
	}

	if(!$focus->ACLAccess('Save')){
			ACLController::displayNoAccess(true);
			sugar_cleanup(true);
	}

	if (isset($GLOBALS['check_notify'])) {
		$check_notify = $GLOBALS['check_notify'];
	}
	else {
		$check_notify = FALSE;
	}

	if (empty($_POST['dup_checked'])) {

		$duplicateRealtyTemplates = $this->checkForDuplicates($prefix);

		if(isset($duplicateRealtyTemplates)){

            $focus->possible_duplicate = 1;

            $_SESSION['duplicateRealtyTemplates'] = $duplicateRealtyTemplates;

			$location='module=RealtyTemplates&action=ShowDuplicates&record='.$_POST['record'];
			$get = '';
			if(isset($_POST['inbound_email_id']) && !empty($_POST['inbound_email_id'])) {
				$get .= '&inbound_email_id='.$_POST['inbound_email_id'];
			}

			// Bug 25311 - Add special handling for when the form specifies many-to-many relationships
			if(isset($_POST['relate_to']) && !empty($_POST['relate_to'])) {
				$get .= '&RealtyTemplatesrelate_to='.$_POST['relate_to'];
			}
			if(isset($_POST['relate_id']) && !empty($_POST['relate_id'])) {
				$get .= '&RealtyTemplatesrelate_id='.$_POST['relate_id'];
			}

			//add all of the post fields to redirect get string
			foreach ($focus->column_fields as $field)
			{
				if (!empty($focus->$field) && !is_object($focus->$field))
				{
					$get .= "&RealtyTemplates$field=".urlencode($focus->$field);
				}
			}

			foreach ($focus->additional_column_fields as $field)
			{
				if (!empty($focus->$field))
				{
					$get .= "&RealtyTemplates$field=".urlencode($focus->$field);
				}
			}

			if($focus->hasCustomFields()) {
				foreach($focus->field_defs as $name=>$field) {
					if (!empty($field['source']) && $field['source'] == 'custom_fields')
					{
						$get .= "&RealtyTemplates$name=".urlencode($focus->$name);
					}
				}
			}


			$emailAddress = new SugarEmailAddress();
			$get .= $emailAddress->getFormBaseURL($focus);


			//create list of suspected duplicate realtytemplates id's in redirect get string
			$i=0;
			foreach ($duplicateRealtyTemplates as $realtytemplates)
			{
				$get .= "&duplicate[$i]=".$realtytemplates['id'];
				$i++;
			}

			//add return_module, return_action, and return_id to redirect get string
			$get .= "&return_module=";
			if(!empty($_POST['return_module'])) $get .= $_POST['return_module'];
			else $get .= "RealtyTemplates";
			$get .= "&return_action=";
			if(!empty($_POST['return_action'])) $get .= 'EditView';
			//else $get .= "DetailView";
			if(!empty($_POST['return_id'])) $get .= "&return_id=".$_POST['return_id'];
			if(!empty($_POST['popup'])) $get .= '&popup='.$_POST['popup'];
			if(!empty($_POST['create'])) $get .= '&create='.$_POST['create'];

			// for InboundEmail flow
			if(!empty($_POST['start'])) $get .= '&start='.$_POST['start'];

            $_SESSION['SHOW_DUPLICATES'] = $get;
            //now redirect the post to modules/RealtyTemplates/ShowDuplicates.php
            if (!empty($_POST['is_ajax_call']) && $_POST['is_ajax_call'] == '1')
            {
            	ob_clean();
                $json = getJSONobj();
                echo $json->encode(array('status' => 'dupe', 'get' => $location));
            }
            else if(!empty($_REQUEST['ajax_load']))
            {
                echo "<script>SUGAR.ajaxUI.loadContent('index.php?$location');</script>";
            }
            else {
                if(!empty($_POST['to_pdf'])) $location .= '&to_pdf='.$_POST['to_pdf'];
                header("Location: index.php?$location");
            }
            return null;
		}
	}


	$focus->save($check_notify);
	$return_id = $focus->id;

	$GLOBALS['log']->debug("Saved record with id of ".$return_id);


//    $focus->load_relationship('realtytemplates_realtytemplates_1');
//    $focus->realtytemplates_realtytemplates_1->delete($focus->id);

//    foreach ($_SESSION['duplicateRealtyTemplates'] as $realtytemplates)
//    {
//        $focus->realtytemplates_realtytemplates_1->add($realtytemplates['id']);
//    }

    $_SESSION['duplicateRealtyTemplates'] = array();


	if(isset($_POST['popup']) && $_POST['popup'] == 'true') {
		$get = '&module=';
		if(!empty($_POST['return_module'])) $get .= $_POST['return_module'];
		else $get .= 'RealtyTemplates';
		$get .= '&action=';
		if(!empty($_POST['return_action'])) $get .= $_POST['return_action'];
		else $get .= 'Popup';
		if(!empty($_POST['return_id'])) $get .= '&return_id='.$_POST['return_id'];
		if(!empty($_POST['popup'])) $get .= '&popup='.$_POST['popup'];
		if(!empty($_POST['create'])) $get .= '&create='.$_POST['create'];
		if(!empty($_POST['to_pdf'])) $get .= '&to_pdf='.$_POST['to_pdf'];
		$get .= '&name=' . urlencode($focus->name);
		$get .= '&query=true';
		header("Location: index.php?$get");
		return;
	}

	if($redirect){
		$this->handleRedirect($return_id);
	}else{
		return $focus;
	}
}





function handleRedirect($return_id){
	if(isset($_POST['return_module']) && $_POST['return_module'] != "") {
		$return_module = $_POST['return_module'];
	}
	else {
		$return_module = "RealtyTemplates";
	}

	if(isset($_POST['return_action']) && $_POST['return_action'] != "") {
		if($_REQUEST['action'] == "Save" && $_REQUEST['return_module'] != "Home") {
			$return_action = 'DetailView';
		} else {
			// if we "Cancel", we go back to the list view.
			$return_action = $_REQUEST['return_action'];
		}
	}
	else {
		$return_action = "DetailView";
	}

	if(isset($_POST['return_id']) && $_POST['return_id'] != "") {
        $return_id = $_POST['return_id'];
	}

	//eggsurplus Bug 23816: maintain VCR after an edit/save. If it is a duplicate then don't worry about it. The offset is now worthless.
 	$redirect_url = "index.php?action=$return_action&module=$return_module&record=$return_id";
 	if(isset($_REQUEST['offset']) && empty($_REQUEST['duplicateSave'])) {
 	    $redirect_url .= "&offset=".$_REQUEST['offset'];
 	}

    if(!empty($_REQUEST['ajax_load'])){
        echo "<script>SUGAR.ajaxUI.loadContent('$redirect_url');</script>\n";
    }
    else {
        header("Location: ". $redirect_url);
    }
}

}


?>
