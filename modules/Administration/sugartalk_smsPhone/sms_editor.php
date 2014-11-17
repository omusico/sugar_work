<script type="text/javascript" language="JavaScript" src="modules/Administration/sugartalk_smsPhone/javascript/jquery.jmpopups-0.5.1.js"></script>
<script type="text/javascript" language="JavaScript" src="modules/Administration/sugartalk_smsPhone/javascript/smsPhone.js"></script>


<style type="text/css">
	div#editor_style {
		border:#CCCCCC solid 2px;
		padding:10px;
		background-color:#FFFFFF; 
	}
	span#sms_len_notifier{
		color:red; 
	}
	textarea#sms_msg{
		width:100%;
		font-size:12px;
	}
	div#smstip { 
		border:red solid 2px;
		background-color:#FFC;
		padding:10px;
		font-size:11px;
		position:absolute;
		z-index:10; 
		float:right;
		display:none;
		width:250px;
	}
	div#sms_response {
		margin-top:10px;
		margin-bottom:5px;
		color:#000;
		font-weight:bold;
	}
	 
</style>
 
<?php   

    //require_once("modules/Administration/sugartalk_smsPhone/javascript/smsPhone.js");
	echo "<div id='editor_boundary'><br><div id='editor_style'>";

	
	# hidden fields
	echo "<input type='hidden' id='send_to_multi' value='{$send_to_multi}'>";
	echo "<input type='hidden' id='ptype' value='{$ptype}'>";
	echo "<input type='hidden' id='pid' value='{$pid}'>"; 
	echo "<input type='hidden' name='pname' id='pname' value='".$pname."'>";	
	
	# MULTIPLE RECIPIENT
	if ($send_to_multi) { 
	
		if (empty($sms_field) || $sms_field==NULL) {

			echo "<div id='editor_boundary'><br><div id='editor_style'>";
			echo "Вы не указали поле SMS телефон для данного модуля.<br>";
			echo "Нажмите <a href='http://localhost/sp/index.php?module=Administration&action=smsPhone'>сюда</a> для настройки.";
			echo "</div></div>";
		
		} else {
		
			require_once($mod_bean_files);
			$mod = new $mod_key_sing;
			$recipients = array();
			
			echo "Получатели&nbsp;<span class='required'>*</span><br>";
			
			# need to improve this area in the future to get the delete image
			if (file_exists('themes/Sugar/images/delete_inline.gif'))
				$src = 'themes/Sugar/images/delete_inline.gif';
			elseif(file_exists('themes/Sugar/images/delete_inline.png'))
				$src = 'themes/Sugar/images/delete_inline.png';
			else 
				$src = '';

			$img = "<img src='{$src}' alt='[x]' align='absmiddle' border='0' width='12' height='12'>"; 
			foreach($pids as $id) {
				if($mod->retrieve($id)) {
					echo "<div class='recipient'>";
					echo $mod->name;
					echo "<span class='link' title='Нажмите, чтобы удалить {$mod->name} (".preg_replace('/[^0-9]/', '', $mod->$sms_field).")'
							onmouseover=\"$(this).parent().css('background-color','#CCC');\" 
							onmouseout=\"$(this).parent().css('background-color','#FF9');\"
							onclick=\"$(this).parent().remove(); if($('input#pids').length==0) { $('div#editor_style').html('Вы удалили всех получателей. <br>Нажмите F5, чтобы закрыть это сообщение.').css('padding', '30px').css('font-weight','bold'); };\">{$img}</span>";
					echo "<input type='hidden' name='pids' id ='pids' value='{$id}'>";
					echo "</div>";
				}
			}  
			echo "<input type='text' name='number' id='number' disabled='disabled' value='MULTI' style='display:none;'>";
			echo "<div style='clear:both;'></div>";
		
		}  
		
	# SINGLE RECIPIENT
	} else {

		echo "Номер телефона&nbsp;<span class='required'>*</span><br>";
		echo "<input type='text' name='number' id='number' value='" . trim($phone_number) ."'>";
		echo "&nbsp;<span onmouseover='show_tip();' onmouseout='hide_tip();' style='color:#FF0000;font-weight:bold;cursor:pointer;'>[?]</span>";
		echo "&nbsp;<span style='font-family:Verdana;font-size:10px;'>&lt;Код страны&gt;&lt;Номер&gt;</span><br>";
		echo "<div id='smstip'></div>";
 
	} 
	
	# enhancement: uses of tpls 15Jul2010 
	if ($sms->uses_template() == true) {
		echo "<div style='height:10px;'></div>";
		echo "<span title='Optional'>Template</span><br>";
		$email_templates_arr = get_bean_select_array(true, 'EmailTemplate','name','sms_only=1','name');
		echo "<select id='template_id' onchange='load_message(this.value);'>".get_select_options_with_id($email_templates_arr, "")."</select>";
	}
	# # # #
	
	echo "<div style='height:10px;'></div>";
	echo "Сообщение <span class='required'>*</span><br>";
	echo "<textarea name='sms_msg' id='sms_msg' rows='6' >{$msg}</textarea><br>";
	echo "<span id='sms_len_notifier'>Ограничьте свое сообщение 70-ью символами для кирилицы, или 160-ью для латиницы.</span><br><br>";




	echo "<div style='clear:both;'></div>"; 
	echo "<div style='float:left;'></div>";
	echo "<input type='button' class='button' id='send' value='Отправить' onclick='{$onclick}' style='float:right;'>&nbsp;";
        echo '<input type="button" class="button" id="close" value="Закрыть" onclick="closePopUp();" style="float:right;">&nbsp;';
	echo "<div style='clear:both;'></div>";
		
	echo "<div id='sms_response'></div></div></div>";
//echo "<script type='text/javascript'>function closePopUp(name){jQuery.noConflict();jQuery.closePopupLayer(name);}</script>";
		  
?>
<!--<script type='text/javascript'>check_sms_len(document.getElementById('sms_msg').length)</script>-->
