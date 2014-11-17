<?php
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';

// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary) {
	global $Server;
	$client = $Server->wsClients[$clientID];
	$ip = long2ip( $client[6] );

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}
	if($data = isJSON($message)){
		if($data->type=='auth'){
			$data->id;
			$user = getUserInfo($data->id);
			
			if(!$user){
				$Server->wsRemoveClient($clientID);
				$Server->log( "!{$clientID}[{$ip}] not in system." );
			}
			else{
				$Server->wsClients[$clientID][15] = $data->room;
				
				$Server->wsClients[$clientID][12] = $data->id;
				$Server->wsClients[$clientID][13] = $user['last_name'].' '.$user['first_name'];
				$client = $Server->wsClients[$clientID];
				
				foreach (array_keys($Server->wsClients) as $id)
					if ( $id != $clientID ){
						contactUpdate($id, $clientID, 'online');
						sendMess($id, array('System', "{$client[13]} подключен к чату", '000'), $data->room);
					}
					else{
						sendMess($id, array('System', "Здравствуйте, {$client[13]}", '000'));
						$color = getHystory($id, $data->room);
						getUsers($id, $data->room);
						getRooms($id);
					}
				if($color){
					$Server->wsClients[$clientID][14] = $color;
				}
				else{
					if(++$Server->c_id>=6)$Server->c_id=0;
					$Server->wsClients[$clientID][14] = $Server->colors[$Server->c_id];
				}
				
				$Server->log( "{$clientID}[{$ip}] login as {$client[13]} ({$client[12]})." );
				// $Server->log($Server->wsClients[$clientID]);
			}
		}
		else if($data->type=='createRoom'){
			createRoom($clientID, $data->id, $data->room);
		}
		else if($data->type=='add2Room'){
			add2Room($clientID, $data->id, $data->room);
		}
		else if($data->type=='delRoom'){
			updateRoom($data->room, false, $data->id, true);
			getRooms($clientID);
			foreach (array_keys($Server->wsClients) as $id)
				if ( $id != $clientID ){
					getUsers($id, $Server->wsClients[$id][15]);
				}
		}
		else if($data->type=='renRoom'){
			updateRoom($data->room, $data->name, $data->id);
			getRooms($clientID);
		}
	}
	else{
		$Server->log("{$clientID}[{$ip}] say:{$message}");
		if(!isset($client[12]) || $client[12]==''){
			sendMess($clientID, array('System', "НЕАВТОРИЗОВАННАЯ ПОПЫТКА ДОСТУПА!", 'f00'));
			$Server->log( "{$clientID}[{$ip}] unauthorized access." );
			$Server->wsClose($clientID);
		}
		else{
			//The speaker is the only person in the room. Don't let them feel lonely.
			/*if ( sizeof($Server->wsClients) == 1 )
				sendMess($clientID, array('System', "Чат пуст, дождитесь хотябы одного собеседника", '000'));
			else{*/
				$color = $client[14];
				
				$message = str_replace('<', '&lt;', $message);
				$message = str_replace('>', '&gt;', $message);
				$message = str_replace('\'', '&#039;', $message);
				
				$send_mes = set_smiles($message);
				
				//Send the message to everyone but the person who said it
				foreach (array_keys($Server->wsClients) as $id){
					$time = date('H:i:s');
					if ( $id != $clientID )
						$mes = array($client[13].'|'.$time, $send_mes, $color);
						
					else{
						$mes = array('You|'.$time, $send_mes, $color);
						addHistory($client[12], $message, $color, $client[15]);
					}
					sendMess($id, $mes, $client[15]);
				}
			//}
		}
	}
}

// when a client closes or lost connection
function wsOnClose($clientID, $status)
{
	global $Server;
	$client = $Server->wsClients[$clientID];
	$ip = long2ip( $client[6] );
	$Server->log( "{$clientID}[{$ip}] has disconnected." );

	//Send a user left notice to everyone in the room
	foreach(array_keys($Server->wsClients) as $id)
		if(isset($client[12]) && $client[12]!=''){
			contactUpdate($id, $clientID, 'offline');
			sendMess($id, array('System', "{$client[13]} вышел из чата.", '000'), $client[15]);
		}
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server;
	$client = $Server->wsClients[$clientID];
	$ip = long2ip( $client[6] );

	$Server->log( "{$clientID}[{$ip}] has connected." );
	// $Server->log( $Server->wsClients[$clientID] );
}
function getHystory($id, $room='main'){
	global $Server;
	$color = false;
	dbConnect();
	$q = "SELECT users.id, users.last_name, users.first_name, h.description, TIME(h.date_entered) as time
		FROM kchat_hystory AS h
		LEFT JOIN users ON users.id = h.assigned_user_id
		WHERE DATE(h.date_entered) = CURRENT_DATE()
			AND h.name = '{$room}'
			AND h.deleted = 0
		ORDER BY h.date_entered ASC
		/*LIMIT 40*/
		";
	$r = query($q);
	while($row = fetchAssoc($r)){
		$text = explode('_',$row['description']);
		if($row['id']==$Server->wsClients[$id][12]){
			$user_name = 'You';
			if($text[1]!='000')
				$color = $text[1];
		}
		else{
			$user_name = $row['last_name'].' '.$row['first_name'];
		}
		$mes = array(
			$user_name.'|'.$row['time'],
			$text[0],
			$text[1],
		);
		$mes = set_smiles($mes);
		sendMess($id, $mes);
	}
	return $color;
}
function getRooms($id){
	global $Server;
	dbConnect();
	$user_id = $Server->wsClients[$id][12];
	$q = "SELECT DISTINCT name FROM kchat_hystory WHERE assigned_user_id = '{$user_id}' AND deleted = 0";
	$r = query($q);
	$rooms = array('main'=>'Главный чат');
	while($row = fetchAssoc($r)){
		if($row['name']!='main' && $room_name=getRoomName($row['name'], $user_id))
			$rooms[$row['name']]=$room_name;
	}
	$mes = array(
		'data' => $rooms,
		'type' => 'rooms',
	);
	$Server->wsSend($id, $mes);
}

function getUsers($id, $room='main'){
	global $Server;
	$on = $off = $at_room = $at_room_now = array();
	$on_ids='';
	foreach($Server->wsClients as $client){
		// if($client[15]==$room){
			$on[$client[12]]=$client[13];
			$on_ids.= $client[12]."','";
		// }
	}
	dbConnect();
	$on_ids = trim($on_ids, "','");
	$q = "SELECT id, last_name, first_name FROM users WHERE id NOT IN ('{$on_ids}') AND deleted = 0";
	$r = query($q);
	while($row = fetchAssoc($r)){
		$off[$row['id']]=$row['last_name'].' '.$row['first_name'];
	}
	$q = "SELECT users.id, users.last_name, users.first_name
		FROM kchat_hystory as h
		LEFT JOIN users ON users.id = h.assigned_user_id WHERE h.name = '{$room}' AND h.deleted = 0";
	$r = query($q);
	while($row = fetchAssoc($r)){
		if(getRoomName($room, $row['id']))
			$at_room[$row['id']]=$row['last_name'].' '.$row['first_name'];
	}
	foreach($Server->wsClients as $client){
		if($client[15]==$room){
			$at_room_now[$client[12]]=$client[13];
		}
	}
	$mes = array(
		'data' => array(
			'online' => $on,
			'offline' => $off,
			'at_room' => $at_room,
			'at_room_now' => $at_room_now,
		),
		'type' => 'contacts',
	);
	$Server->wsSend($id, $mes);
}
function contactUpdate($id, $who_id, $type){
	global $Server;
	
	$mes = array(
		'data' => array(
			'id' => $Server->wsClients[$who_id][12],
			'room' => $Server->wsClients[$who_id][15],
			'type' => $type,
		),
		'type' => 'contact_update',
	);
	$Server->wsSend($id, $mes);
}
function addHistory($user_id, $mes, $color, $room){
	dbConnect();
	query("INSERT INTO kchat_hystory SET
		id = UUID(),
		name = '{$room}',
		date_entered = NOW(),
		date_modified = NOW(),
		modified_user_id = '{$user_id}',
		created_by = '{$user_id}',
		assigned_user_id = '{$user_id}',
		description = '{$mes}_{$color}',
		deleted = 0
	");
}
function createRoom($clientID, $user_id, $room_name){
	global $Server;
	
	$room=uniqid();
	updateRoom($room, $room_name);
	
	$mes = 'Создал новую комнату';
	// sendMess($id, $data);
	addHistory($Server->wsClients[$clientID][12], $mes, '000', $room);
	
	$Server->wsSend($clientID, array('data' => $room, 'type' => 'set_room'));
	add2Room($clientID, $user_id, $room);
}
function add2Room($clientID, $user_id, $room){
	global $Server;
	
	$mes = 'Приглашен в комнату пользователем '.$Server->wsClients[$clientID][13];
	// sendMess($id, $data);
	addHistory($user_id, $mes, '000', $room);
	if(getRoom($room, $user_id))
		updateRoom($room, false, $user_id);
	else
		updateRoom($room);
	foreach($Server->wsClients as $id => $data){
		if($data[15]!=$room){
			if($data[12]==$user_id){
				sendMess($id, array('System', $Server->wsClients[$clientID][13].' пригласил Вас в чат <a href="index.php?module=kChat&room='.$room.'">"'.getRoomName($room, $data[12]).'"</a>', '000;font-weight:bolder'));
				getRooms($id);
			}
		}else{
			getUsers($id, $room);
		}
	}
}
function updateRoom($room, $room_name=false, $user='all', $delete=false){
	if(getRoom($room, $user)){
		$q='UPDATE';
		$add_q=" WHERE room='{$room}' AND user='{$user}'";
	}
	else{
		$q='INSERT INTO';
		$add_q=", room='{$room}', user='{$user}'";
	}
	$q.=' kchat_rooms SET deleted='.(($delete)?'1':'0');
	if($room_name) $q.=", name='{$room_name}'";
	$q.=$add_q;
	query($q);
}
function getRoom($room, $user='all'){
	dbConnect();
	$q = "SELECT name, deleted FROM kchat_rooms WHERE user='{$user}' AND room='{$room}'";
	$r = query($q);
	$res = fetchAssoc($r);
	return $res;
}
function getRoomName($room_id, $user){
	if($room = getRoom($room_id, $user)){
		return (($room['deleted'])?false:$room['name']);
	}else{
		$room=getRoom($room_id);
		return $room['name'];
	}
}
function sendMess($id, $data, $room=false){
	global $Server;
	$mes = array(
		'data' => $data,
		'type' => 'mes',
	);
	if(!$room || $Server->wsClients[$id][15]==$room)
		$Server->wsSend($id, $mes);
}

function isJSON($string){
	$decode_data = json_decode($string);
	if(is_object($decode_data)){
		return $decode_data;
	}
	else{
		return false;
	}
}
function set_smiles($mes){
	$smiles_arr = array(
		'201' => array(
			':-)',
			':)',
			'=)',
		),
		'202' => array(
			':-(',
			':(',
			'=(',
		),
		'203' => array(
			':-D',
			':D',
			'=D',
		),
		'206' => array(
			';-)',
			';)',
		),
		'206' => array(
			';-)',
			';)',
		),
		'207' => array(
			';-(',
			';(',
		),
		'225' => array(
			'(finger)',
			'.!.',
		),
	);
	foreach($smiles_arr as $img => $code){
		$mes = str_replace($code, "<img src=\"modules/kChat/smiles/smailikai_com_{$img}.gif\" alt=\"{$code[0]}\"/>",$mes);
	}
	return $mes;
}

function getUserInfo($id){
	dbConnect();
	$id = mysql_real_escape_string($id);
	$r = query("SELECT * FROM users WHERE id = '{$id}'");
	if($row = fetchAssoc($r)){
		return $row;
	}else{
		return false;
	}
}
function dbConnect(){
	if(!$GLOBALS['db']){
		if(!defined('sugarEntry'))define('sugarEntry', true);
		$root_dir = dirname(dirname(__DIR__));
		chdir($root_dir);
		require_once($root_dir.'/config.php');
		$GLOBALS['db_cfg']=$sugar_config['dbconfig'];
		$GLOBALS['db'] = mysql_connect(
			$GLOBALS['db_cfg']['db_host_name'],
			$GLOBALS['db_cfg']['db_user_name'],
			$GLOBALS['db_cfg']['db_password']);
		mysql_select_db($GLOBALS['db_cfg']['db_name'], $GLOBALS['db']) or die('Can`t connect to db '.mysql_error());
		query('SET names utf8');
	}
}
function fetchAssoc($object){
    return mysql_fetch_assoc($object);
}
function query($q){
    $r = mysql_query($q) or die('SQL error '.$q.', err:'.mysql_error());
	return $r;
}
$db = false;

// start the server
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
// $Server->wsStartServer('127.0.0.1', 9300);
$Server->wsStartServer('82.146.52.49', 31130);

?>