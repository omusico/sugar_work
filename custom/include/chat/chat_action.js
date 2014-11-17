

// помечаем окно чата как закрытое
$('span.ui-icon-closethick').click(function() {
    $('#main_chat').removeClass('chat_is_open');
});



// Подгрузка сессий общения между пользоваелями чата
$('.dialogue').live('click',function(){

    $("#message_list").html('');
    var id_cont = $(this).children().attr('id');

    $('a').parent().removeClass('active_session');
    $('#'+id_cont+'').parent().addClass('active_session');
    $('#'+id_cont+'').parent().removeClass('has_mess');
    $('#'+id_cont+'').children().remove();


    $.getJSON('index.php?entryPoint=check_session&friend_id='+id_cont, function(data){

        jQuery.each(data, function(key, val){

            var sender_id = val.sender_id;
            $("#"+sender_id).parent().removeClass('has_mess');
            if (sender_id == id_cont){

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
});
