<?php
$entry_point_registry['upload_photo'] = array('file' => 'custom/include/GalleryField/upload.php' , 'auth' => '1');
$entry_point_registry['crop_photo'] = array('file' => 'custom/include/GalleryField/crop.php' , 'auth' => '1');
$entry_point_registry['popup_check'] = array('file' => 'custom/modules/Realty/popup_hook.php' , 'auth' => '1');
$entry_point_registry['adress_data'] = array('file' => 'custom/modules/Realty/tpls/data.php' , 'auth' => '1');
$entry_point_registry['check_activity'] = array('file' => 'custom/include/checkActivity/check_activity.php' , 'auth' => '1');
$entry_point_registry['pokaz_calendar'] = array('file' => 'custom/modules/Meetings/metadata/pokaz_calendar.php' , 'auth' => '1');
$entry_point_registry['pokaz_list'] = array('file' => 'custom/modules/Meetings/metadata/pokaz_list.php' , 'auth' => '1');
$entry_point_registry['check_phone'] = array('file' => 'custom/fieldFormat/check_phone.php' , 'auth' => '1');
$entry_point_registry['check_auth'] = array('file' => 'custom/include/chat/check_auth.php','auth' => true);
$entry_point_registry['check_session'] = array('file' => 'custom/include/chat/check_session.php','auth' => true);
$entry_point_registry['record_message_in_database'] = array('file' => 'custom/include/chat/record_message_in_database.php','auth' => true);
$entry_point_registry['search_new_message'] = array('file' => 'custom/include/chat/search_new_message.php','auth' => true);
$entry_point_registry['load_data_chat_window'] = array('file' => 'custom/include/chat/load_data_chat_window.php','auth' => true);
$entry_point_registry['load_mess_chat_window'] = array('file' => 'custom/include/chat/load_mess_chat_window.php','auth' => true);
$entry_point_registry['chat_history'] = array('file' => 'custom/include/chat/chat_history.php','auth' => true);
$entry_point_registry['chat_window'] = array('file' => 'custom/include/chat/chat_window.php','auth' => true);

$entry_point_registry['clear_dialogue'] = array('file' => 'custom/include/chat/clear_dialogue.php','auth' => true);
$entry_point_registry['search_new_message_off'] = array('file' => 'custom/include/chat/search_new_message_off.php','auth' => true);
$entry_point_registry['create_tpl_obj'] = array('file' => 'modules/Buildings/create_tpl_obj.php','auth' => true);
$entry_point_registry['get_cladr_code'] = array('file' => 'custom/modules/Realty/get_cladr_code.php' , 'auth' => '1');
$entry_point_registry['add_address'] = array('file' => 'custom/modules/Buildings/add_address.php' , 'auth' => true);
$entry_point_registry['check_cost'] = array('file' => 'custom/modules/Opportunities/check_cost.php' , 'auth' => true);
$entry_point_registry['load_kxml_list'] = array('file' => 'custom/modules/Realty/load_kxml_list.php' , 'auth' => '1');
$action_view_map['hello'] = 'helloActionView';

?>