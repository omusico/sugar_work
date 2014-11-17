<?php
require_once ("./custom/sms/sms_interface.php"); 
include_once("./modules/sugartalk_SMS/sugartalk_SMS.php");

class sms implements sms_interface {
 
	var $sms_center = "http://www.atompark.com";
	var $ismsc_auth = "/auth.php";  
	var $ismsc_send_multi = "/sendToMulti.php";
	var $config_file = "./custom/sms/sms_config.php";
	var $sms_controller = "";
	var $sms_controller_file = "/sms_controller.php";
 
	var $params = array();
	var $parent_type;
	var $parent_id;
	var $type;
	var $focus;
	var $response_text;
	
	function authenticate($account_id) {
//Заготовка
            $q=1;
	} 

        function balance() {
	$params2 ['version'] ="3.0";
        $params2 ['action'] = "getUserBalance";
        $params2 ['key'] = $this->params['sms_instance_id']; //you open key
        $params2 ['currency'] = 'RUB';

        ksort ($params2);
        $sum='';
        foreach ($params2 as $k=>$v)
        $sum.=$v;
        $sum .= $this->params['domain_name']; //your private key
        $control_sum =  md5($sum);

                    $ch = curl_init('http://atompark.com/api/sms/3.0/getUserBalance');
		$param = "key=" . urlencode($this->params['sms_instance_id']);
		$param .= "&sum=" . urlencode($control_sum);
                $param .= "&currency=RUB";

		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		$ret = json_decode($response, true);
                if (!isset($ret['error']))
                    {
                        $balance_currency = $ret['result']['balance_currency'];
                        $currency = $ret['result']['currency'];
                        $return = 'На вашем счету '.$balance_currency.''.$currency;

                    }
                else
                    {
                        $return = $ret['error'];
                    }
return $return;
//$r=3;
	}

	private function send($to, $text) {
		
		$pname = strlen($this->pname) ? $this->pname : "-no name-";
		$number[$to] = array($pname, $to);
		
		$summary = $this->send_to_multi($to, $text);
                if (isset ($this->parent_id))
                        {
		$response['STATUS'] = $summary[$this->parent_id][0];
		$response['API_MSG'] = $summary[$this->parent_id][0];
		return $response;
                        }
                        else
                            {
                            $response['STATUS'] = $summary[0];
		$response['API_MSG'] = $summary[0];
		return $response;
                        }
	}
	
	function send_message($to,$text) {
	
		global $current_user;
		
		$to = preg_replace('/[^0-9]/', '', $to); 
		$response = $this->send($to, $text); 

		$sugartalk_SMS = new sugartalk_SMS();
		$sugartalk_SMS->provider = 'mirsms';
		$sugartalk_SMS->description = $text;
		$sugartalk_SMS->api_message = $response['API_MSG'];
		$sugartalk_SMS->delivery_status = $response['STATUS'];
		$sugartalk_SMS->parent_type = $this->parent_type;
		$sugartalk_SMS->parent_id = $this->parent_id;
		$sugartalk_SMS->name = strlen($this->pname) ? $this->pname : "-no name-";
		$sugartalk_SMS->name .= " (" . date("Y-m-d") . ")";
		$sugartalk_SMS->phone_number = strlen($to) ? $to." " : "-none-";
		$sugartalk_SMS->assigned_user_id = $current_user->id;
		$sugartalk_SMS->save();
		
		$this->response_text = $response['API_MSG'];
		return $this->response_text;
	}
	
	function resend($sms_id, $to, $text) { 
		global $current_user;
		$sugartalk_SMS = new sugartalk_SMS();
		$sugartalk_SMS->retrieve($sms_id);
		if (isset($sugartalk_SMS->id) and !empty($sugartalk_SMS->id)) {
			$to = preg_replace('/[^0-9]/', '', $to);
			$response = $this->send($to, $text); 
			$sugartalk_SMS->phone_number = strlen($to) ? $to." " : "-none-";
			$sugartalk_SMS->description = $text;
			$sugartalk_SMS->api_message = $response['API_MSG'];
			$sugartalk_SMS->delivery_status = $response['STATUS'];
			$sugartalk_SMS->type = "outbound";
			$sugartalk_SMS->save();
		} else {
			$this->response_text = "Javascript fault: Unable to send message.";
		} 
		$this->response_text = $response['API_MSG'];
		return $this->response_text;
	}
	 
	private function send_to_multi($to_array, $text) {

        if (is_array($to_array))
        {
            $number = array();

            foreach($to_array as $key=>$value) {
                $tel = $value[1];
//////////////////////////////////////////////////////////////////email2SMS
               /* $emailObj = new Email();
                $defaults = $emailObj->getSystemDefaultEmail();
                $mail = new SugarPHPMailer();
                $mail->setMailerForSystem();
                //$mail->IsHTML(true);
                $mail->From = $defaults['email'];
                $mail->FromName = $defaults['name'];
                $mail->ClearAllRecipients();
                $mail->ClearReplyTos();

                $mail->Subject=$this->params['sms_instance_id'].' '.$tel;
                $mail->Body='[SENDER]'.$this->params['sender'].'[/SENDER][SMS]'.$text.'[/SMS]';

                $mail->prepForOutbound();


                $mail->AddAddress('sms@massreach.com');


                if (@$mail->Send())
                    {
                    $number[$key] = array("SENT",$tel, $text);
                    }
                else
                    {
                    $number[$key] = array("NOT SENT",$tel, $text);
                    }*/
///////////////////////////////////////////////////////////////////////////////////////////////
                    //API3.0//http://atompark.com/api/sms/3.0/sendSMS?key=public_key&sum=control_sum&sender=Info&text=Testing%20SMS&phone=380972920383&datetime=&sms_lifetime=0
                $params2 ['version'] ="3.0";
                $params2 ['action'] = "sendSMS";
                $params2 ['key'] = $this->params['sms_instance_id']; //you open key
                $params2 ['sender'] = $this->params['sender'];
                $params2 ['text'] = $text;
                $params2 ['phone'] = $tel;
                $params2 ['datetime'] = '';
                $params2 ['sms_lifetime'] = '0';

                ksort ($params2);
                $sum='';
                foreach ($params2 as $k=>$v)
                $sum.=$v;
                $sum .= $this->params['domain_name']; //your private key
                $control_sum =  md5($sum);
                
                    $ch = curl_init('http://atompark.com/api/sms/3.0/sendSMS');
		$param = "key=" . urlencode($this->params['sms_instance_id']);
		$param .= "&sum=" . urlencode($control_sum);
		$param .= "&sender=" . urlencode($this->params['sender']);
		$param .= "&text=" . str_replace("%26%23039%3B", "%27", rawurlencode(htmlspecialchars_decode($text)));
		$param .= "&phone=" . $tel;
                $param .= "&datetime=";
                $param .= "&sms_lifetime=" . '0';

		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		$ret = json_decode($response, true);

                if (!isset($ret['result']['error']))
                    {
                    foreach ($to_array as $key=>$value)
                        $number[$key] = array("SENT",$tel, $text);

                    }
                else
                    {
                    foreach ($to_array as $key->$value)
                        $number[$key] = array("NOT SENT",$tel, $text);
                    }
                /////////////////////////////////////////////////////////////////////
            }
            return $number;
        }
        else
        {
            $number = array();
            $tel = $to_array;



            
//            $emailObj = new Email();
//                $defaults = $emailObj->getSystemDefaultEmail();
//                $mail = new SugarPHPMailer();
//                $mail->setMailerForSystem();
//                //$mail->IsHTML(true);
//                $mail->From = $defaults['email'];
//                $mail->FromName = $defaults['name'];
//                $mail->ClearAllRecipients();
//                $mail->ClearReplyTos();
//
//                $mail->Subject=$this->params['sms_instance_id'].' '.$tel;
//                $mail->Body='[SENDER]'.$this->params['sender'].'[/SENDER][SMS]'.$text.'[/SMS]';
//
//                $mail->prepForOutbound();
//
//
//                $mail->AddAddress('ivan.stroilov@sugartalk.ru');
//                //$mail->AddAddress('sms@massreach.com');
//
//                if (@$mail->Send())
//                    {
//                    $number[$this->parent_id] = array("SENT",$tel, $text);
//                    }
//                else
//                    {
//                    $number[$this->parent_id] = array("NOT SENT",$tel, $text);
//                    }


            $params2 ['version'] ="3.0";
                $params2 ['action'] = "sendSMS";
                $params2 ['key'] = $this->params['sms_instance_id']; //you open key
                $params2 ['sender'] = $this->params['sender'];
                $params2 ['text'] = $text;
                $params2 ['phone'] = $tel;
                $params2 ['datetime'] = '';
                $params2 ['sms_lifetime'] = '0';

                ksort ($params2);
                $sum='';
                foreach ($params2 as $k=>$v)
                $sum.=$v;
                $sum .= $this->params['domain_name']; //your private key
                $control_sum =  md5($sum);

                    $ch = curl_init('http://atompark.com/api/sms/3.0/sendSMS');
		$param = "key=" . urlencode($this->params['sms_instance_id']);
		$param .= "&sum=" . urlencode($control_sum);
		$param .= "&sender=" . urlencode($this->params['sender']);
		$param .= "&text=" . str_replace("%26%23039%3B", "%27", rawurlencode(htmlspecialchars_decode($text)));
		$param .= "&phone=" . $tel;
                $param .= "&datetime=";
                $param .= "&sms_lifetime=" . '0';

		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		$ret = json_decode($response, true);

                if (!isset($ret['result']['error']))
                    {
                    if (isset($this->parent_id))
                        {
                        
                        $number[$this->parent_id] = array("SENT",$tel, $text);
                        }
                        else
                            {
                            $singleret = array("SENT",$tel, $text);
                            return $singleret;
                            //break;
                        }

                    }
                else
                    {
                    //foreach ($to_array as $key->$value)
                        if (isset($this->parent_id))
                        {

                        $number[$this->parent_id] = array("NOT SENT",$tel, $text);
                        }
                        else
                            {
                            $singleret = array("NOT SENT",$tel, $text);
                            return $singleret;
                            //break;
                        }
                    }
            return $number;
        }
	}
	
	# need to create batch sending on sugartalk
	function send_batch_message($to_array,$text) {
		global $current_user;
		
		$summary = $this->send_to_multi($to_array, $text); 
		
		if(empty($summary)) {
			return 'ERROR';
		} 
		# Сохраняем все (отправленные и не отправленные) смс
		if (sizeof($summary)) {
			foreach($summary as $pid => $val) { 
				$sugartalk_SMS = new sugartalk_SMS();
				$sugartalk_SMS->provider = 'sugartalk';
				$sugartalk_SMS->parent_type = $this->parent_type;
				$sugartalk_SMS->description = $text;
				$sugartalk_SMS->api_message = $val[0];
				$sugartalk_SMS->parent_id = $pid;
				$sugartalk_SMS->name = strlen($val[1]) ? $val[1] : "-no name-";
				$sugartalk_SMS->name .= " (" . date("Y-m-d") . ")";
				$sugartalk_SMS->phone_number = strlen($val[1]) ? $val[1]." " : "-none-";
				$sugartalk_SMS->assigned_user_id = $current_user->id;
				$sugartalk_SMS->delivery_status = $val[0];
				$sugartalk_SMS->save();
			}
		}  
		return $summary;
		 
	}
	
	function replace_local_prefix($to) {
		//Заготовка
		# replaces the local prefix with the default country code
		if (!empty($this->params['default_country_code']) and strlen($this->params['default_country_code']) and isset($this->params['local_prefix']) and strlen($this->params['local_prefix'])) {
			$to = preg_replace("/^".$this->params['local_prefix']."/", $this->params['default_country_code'], $to);
		}
		return $to;
	
	}
	
	function retrieve_settings() {
		$this->params = array();
		if (file_exists($this->config_file)) {
			include($this->config_file);
			if (isset($sms_config)) {
				$this->params = $sms_config;
			}
		} 
	}

	function save_settings() {
		$handle = fopen($this->config_file, "w+");
		$content = "<?php\n";
		foreach($this->params as $key => $val) {
			if ($key == 'sugartalk_url')
				$val = rtrim($val, "/");	// make sure there's no trailing forward slash
			$content .= "\$sms_config[\"{$key}\"] = \"{$val}\";\n";
		}
		$content .= "?>";
		fputs($handle, $content);
		fclose($handle);

	}

	
	function uses_template() {
		$this->retrieve_settings();
		if(isset($this->params['uses_sms_template']))
			return $this->params['uses_sms_template'];
		else
			return false;	// by default, SMS do not use templates
	}
	
	function get_supported_countries() {
//Заготовка
            $q=2;
	}
	
	function get_credit_usages() {
//Заготовка
            $q=3;
	}
 

}
?>
