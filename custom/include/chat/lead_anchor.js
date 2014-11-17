

// удаляет вкладку чата если пользовательне авторизован
if(!$('#welcome').length || !$('#welcome_link').length ){

    $("#anchor").empty();
}

// Вызов окна чата
$('#anchor_link').click(function() {

    if(!$('#main_chat').hasClass("chat_is_open")){

        $('#main_chat').dialog('open');
        $('#main_chat').addClass('chat_is_open');
        $('#mess_blink').css("display", "none");

        // Подгрузка последней активной сессии
        setTimeout(load_data_chat_window, 3000);

        function load_data_chat_window(){
            $.getJSON('index.php?entryPoint=load_data_chat_window', function(data){
                $('#'+data).parent().addClass('active_session');
            });

        }

// Подгрузка в окно чата последней активной сессии истории сообщений
        setTimeout(load_mess_chat_window, 3200);

        function load_mess_chat_window(){
            var id_friend_session = $('div.active_session').children().attr('id');
            $.getJSON('index.php?entryPoint=load_mess_chat_window&friend_session='+id_friend_session, function(data){
                jQuery.each(data, function(key, val){
                    var sender_id = val.sender_id;
                    if (sender_id == id_friend_session){
                        $("#message_list").append('<div style="color: #ff0e10; ">'+val.time_mess+'</div>');
                        $("#message_list").append('<div style="color: #ff0e10; ">'+val.message+'</div>');
                        $("#message_list").append('<div ></br></div>');
                    }
                    else{
                        $("#message_list").append('<div style="color: #0a0fff; ">'+val.time_mess+'</div>');
                        $("#message_list").append('<div style="color: #0a0fff; ">'+val.message+'</div>');
                        $("#message_list").append('<div ></br></div>');
                    }
                });
            });
        }

    }
    else{
        $('#main_chat').dialog('close');
        $('#main_chat').removeClass('chat_is_open');
        $('#mess_blink').css("display", "none");
    }
});






