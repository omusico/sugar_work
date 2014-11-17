<?php 
if(!defined('sugarEntry')) define('sugarEntry', true);
include_once('modules/Configurator/Configurator.php'); 
require_once('custom/sms/sms.php'); 
include_once('sugar_version.php');

if(!defined("MSG_UNVERIFIED")) 
	define("MSG_UNVERIFIED", "Невозможно подключить ваш аккаунт. Пожалуйста, повторите попытку или свяжитесь с провайдером для проверки.");

$sms = new sms();
$parent_link = "<a href='index.php?module=Administration&action=index'>Administration</a><span class='pointer'>&raquo;</span>";
 
if (isset($_GET['option'])) { 
 	 
	switch($_GET['option']) {
	
		case "smsUsage":
			require_once("custom/sms/sms.php");
			$sms = new sms();
			$usages = $sms->get_credit_usages();
			arsort($usages);
			if(sizeof($usages)) {
				echo "<div class='moduleTitle'><h2>{$parent_link}SMS Credit Usages</h2></div>";
				 
				echo "<div class='dashletPanelMenu'>";
				echo "<div class='hd'><div class='tl'></div><div class='hd-center'></div><div class='tr'></div></div>";
				echo "<div class='bd'><div class='ml'></div><div class='bd-center'><div class='screen'>"; 
				echo "<table  border='0' cellspacing='1' cellpadding='0' class='list view' width='100%'>";
				echo "<tr><th>Date</th><td scope='col'>Description</td><td scope='col'>Amount</td></tr>";
				foreach($usages as $val) {
					echo "<tr><td>" . date("M d, Y" , strtotime($val['date'])) . "</td>";
					echo "<td>{$val['description']}</td>";
					echo "<td>{$val['amount']}</td></tr>";
				} 
				echo "</table>";
				echo "</div><div class='mr'></div></div></div>";
				echo "<div class='ft'><div class='bl'></div><div class='ft-center'></div><div class='br'></div></div></div>";
				 
			}

			break;
	
		case "smsBalance":

			$sms->retrieve_settings();

			if (empty($sms->params['sms_instance_id'])) {
				echo "<div style='background-color:#fff;padding:10px;text-align:center;'>You have not specified an SMS gateway for this purpose. ";
				echo "Click <a href='./index.php?module=Administration&action=smsProvider'>here</a> to setup your gateway account.</div>";
				break;
			}
			$res = $sms->authenticate($sms->params['sms_instance_id']);

			echo "<div class='moduleTitle'><h2>{$parent_link}SMS Credit Balance</h2></div>";
			echo "<table class='edit view small' width='100%' border='0' cellspacing='1' cellpadding='0' ><tr><td>";
			echo "<div style='text-align:center; font-size:14px;padding:50px;'>";
			if ($res == 'ERROR') {
				echo MSG_UNVERIFIED;
			} else {
				if ($res == "POSTPAID") {
					echo "You are subscribed to a postpaid account.";
				} else {
					$res = (empty($res) or $res==0) ? "0.00" : $res;
					echo "You have <strong>{$res}</strong> sms credits in your account.";
				} 
			}
			echo "</div>";
			echo '</td></tr></table>';
			break;
			
		case "create_sms_config":
		
			$json = $_REQUEST['param']; 
			$param = parse_url($json);	 
			$query = explode("&", $param['query']);
			foreach($query as $element) {
				$buff = explode("=",$element);
				if ($buff[0]=="a")
					$sms->params["sms_instance_id"] = $buff[1];
				elseif($buff[0]=="n") 
					$sms->params["domain_name"] = $buff[1];
			}
			$sms->params["sugartalk_url"] = $sms->sms_center;
			$sms->params["sender"] = "sugartalk";
			$sms->save_settings();
			
			break;
	
		case "load_mod_fields": 
			if (isset($_GET["m"])) { 
				if ($_GET["m"] == '') {
					echo "<em>-Пожалуйста, выберите модуль-</em>";
				} else {
					require_once("modules/Administration/sugartalk_smsPhone/sms_enzyme.php");
					$e = new sms_enzyme($_GET["m"]);
					echo $e->load_module_fields('macro_field','select');
				}  
			}
			break; 
	
		case "macro":
		
			require_once("modules/Administration/sugartalk_smsPhone/sms_enzyme.php");
			include_once("modules/Administration/sugartalk_smsPhone/smsPhone.js.php"); 
			
			$e = new sms_enzyme();
			
			echo "<div class='moduleTitle'><h2>{$parent_link}SMS Параметры макросов</h2></div>";
			 
			if (isset($_POST['mod']) or isset($_POST['macro_to_remove'])) { 
				$except = isset($_POST['macro_to_remove']) ? $_POST['macro_to_remove'] : ""; 
				$e->save_sms_macro($_POST['mod'],$_POST['macro_field'],$_POST['macro_string'], $except); 
			}	 
  
			$del_btn = $e->delete_button_attributes($GLOBALS['sugar_version']);
			$mod_wd_macro = $GLOBALS["app_list_strings"]["sms_mod_macro_list"];
			
			echo "<form name='macro_remove' method='post' action='./index.php?module=Administration&action=smsProvider&option=macro'>";
			echo "<input type='hidden' name='macro_to_remove' id='macro_to_remove' value=''>";
			echo "<table border='0' cellspacing='0' cellpadding='0' width='400px' class='edit view'>";
			echo "<th colspan='3'>SMS Macro List</th>";
			if (sizeof($mod_wd_macro)) {
				$ctr=1;
				foreach($mod_wd_macro as $k => $v) {
					$fld = substr($v, 0, strpos($v, ":"));
					$mac = substr($v, strpos($v, ":")+1);
					$tr_class = ($ctr%2==0) ? "evenListRowS1" : "oddListRowS1";
					echo "<tr class='{$tr_class}'><td>{$k} {{$fld}}</td><td>{$mac}</td>";
					echo "<td align='center'><img src=\"{$del_btn['src']}\" class=\"{$del_btn['class']}\" onclick=\"rem_sms_macro('{$k}');\"></td></tr>";
					$ctr++;
				}
			} else {
				echo "<tr><td colspan='3' align='center'><em>-no macros-</em></td></tr>";
			}
			echo "</table></form><br><br>";
			
			$modules = $GLOBALS['moduleList'];
			asort($modules);
			echo "<form name='macro_form' method='post' action='./index.php?module=Administration&action=smsProvider&option=macro'>"; 
			echo "<table border='0' cellspacing='0' cellpadding='0' class='edit view'>";
			echo "<tr class='pagination'>";
			echo "<th>Select a module</th>";
			echo "<th>Select a field to associate the macro</th>";
			echo "<th>SMS Macro</th>";
			echo "</tr><tr>"; 
			echo "<td valign='top'><select name='mod' id='mod' onchange=\"load_fields('select')\"  style='width:100%;'><option value=''></option>"; 
			foreach($modules as $mod) {
				$key = ($mod=='-BLANK-') ? "" : $mod;
				$val = ($mod=='-BLANK-') ? "" : $GLOBALS["app_list_strings"]["moduleList"][$mod];
				echo "<option value='{$key}'>" . $val . "</option>";
			} 
			echo "</select></td>";
			echo "<td valign='top' id='field_cell'><em>-Please select a module-</em></td>";
			echo "<td valign='top' align='center'><input type='text' name='macro_string' id='macro_string' value='' style='width:95%;'><br>";
			echo "Set this to any value, but preserve the <strong >\"%1\"</strong>.</td>";
			echo "</tr></table>"; 
			echo "<div  >";
			echo "<input type='button' id='save' class='button' onclick=\"if (check_macro_requirements()) document.macro_form.submit();\" value='Save'>";
			echo "</div></form> "; 

			echo "<div style='clear:both; margin-top:10px;'></div>";

			break;
		case "save":
			if (isset($_POST)) { 
				foreach($_POST as $fld => $val) {   
					$sms->params[$fld] = $val;
				} 
				$sms->save_settings(); 
                echo "<span style='color:#000'>Настройки успешно сохранены.</span>";
			} else {
				echo "Данные, которые вы пытались сохранить - пустые.";
			} 
			break;

                        //Не используется
		case "test_conn": 
			if (!empty($_POST['account_id'])) {  
//				$sms->params['sugartalk_url'] = $_POST['sugartalk_url'];
//				$sms->params['domain_name'] = $_POST['domain_name'];
//				$res = $sms->authenticate($_POST['account_id']);

                $sms->params['sugartalk_url'] = 'https://web.mirsms.ru';
                $sms->params['domain_name'] = 'SPaR97';
                $res = $sms->authenticate('22730');
                if ($res == 'ERROR') {
					echo "<div>".MSG_UNVERIFIED."<div>";
				} else {
					echo "<div>Account verified.</div>";
					if ($res == "POSTPAID") {
						echo "<div>You are allowed to send unlimited number of text messages.</div>";
					} else {
						$res = (empty($res) or $res==0) ? "0.00" : $res;
						echo "<div>You have <strong>{$res}</strong> sms credits on your account.</div>";
					}
				}  
			} else {
				echo "The data you were trying to save is empty.";
			} 
			break;
			
		case "send":   
		
			$sms->retrieve_settings();  
			
			if (empty($sms->params['sms_instance_id'])) {
				echo "<div style='background-color:#fff;padding:10px;text-align:center;'>Вы не настроили SMS шлюз. ";
                                echo "Нажмите <a href='./index.php?module=Administration&action=smsProvider'>сюда</a>, чтобы настроить шлюз.</div>";
				break;
			} 
			
			if ($sms->authenticate($sms->params['sms_instance_id']) == 'ERROR') {
				echo MSG_UNVERIFIED;
				break;
			}
			
			if(isset($_POST) && !empty($_POST)) {  
				
				if ($_POST["send_to_multi"]) { 

					#multiple recipient 
					$sms->params = $sms->params;  
					$sms->parent_type = $_POST['ptype']; 
					 
					$mod_key_sing = $GLOBALS["beanList"][$_POST['ptype']];
					$object_name = $mod_key_sing=='aCase' ? 'Case' : $mod_key_sing;
					$mod_bean_files = $GLOBALS["beanFiles"][$mod_key_sing];  
 					
					# retrieve configured SMS phone field for the active module
					require_once("modules/Administration/sugartalk_smsPhone/sms_enzyme.php");
					$e = new sms_enzyme($_POST['ptype']);
					$sms_field = $e->get_custom_phone_field(); 
 				 	
					$summary = array();
					$pids = explode(",", $_POST['pid']); 
					if (sizeof($pids) && $sms_field!=NULL) {
						require_once($mod_bean_files);
						$number = array();
						$recipient = array();
						foreach($pids as $pid) { 
							$parent = new $object_name;
							if($parent->retrieve($pid)) {
								$fone = preg_replace('/[^0-9]/', '', $parent->$sms_field);  
								$number[$pid] = array($parent->name, $fone); 
								$recipient[$pid]['name'] = $parent->name;  
							}  
						}  
						if(!empty($number)){ 
							$summary = $sms->send_batch_message($number, $_POST["sms_msg"]);
						}
						echo "SUMMARY:<br>";
						 
						if (is_array($summary)) { 
							echo "<table width='100%' border='0' cellpadding='2'>"; 
							foreach ($summary as $pid => $val) {
//                                $parent2 = new $object_name;
//                                $parent2->retrieve($pid);
                                if ($val[0] == "SENT")
                                {
								echo "<tr><td valign='top'>" . $recipient[$pid]['name'] . "</td>";
                                echo "<td valign='top'>" . $val[1] . "</td>";
								echo "<td valign='top'>Сообщение отправлено</td></tr>";
                                                                echo "<td valign='top'>Нажмите F5</td></tr>";
                                }
                                else
                                {
                                    echo "<tr><td valign='top'>" . $recipient[$pid]['name'] . "</td>";
                                    echo "<td valign='top'>" . $val[1] . "</td>";
                                    echo "<td valign='top'>Сообщение не отправлено</td></tr>";
                                    echo "<td valign='top'>Нажмите F5</td></tr>";
                                }

							} 
							echo "</table>";
						} else {
							echo $summary;
						}
						echo "<div style='margin-top:15px;'>Нажмите F5, чтобы закрыть это сообщение.</div>";
					}  
					
				}  else { 
					
					# single recipient
					$sms->parent_type = $_POST['ptype'];
					$sms->parent_id = $_POST['pid'];
					$sms->pname = $_POST["pname"];  

                                        $resp = $sms->send_message($_POST["num"], $_POST["sms_msg"]);
                                        if ($resp == "SENT") {
                                            echo "Сообщение успешно отправленно. Нажмите F5";
                                            //echo "<td valign='top'>Нажмите F5</td></tr>";
                                        }
                                        else {
                                            echo "Сообщение не отправленно. Нажмите F5";
                                            //echo "<td valign='top'>Нажмите F5</td></tr>";
                                        }
				}   
			 
			} else {
				echo "Отправка сообщения не удалась. Представленные данные пусты.";
			}  
			break; 
		
		case "resend":
 			$sms->retrieve_settings(); 
			if ($sms->authenticate($sms->params['sms_instance_id']) == 'ERROR') {
				echo MSG_UNVERIFIED;
				break;
			}
			if (empty($sms->params['sms_instance_id'])) {
				echo "<div style='background-color:#fff;padding:10px;text-align:center;'>Вы не настроили SMS шлюз. ";
                                echo "Нажмите <a href='./index.php?module=Administration&action=smsProvider'>сюда</a>, чтобы настроить шлюз.</div>";
				break;
			}
			if (isset($_POST) and !empty($_POST['rec']) and !empty($_POST['num'])) {   
				echo $sms->resend($_POST['rec'], $_POST['num'], $_POST['sms_msg']);
			} 
			break;

		case "balance":
 			$sms->retrieve_settings();
			if (empty($sms->params['sms_instance_id'])) {
				echo "<div style='background-color:#fff;padding:10px;text-align:center;'>Вы не настроили SMS шлюз. ";
                                //echo "Нажмите <a href='./index.php?module=Administration&action=smsProvider'>сюда</a>, чтобы настроить шлюз.</div>";
				break;
			}
                        $resp = $sms->balance();
                        echo $resp;
			break;

		case "editor":
		
		 	$sms->retrieve_settings();

			if (empty($sms->params['sms_instance_id'])) {
				echo "<div style='background-color:#fff;padding:10px;text-align:center;'>Вы не настроили SMS шлюз. ";
                                echo "Нажмите <a href='./index.php?module=Administration&action=smsProvider'>сюда</a>, чтобы настроить шлюз.</div>";
				break;
			}

			if (isset($_GET['rec'])) {
			
				$sugartalk_SMS = new sugartalk_SMS();
				$sugartalk_SMS->retrieve($_GET['rec']);
				$phone_number = $sugartalk_SMS->phone_number;
				$msg = $sugartalk_SMS->description;
				$pid = $sugartalk_SMS->id;	// uses $pid to store the record id
				$ptype = $sugartalk_SMS->parent_type; // not really needed but may be later
				$pname = $sugartalk_SMS->name; // not really needed but may be later
				$onclick = "resend_sms();";
				$send_to_multi = '0';
				
			} else {
			
				$mod_key_sing = $GLOBALS["beanList"][$_GET['ptype']];
				$mod_bean_files = $GLOBALS["beanFiles"][$mod_key_sing]; 
				
				# retrieve configured SMS phone field for the active module  
				require_once("modules/Administration/sugartalk_smsPhone/sms_enzyme.php");
				$e = new sms_enzyme($_GET['ptype']); 
				$sms_field = $e->get_custom_phone_field(); 
				
				$msg = "";
				$pid = $_GET['pid'];
				$pids = explode(",", $pid);
				$ptype = $_GET['ptype'];
				$pname = isset($_GET['pname']) ? $_GET['pname'] : "";
				$phone_number = $_GET['num'];
				$onclick = "send_sms();";
				$send_to_multi = $_GET['num'] == 'multi' ? '1' : '0';

			}
 			
			include_once("modules/Administration/sugartalk_smsPhone/sms_editor.php");
			
			break;
		case "template":
			if (isset($_GET['id'])) {
				$et = new EmailTemplate();
				$et->retrieve($_GET['id']); 
				echo $et->body;
			}
			break;
			
		default:
			echo "";
	} 

} else  {	// just draw the gateway settings panel  
	 $_POST['account_id'] = '123';
	if (isset($_POST['account_id'])) {
		$flag = (isset($_POST['use_template'])) ? true : false;
		$sms->params['sms_instance_id'] = trim($_POST['account_id']);
		$sms->params['uses_sms_template'] = $flag;
		$sms->params['sugartalk_url'] = trim($_POST['sugartalk_url']);
		$sms->params['sender'] = trim($_POST['sender']);
        if (empty($_POST['domain_name']))
            $sms->params['domain_name'] = '123';
        else
		    $sms->params['domain_name'] = trim($_POST['domain_name']);
		$sms->params['default_country_code'] = trim($_POST['default_country_code']);
		$sms->params['local_prefix'] = trim($_POST['local_prefix']);
		$sms->save_settings();

	}
	   
 	include_once("modules/Administration/sugartalk_smsPhone/smsPhone.js.php");
 	$sms->retrieve_settings();
	
	if (empty($sms->params['sms_instance_id']) or empty($sms->params['domain_name'])) {
		// show registration form
		$country_list = $sms->get_supported_countries();  
		
		//GET USER IP AND COUNTRY INFO
        $ipAddr = $_SERVER["REMOTE_ADDR"];
        $country1 = file_get_contents("http://api.hostip.info/get_html.php?ip=".$ipAddr);
        $ip_country = substr($country1, stripos($country1,"Country:")+8, strpos($country1,"City") - stripos($country1,"Country:")-8)."<br>";
        $ip_country = substr($ip_country, 0, strpos($ip_country, "(")-1);
		
		?> 
		<!--script type="text/javascript" src="js/ajax.js?s=777d45bbbcdf50d49c42c70ad7acf5fe"></script-->
		<div class='moduleTitle'><h2><?=$parent_link?>Registration for Trial Account</h2></div>
		  
			<form method="post" name="WebToLeadForm" id="WebToLeadForm">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"  class="edit view"> 
					<tbody>  
						<tr>
							<td width='12%'><span sugar="slot">First Name: </span><span class="required">*</span></td>
							<td ><span sugar="slot"><input size="30" type="text" name="first_name" id="first_name" /></span></td>
						</tr>
						<tr>
							<td><span sugar="slot">Last Name: </span><span class="required">*</span></td>
							<td ><span sugar="slot"><input size="30" type="text" name="last_name" id="last_name" /></span></td>
						</tr>
						<tr>
							<td><span sugar="slot">Title: </span></td>
							<td ><span sugar="slot"><input size="30" type="text" name="title" id="title" /></span></td>
						</tr>
						<tr>
							<td><span sugar="slot">Company
								 Name: </span><span class="required">*</span></td>
							<td ><span sugar="slot"><input size="30" type="text" name="account_name" id="account_name" /></span></td>
						</tr> 
						<tr>
							<td><span sugar="slot">Country: </span><span class="required">*</span></td>
							<td ><span sugar="slot"><select onchange="document.getElementById('primary_address_country').value = this.options[this.selectedIndex].firstChild.nodeValue" name="primary_address_country_list" id="primary_address_country_list">
								<?php  
								foreach($country_list as $cnum => $c){
									$selected = ((strtoupper(trim($c))==trim($ip_country))?"SELECTED":"");
									echo "<option value='".trim($cnum)."' ".$selected.">".trim($c)."</option>";
								}
								?>
								</select></span>&nbsp;&nbsp;<span style="font-size:11px"><i>if "Others", please indicate in "Remark".</i></span><input type="hidden" name="primary_address_country" id="primary_address_country" value="<?php echo trim($ip_country); ?>"></td>
						</tr>
						<tr>
							<td><span sugar="slot">Mobile Phone: </span><span class="required">*</span></td>
							<td ><span sugar="slot"><input size="30" type="text" name="phone_work" id="phone_work" /></span></td>
						</tr>
						<tr>
							<td><span sugar="slot">Email: </span><span class="required">*</span></td>
							<td ><span sugar="slot"><input size="30" type="text" name="email1" id="email1" /></span></td>
						</tr>
						<tr>
							<td><span sugar="slot">Remark: </span></td>
							<td ><span sugar="slot"><textarea rows="8" cols="50" name="description" id="description"></textarea></span></td>
						</tr>  
					</tbody>
				</table>
				<input type="button" id = "submit_button" value="Submit" name="Submit" class="button" onclick="if(check_form('WebToLeadForm')) form_submit();" />
				<!--input type="hidden" name="redirect_url" id="redirect_url" value="http://www.sugartalk.com.sg/index2.php?option=com_content&view=article&id=80" /-->
				<input type="hidden" name="assigned_user_id" id="assigned_user_id" value="5a6dd7e9-b08c-5c4d-86bb-44312247f6a6" />
				<input type="hidden" name="team_id" id="team_id" value="61dae98d-92a8-3cc3-a1b5-443122ed8bd4" />
				<!--input type="hidden" name="req_id" id="req_id" value="last_name;first_name;phone_work;email1;account_name;primary_address_country_list;version;" /-->
				
				<input type="hidden" value="914ae7d1-d449-2d36-90dd-4ceb4cb33a23" name="campaign_id" id="campaign_id" />
				<input type="hidden" value="joomla" name="fromsite" id="fromsite" />
				<input type="hidden" value="Web Site" name="lead_source" id="lead_source" />
				<input type="hidden" value="?" name="jsoncallback" id="jsoncallback" >
				<input type="hidden" value="<?php echo $sugar_version; ?>" name="version" id="version">
				<input type="hidden" value="<?php echo $sugar_flavor; ?>" name="edition" id="edition">
			</form> 
		 
			<div id="debug" style="display:none"></div> 
			<script type='text/javascript'>
			
				addToValidate('WebToLeadForm', 'first_name', 'first_name', true, 'First Name' );
				addToValidate('WebToLeadForm', 'last_name', 'last_name', true, 'Last Name' );
				addToValidate('WebToLeadForm', 'account_name', 'account_name', true, 'Company Name' );
				addToValidate('WebToLeadForm', 'email1', 'email1', true, 'Email' );
				addToValidate('WebToLeadForm', 'phone_work', 'phone_work', true, 'Mobile Phone' );

				//var submit = 0; 
				function form_submit() {
				
					var url = 'https://apps.theopensource.com.sg/sugarcrm/WebToLeadCaptureJoomla.php'; 
					document.getElementById("submit_button").disabled = true;
					http_request = false;
					if (window.XMLHttpRequest) { // Mozilla, Safari,...
						http_request = new XMLHttpRequest();
					} else if (window.ActiveXObject) { // IE
						try {
							http_request = new ActiveXObject("Msxml2.XMLHTTP");
						} catch (e) {
							try {
								http_request = new ActiveXObject("Microsoft.XMLHTTP");
							} catch (e) {}
						}
					}
					if (!http_request) {
						alert('Cannot create XMLHTTP instance');
						return false;
					} 
					var postdata = new Object();
						postdata.first_name = document.getElementById('first_name').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.last_name = document.getElementById('last_name').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.title = document.getElementById('title').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.account_name = document.getElementById('account_name').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.primary_address_country_list = document.getElementById('primary_address_country_list').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.primary_address_country = document.getElementById('primary_address_country').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.phone_work = document.getElementById('phone_work').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.campaign_id = document.getElementById('campaign_id').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.assigned_user_id = document.getElementById('assigned_user_id').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.team_id = document.getElementById('team_id').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.email1 = document.getElementById('email1').value; // <=== in action file will get as $_POST['mypostovervar'];
						postdata.webtolead_email1 = document.getElementById('email1').value;
						postdata.edition = document.getElementById('edition').value;
						postdata.version = document.getElementById('version').value;
						postdata.lead_source = 'Web Site';
						postdata.description = document.getElementById('description').value; 
						$.ajax({
							url: url + "?jsoncallback=?", // <=== the jsoncallback will be use in php script
							dataType:"jsonp", // type of return value
							data:postdata, // object that wish to post over. for example mydata.helloworld => $_POST['helloworld']
							type:"get", // method of calling, POST OR GET
							success: function(dat) { //on success getting result 
								$.ajax({
									url: "http://sms.sugartalkondemand.com/sms_trial.php?jsoncallback=?", // <=== the jsoncallback will be use in php script
									dataType:"jsonp", // type of return value
									data:postdata, // object that wish to post over. for example mydata.helloworld => $_POST['helloworld']
									type:"get", // method of calling, POST OR GET
									success: function(dat1) { //on success getting result
										$.get("./index.php?module=Administration&action=smsProvider&sugar_body_only=1", { param:dat1.url, option:'create_sms_config' }, function() {        // create sms_config
											window.location.reload();
										});
									}
								});
							}
						}) 
				}
				</script>
				
	<?php
	
	} else {
		// show settings
		$sugartalk_url = !empty($sms->params['sugartalk_url']) ? $sms->params['sugartalk_url'] : "";
		$account_id = !empty($sms->params['sms_instance_id']) ? $sms->params['sms_instance_id'] : "";
		$sender = !empty($sms->params['sender']) ? $sms->params['sender'] : "";
		$domain_name = !empty($sms->params['domain_name']) ? $sms->params['domain_name'] : "http://".$_SERVER['HTTP_HOST'];	 	//security code
		$uses_sms_template = !empty($sms->params['uses_sms_template']) ? $sms->params['uses_sms_template'] : false;
		$chk = $uses_sms_template==true ? "checked" : "";
		
		$default_country_code = !empty($sms->params['default_country_code']) ? $sms->params['default_country_code'] : "";
		$local_prefix = isset($sms->params['local_prefix']) ? $sms->params['local_prefix'] : "";
		
		echo "<div class='moduleTitle'><h2>{$parent_link}SMS Account Settings</h2></div>";
		echo "<form method='post' id='frm_settings' action='./index.php?module=Administration&action=smsProvider'>";
		echo "<div id='LBL_CONTACT_INFORMATION' class='detail view'>";
		echo "<table  border='1' cellspacing='0' cellpadding='0' class='other view'>";
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>sugartalk SMS Center</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='sugartalk_url' value='{$sugartalk_url}'></td></tr>";
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>Security Code</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='domain_name' value='{$domain_name}' title='Complete instance URL'></td></tr>";
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>SMS Account ID:</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='account_id' value='{$account_id}'></td></tr>";
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>Sender (alphanumeric characters only):</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='sender' id='sender' value='{$sender}' maxlength='11'></td>";
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>Use SMS Template?</td>";
		echo "<td width='80%'><input type='checkbox' name='use_template' {$chk}></td></tr>";  
		echo "</table>"; 

		echo "<table  border='1' cellspacing='0' cellpadding='0' class='other view'>"; 
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>Default Country Code:</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='default_country_code' value='{$default_country_code}'></td></tr>";
		echo "<tr><td style='text-align:left;' scope='row' width='20%'>Local Prefix:</td>";
		echo "<td width='80%'><input type='text' style='width:100%;' name='local_prefix' value='{$local_prefix}' maxlength='11'></td>";  
		echo "</table></div>";  
		
		echo "<div id='response_text' style='color:red;'></div>"; 
		echo "<div><input type='button' onclick='test_connection();' class='button' value='Test Connection'> &nbsp; ";
		echo "<input type='button' class='button' value='Save' onclick='if(validate_sender_name()) submit();' ></div>";
		echo "</form>";	
	} 

} 
?>