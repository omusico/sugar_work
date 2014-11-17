
$(document).ready(function() {

    if($('#welcome').length || $('#welcome_link').length ){ // блокируем вывод чата, если пользователь не авторизован

    // Описанное диалоговое окно чата
    $("#main_chat").dialog({
        title: "Chat SugarTalk",
        width:400,
        height: 350,
        autoOpen: false,
        dialogClass: 'dialogclass',
        modal: false,
        resizable: false
    });
        $('#main_chat').removeClass('ui-dialog-content');
        $('#main_chat').removeClass('ui-dialog-content');
        $('#main_chat').removeClass('ui-widget-content');



        // функция записи сообщений в БД
        $('#send_mess').click(function() {

            var send_text = $("#send_text").children().val();

            if(send_text.length){
                $.ajax({
                    url: 'index.php?entryPoint=record_message_in_database&send_text='+send_text,
                    type: 'post',
                    success: function(data)
                    {
                        $("#message_list").append('<div style="color: #0000ff; ">'+data+'</div>');
                        $("#message_list").append('<div style="color: #0000ff; ">'+send_text+'</div>');
                        $("#message_list").append('<div ></br></div>');
                        $("#send_text").children().val("");
                    }
                });
            }
        });


// Открывем историю переписки с активным контактом

        $('#open_history').click(function(){

            $("#history_chat").dialog({
                title: "Архив сообщений",
                position: [625,400],
                width:350,
                height: 450,
                modal: false,
                resizable: false
            });

            var id_user_history = $('div.active_session').children().attr('id');
            $("#history_chat").html('');
            $.getJSON('index.php?entryPoint=chat_history&history_id='+id_user_history, function(data){

                jQuery.each(data, function(key, val){

                    var sender_id = val.sender_id;

                    if (sender_id == id_user_history){

                        $("#history_chat").append('<div style="color: #ff0e10; ">'+val.time_mess+'</div>');
                        $("#history_chat").append('<div style="color: #ff0e10; ">'+val.message+'</div>');
                        $("#history_chat").append('<div ></br></div>');
                    }
                    else{
                        $("#history_chat").append('<div style="color: #0a0fff; ">'+val.time_mess+'</div>');
                        $("#history_chat").append('<div style="color: #0a0fff; ">'+val.message+'</div>');
                        $("#history_chat").append('<div ></br></div>');
                    }
                });
            });
        });

// очистить диалог общения
        $('#clear_dialogue').click(function() {
            var id_user_clear = $('div.active_session').children().attr('id');
            $.getJSON('index.php?entryPoint=clear_dialogue&user_clear='+id_user_clear);
            $("#message_list").html('');
        });
    }

    else{
        $("#main_chat").empty();
    }
});


