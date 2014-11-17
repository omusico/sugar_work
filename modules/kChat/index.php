<?php $room=(isset($_REQUEST['room'])) ? $_REQUEST['room'] : 'main'?>

<script src="cache/include/javascript/sugar_grp_yui_widgets.js"></script>
<script src="modules/kChat/fancywebsocket.js"></script>
<script>
	var Server;
	
	var kchat_addr = '82.146.52.49:31130';
	
	var win_in_focus = true;
	var room_action = null;
	
	$(window).blur(function(){win_in_focus=false;});
	$(window).focus(function(){win_in_focus=true;});
	
	var not_perm;

	function chekNotStatus(){
		timer = setTimeout( function() { not_perm = "default" }, 500 );
		Notification.requestPermission( function(state){ clearTimeout(timer); not_perm = state } );
	}

	function log( text ) {
		$log = $('#log');
		//Add text to log
		$log.append(text+"\n");
		//Autoscroll
		$log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
	}

	function send( text ) {
		Server.send( 'message', text );
	}
	
	function setRoom($room){
		if($room!='<?echo $room?>')
			location.href='index.php?module=kChat&room='+$room;
		else
			alert('Вы и так находитесь в этой комнате');
	}
	function renRoom($room){
		room_name = '';
		while(room_name==''){
			room_name = prompt('Введите название комнаты (240симв)');
			if(room_name=='') alert('Название комнаты не должно быть пустым');else {
				send(JSON.stringify({type:'renRoom', id:'<?echo $GLOBALS['current_user']->id?>', room:$room, name:room_name}));
			}
		}
		
	}
	function delRoom($room){
		send(JSON.stringify({type:'delRoom', id:'<?echo $GLOBALS['current_user']->id?>', room:$room}));
		if($room=='<?echo $room?>')
			setRoom('main');
	}
	
	function addToRoom($id){
		$id = $id.replace('chat-cont-','');
		if($id!='<?echo $GLOBALS['current_user']->id?>'){
			if(confirm('Вы уверены что хотите позвать этого пользователя в комнату?')){
				
				if('<?echo $room?>'!='main'){
					send(JSON.stringify({type:'add2Room', id:$id, room:'<?echo $room?>'}));
				}
				else{
					room_name = '';
					while(room_name==''){
						room_name = prompt('Введите название комнаты (240симв)');
						if(room_name=='') alert('Название комнаты не должно быть пустым');else {
							send(JSON.stringify({type:'createRoom', id:$id, room:room_name}));
						}
					}
				}
			}
		}
		else
			alert('Вы не можете создать чат сами с собой');
	}
	
	function selectRoomAction($room_action){
		room_action=$room_action.replace('chat-room-','');
		if(room_action!='main'){
			$('#room_action').val('');
			$('#room_action').parent().show();
		}
		else{
			setRoom(room_action);
		}
	}
	
	function runRoomAction(action){
		if(action=='') return false;
		else {switch(action){
			case 'setRoom':
				setRoom(room_action);
			break;
			case 'renRoom':
				renRoom(room_action);
			break;
			case 'delRoom':
				delRoom(room_action);
			break;
		}$('#room_action').parent().hide();}
	}

	$(document).ready(function() {
		chekNotStatus();
		
		$('#room_action').live('change', function(){runRoomAction($(this).val())});
		$('#rooms_body div').live('click', function(){selectRoomAction($(this).attr('id'))});
		$('#cont_online div').live('click', function(){addToRoom($(this).attr('id'))});
		$('#cont_offline div').live('click', function(){addToRoom($(this).attr('id'))});
	
		log('Connecting...');
		Server = new FancyWebSocket('ws://'+kchat_addr);

		$('#message').keypress(function(e) {
			if ( e.keyCode == 13 && this.value ) {
				send( this.value );
				$(this).val('');
			}
		});

		//Let the user know we're connected
		Server.bind('open', function() {
			send(JSON.stringify({type:'auth', id:'<?echo $GLOBALS['current_user']->id?>', room:'<?echo $room?>'}));
			log( "Connected." );
		});

		//OH NOES! Disconnection occurred.
		Server.bind('close', function( data ) {
		$('#chat-cont-<?echo $GLOBALS['current_user']->id?>').appendTo($('#cont_offline'));
			log( "Disconnected." );
			log( "Disconnected. Retry after 5s" );
			setTimeout('Server.connect()', 5000);
		});

		//Log any messages sent from server
		Server.bind('message', function( payload ) {
			console.log(payload);
			mes = JSON.parse(payload);
			if(mes.type=='mes'){
				log('<b>['+mes.data[0]+']</b>:<span style="color:#'+mes.data[2]+'">'+mes.data[1]+'</span>');
				if(!win_in_focus && '<?echo $room?>'!='main'){
					if(not_perm=='granted'){
						var mailNotification = new Notification("kChat", {
							tag : "ache-mail",//+Math.random(),
							body : mes.data[0]+': '+mes.data[1],
							icon : "http://realty-beta.crmprof-service.com/themes/SugarTalk_theme/images/sugar_icon.ico"
						});
					}
					else{
						alert('Вы не подтвердили возмоожность присылать уведомления');
						chekNotStatus();
					}
				}
			}
			else if(mes.type == 'contacts'){
				$('#cont_online').html('');
				$('#cont_offline').html('');
				for(key in mes.data.online){
					$('#cont_online').append('<div id="chat-cont-'+key+'">'+mes.data.online[key]+'</div>');
				}
				for(key in mes.data.offline){
					$('#cont_offline').append('<div id="chat-cont-'+key+'">'+mes.data.offline[key]+'</div>');
				}
				if('<?echo $room?>'!='main'){
					for(key in mes.data.at_room){
						$('#chat-cont-'+key).css('font-weight','bold');
					}
				}
				for(key in mes.data.at_room_now){
					$('#chat-cont-'+key).css('text-decoration','underline');
				}
			}
			else if(mes.type == 'rooms'){
				$('#rooms_body').html('');
				for(key in mes.data){
					room_name = mes.data[key];
					if(key=='<?echo $room?>') room_name = '<span style="font-weight:bold">'+room_name+'</span>';
					$('#rooms_body').append('<div id="chat-room-'+key+'">'+room_name+'</div>');
				}
			}
			else if(mes.type == 'contact_update'){
				$('#chat-cont-'+mes.data.id).appendTo($('#cont_'+mes.data.type));
				if(mes.data.room == '<?echo $room?>' && mes.data.type=='online')
					$('#chat-cont-'+mes.data.id).css('text-decoration','underline');
				else
					$('#chat-cont-'+mes.data.id).css('text-decoration','none');
			}
			else if(mes.type == 'set_room'){
				setRoom(mes.data);
			}
		});

		Server.connect();
	});
</script>
<style>
	input, textarea {border:1px solid #CCC;margin:0px;padding:0px}

	.chat-dialog{
		display:none;
		text-align:center;
		position:fixed;/*absolute*/
		top:30%;left:40%;
		width:20%;/*height:50%;*/
		background-color:#fbfbff;
		padding:10px;
		border:2px solid #8ad;
		
		-moz-box-shadow: 5px 5px 5px rgba(0,0,0,0.5); /* Для Firefox */
		-webkit-box-shadow: 5px 5px 5px rgba(0,0,0,0.5); /* Для Safari и Chrome */
		box-shadow: 5px 5px 5px rgba(0,0,0,0.5); /* Параметры тени */
		filter: progid:DXImageTransform.Microsoft.shadow(direction=120, color=#000000, strength=5);/*IE*/
	}
	
	#chat_cont {
		min-width:900px;
		width:90%;
		margin:auto;
		border:1px solid #666;
		height:330px;
	}
	#panel_body {
		background-color:#f4f4f4;
		min-width:180px;
		width:20%;
		height:100%;
		margin:auto;
		float:left;
		padding:2px;
		
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}
	#panel_body b{
		display:block;
		text-align:center;
	}
	#contacts_body {
		background-color:#f8f8f8;
		overflow-y:auto;
		height:60%;
		border:1px solid #bbb;
		padding:2px;
		
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}
	#rooms_body {
		background-color:#f8f8f8;
		overflow-y:auto;
		height:31%;
		border:1px solid #bbb;
		padding:2px;
		
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}
	#cont_online {
		color:#080;
	}
	#cont_offline {
		color:#800;
	}
	
	#chat_body {
		min-width:200px;
		width:80%;
		margin:auto;
		float:right;
	}
	#log {
		overflow-y:auto;
		width:100%;
		height:300px;
		border:1px solid #bbb;
		background-color:#fff;
		padding:3px;
		margin:0;
		
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
		
		white-space: pre-wrap;       /* css-3 */
		white-space: -moz-pre-wrap;  /* Mozilla, с 1999 */
		white-space: -pre-wrap;      /* Opera 4-6 */
		white-space: -o-pre-wrap;    /* Opera 7 */
		word-wrap: break-word;
	}
	#message {
		width:100%;
		line-height:20px;
		
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}
	
	#rooms_body div, #cont_online div, #cont_offline div{
		cursor:pointer;
	}
</style>
<div class='chat-dialog'>
	<select id='room_action'>
		<option value=''> - Выберите действие - </option>
		<option value='setRoom'>Перейти в комнату</option>
		<option value='renRoom'>Переименовать комнату</option>
		<option value='delRoom'>Удалить себя из комнаты</option>
		<option value='cancel'>Отмена</option>
	</select>
</div>
<div id='chat_cont'>
	<div id='panel_body'>
		<b>Пользователи:</b>
		<div id='contacts_body'>
			<div id="cont_online"></div>
			<div id="cont_offline">нет данных</div>
		</div>
		<b>Доступные чаты:</b>
		<div id='rooms_body'>
			<div id="rooms">
				<div>нет данных</div>
			</div>
		</div>
	</div>
	<div id='chat_body'>
		<pre id='log' name='log'></pre>
		<input type='text' id='message' name='message' />
	</div>
	<div style="clear:both"></div>
</div>

<img border="0" class="inlineHelpTip button" alt="Краткое руководство по использованию" src="themes/default/images/help-dashlet.gif" onclick="return YAHOO.SUGAR.MessageBox.show({msg:
'В боковой панели отображены пользователи и комнаты чата.<br/>'+
'Пользователи имеют цветовую индикацию:<br/>'+
'<b>Зеленый</b> - пользователь онлайн, <b>Красный</b> - пользователь оффлайн.<br/>'+
'Также пользователи выделяются <b>подчеркнутым</b> текстом если пользователь в данный момент находится в тойже комнате что и Вы;<br/>'+
'<b>жирным</b> текстом - если у пользователя в списке комнат присутствует комната, в которой Вы в данный момент находитесь.<br/>'+
'Для создания новой комнаты(<b>только в главном чате</b>) выберите пользователя и введите базовое название для комнаты, Вы будете автоматически перемещены в комнату, а пользователю будет отправлено приглашение.<br/>'+
'Для приглашения в комнату другого пользователя и отправки повторного приглашения выберите пользователя.<br/>'+
'Если нажать на комнату Вам будет предоставлен ряд действий:<br/>'+
'<b>Перейти в комнату</b>;<br/>'+
'<b>Переименовать комнату</b> - только для себя, другие будут видеть старое название;<br/>'+
'<b>Удалить себя из комнаты</b> - чтобы она больше не отображалась в списке Ваших комнат(Вас могут пригласить повторно);<br/>'+
'<b>Отмена</b> - закрыть диалоговое окно.'
, title:'Краткое руководство'} );">