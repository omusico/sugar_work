<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


if (!isset($_SESSION['SHOW_DUPLICATES']))
    sugar_die("Unauthorized access to this area.");

parse_str($_SESSION['SHOW_DUPLICATES'],$_POST);
unset($_SESSION['SHOW_DUPLICATES']);


global $app_strings;
global $app_list_strings;
global $theme;

$error_msg = '';
global $current_language;
$mod_strings = return_module_language($current_language, 'RealtyTemplates');
$moduleName = $GLOBALS['app_list_strings']['moduleList']['RealtyTemplates'];
echo getClassicModuleTitle('RealtyTemplates', array($moduleName,$mod_strings['LBL_SAVE_REALTYTEMPLATES']), true);
$xtpl=new XTemplate ('modules/RealtyTemplates/ShowDuplicates.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("MODULE", $_REQUEST['module']);
if ($error_msg != '')
{
	$xtpl->assign("ERROR", $error_msg);
	$xtpl->parse("main.error");
}

if((isset($_REQUEST['popup']) && $_REQUEST['popup'] == 'true') ||(isset($_POST['popup']) && $_POST['popup']==true)) insert_popup_header($theme);


$realtytemplates = new RealtyTemplates();
require_once('modules/RealtyTemplates/RealtyTemplatesFormBase.php');
$realtytemplatesForm = new RealtyTemplatesFormBase();
$GLOBALS['check_notify'] = FALSE;


$query = 'SELECT realtytemplates.id, realtytemplates.name, realtytemplates.address_street, realtytemplates.owner_phone FROM realtytemplates WHERE realtytemplates.deleted = 0 ';
$duplicates = $_POST['duplicate']; 
$count = count($duplicates);
if ($count > 0)
{
	$query .= "AND (";
	$first = true; 
	foreach ($duplicates as $duplicate_id) 
	{
		if (!$first) $query .= ' OR ';
		$first = false;
		$query .= "realtytemplates.id = '$duplicate_id' ";
	}
	$query .= ')';
}

$duplicateRealtyTemplates = array();

$db = DBManagerFactory::getInstance();
$result = $db->query($query);
$i=0;
$sea = new SugarEmailAddress();
while (($row=$db->fetchByAssoc($result)) != null) {
    foreach ($row as $key=>$value)
    {
        if ($value == $_POST['RealtyTemplates'.$key] && !empty($value))
            $duplicateRealtyTemplates[$i][$key] = '<span style="color: red;">'.$value.'</span>';
        else
            $duplicateRealtyTemplates[$i][$key] = $value;
    }
	//$duplicateRealtyTemplates[$i] = $row;
    $emails = $sea->getAddressesByGUID($row['id'],'RealtyTemplates');
    $duplicateRealtyTemplates[$i]['email'] = '';
    foreach ($emails as $email){
        if (in_array($email['email_address'], $_POST)){
            $duplicateRealtyTemplates[$i]['email'] .=  '<span style="color: red;">'.$email['email_address'].'</span><br>';
        }
        else{
            $duplicateRealtyTemplates[$i]['email'] .= $email['email_address'].'<br>';
        }
    }
	$i++;
}

$xtpl->assign('FORMBODY', $realtytemplatesForm->buildTableForm($duplicateRealtyTemplates));

$input = '';
foreach ($realtytemplates->column_fields as $field)
{	
	if (!empty($_POST['RealtyTemplates'.$field])) {
		$input .= "<input type='hidden' name='$field' value='${_POST['RealtyTemplates'.$field]}'>\n";
	}
}

foreach ($realtytemplates->additional_column_fields as $field)
{	
	if (!empty($_POST['RealtyTemplates'.$field])) {
		$input .= "<input type='hidden' name='$field' value='${_POST['RealtyTemplates'.$field]}'>\n";
	}
}
$input .= "<input type='hidden' name='record' value='{$_GET['record']}'>\n";
// Bug 25311 - Add special handling for when the form specifies many-to-many relationships
if(!empty($_POST['RealtyTemplatesrelate_to'])) {
    $input .= "<input type='hidden' name='relate_to' value='{$_POST['RealtyTemplatesrelate_to']}'>\n";
}
if(!empty($_POST['RealtyTemplatesrelate_id'])) {
    $input .= "<input type='hidden' name='relate_id' value='{$_POST['RealtyTemplatesrelate_id']}'>\n";
}


$emailAddress = new SugarEmailAddress();
$input .= $emailAddress->getEmailAddressWidgetDuplicatesView($realtytemplates);

$get = '';
if(!empty($_POST['return_module'])) $xtpl->assign('RETURN_MODULE', $_POST['return_module']);
else $get .= "RealtyTemplates";
$get .= "&return_action=";
if(!empty($_POST['return_action'])) $xtpl->assign('RETURN_ACTION', $_POST['return_action']);
else $get .= "DetailView";

///////////////////////////////////////////////////////////////////////////////
////	INBOUND EMAIL WORKFLOW
if(isset($_REQUEST['inbound_email_id'])) {
	$xtpl->assign('INBOUND_EMAIL_ID', $_REQUEST['inbound_email_id']);
	$xtpl->assign('RETURN_MODULE', 'Emails');	
	$xtpl->assign('RETURN_ACTION', 'EditView');
	if(isset($_REQUEST['start'])) {
		$xtpl->assign('START', $_REQUEST['start']);
	}
		
}
////	END INBOUND EMAIL WORKFLOW
///////////////////////////////////////////////////////////////////////////////



if(!empty($_POST['popup'])) 
	$input .= '<input type="hidden" name="popup" value="'.$_POST['popup'].'">';
else 
	$input .= '<input type="hidden" name="popup" value="false">';

if(!empty($_POST['to_pdf'])) 
	$input .= '<input type="hidden" name="to_pdf" value="'.$_POST['to_pdf'].'">';
else 
	$input .= '<input type="hidden" name="to_pdf" value="false">';
	
if(!empty($_POST['create'])) 
	$input .= '<input type="hidden" name="create" value="'.$_POST['create'].'">';
else 
	$input .= '<input type="hidden" name="create" value="false">';

if(!empty($_POST['RealtyTemplatesgallery_c']))
    $input .= '<input type="hidden" name="RealtyTemplatesgallery_c" value="'.$_POST['RealtyTemplatesgallery_c'].'">';

if(!empty($_POST['return_id'])) $xtpl->assign('RETURN_ID', $_POST['return_id']);

$input .= '<input type="hidden" name="em_dup" value="1">';

$xtpl->assign('INPUT_FIELDS',$input);
$xtpl->parse('main');
$xtpl->out('main');

?>
