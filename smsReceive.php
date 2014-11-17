<?php 

	# CLIENT 
	if (isset($_REQUEST['id']) and isset($_REQUEST['msisdn'])) {
 	
		if(!defined('sugarEntry'))define('sugarEntry', true);
		require_once('include/entryPoint.php');  
		
		global $sugar_config, $current_language, $app_list_strings, $app_strings, $locale;
		$language = $sugar_config['default_language'];  
		$app_list_strings = return_app_list_strings_language($language);
		$app_strings = return_application_language($language);
 
		$id = $_REQUEST['id'];
		$msisdn = $_REQUEST['msisdn'];
		$msg = $_REQUEST['message'];
		
		# # # # # # # # # LOG TO FILE # # # # # # # # #
		$stamp = date("Y-m-d H:i:s");  
		$fp = fopen("sms.log","a+");

		foreach($_REQUEST as $k => $v){  
			fputs($fp, "[".$stamp."]".$k. " => ".$v."\n");
		}
		fclose($fp);
		echo "received";   
		
		# # # # # # # # # END LOG TO FILE # # # # # # # # #
		
		
		# # # # # # # # # LOG TO DB # # # # # # # # #
		global $current_user;
		$current_user->retrieve(1);

		require_once("custom/sms/sms.php");
		$sms = new sms();
		$sms->retrieve_settings(); 

		require_once("modules/sugartalk_SMS/sugartalk_SMS.php");
		$sugartalk_SMS = new sugartalk_SMS();
		
 		require_once("modules/Administration/sugartalk_smsPhone/sms_enzyme.php");
		$e = new sms_enzyme();
		$result = $e->parse_sms_macro($msg);
 
		if ($result['code'] != '') {
		
			# recreate $e and retrieve the module's id 
			$e = new sms_enzyme($result['module']); 
			include_once($e->mod_bean_files);
			$object = new $e->module_sing();
			$where_array = array($result['field'] => $result['code']); 
			$object->retrieve_by_string_fields($where_array); 
			
			$parent_id = $object->id;
			$parent_type = $result['module'];
			$assigned_user_id = $object->assigned_user_id;
			
			# 2010-Oct-7: exclusive for case 
			if ($result['module'] == 'Cases') { 
				$case_status = $GLOBALS["app_list_strings"]["case_status_dom"]; 
				foreach($case_status as $k => $v) { 
					if(strtolower($k) == strtolower($result['message'])) {
						# update case status
						$object->status = $k;
						$object->save(); 
						break;
					}
				}
			}
			
		} else {
			$parent_type = "";
			$parent_id = "";
			$assigned_user_id = "";
		}

 		$sugartalk_SMS->name = $id . date(" (Y-m-d)", strtotime($stamp));
		$sugartalk_SMS->date_entered = $stamp;
		$sugartalk_SMS->description = $result['message'];		//strips off the "sugartalk" keyword
		$sugartalk_SMS->type = "inbound";
		$sugartalk_SMS->phone_number = $msisdn;
		$sugartalk_SMS->provider = "sugartalk";
		$sugartalk_SMS->api_message = "Response received.";
		$sugartalk_SMS->delivery_status = "RECEIVED";
		$sugartalk_SMS->assigned_user_id = $assigned_user_id;
		$sugartalk_SMS->parent_type = $parent_type;
		$sugartalk_SMS->parent_id = $parent_id;
		$sugartalk_SMS->save();
	 
		# # # # # # # # # END LOG TO DB # # # # # # # # #  
	}
	
?>