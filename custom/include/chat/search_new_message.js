
$(document).ready(function() {

    search_new_message();

    function search_new_message(){

        if($('#main_chat').hasClass("chat_is_open")){

            $.getJSON('index.php?entryPoint=search_new_message', function(data){


                jQuery.each(data, function(key, val){

                    var sender_id = val.sender_id;

                    if ($("#"+sender_id).hasClass("active_session")){

                        $("#message_list").append('<div style="color: #ff0000; ">'+val.time_mess+'</div>');
                        $("#message_list").append('<div style="color: #ff0000; ">'+val.message+'</div>');
                        $("#message_list").append('<div ></br></div>');

                    }
                    else {
                        $("#sms").remove();
                        $("#"+sender_id).parent().addClass('has_mess');
                        $("#"+sender_id).prepend('<div id="sms"><img id="theImg" style="width: 12px; height=12px; float: left" src="custom/include/chat/img/email28.gif" /></div>')


                    }

                });
            });
            setTimeout(search_new_message, 2000);
        }
        else{

            $.getJSON('index.php?entryPoint=search_new_message_off', function(data){

                   if(data > 0){
                        $('#mess_blink').css("display", "block");
                    }
            });
            setTimeout(search_new_message, 60000);
    }


}
});




