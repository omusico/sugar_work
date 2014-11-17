<?php

interface sms_interface {
	public function authenticate($account_id); 
	public function send_message($to,$text);
	public function send_batch_message($to_array,$text);
}
?>