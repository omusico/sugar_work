// Подтягиваем пользователей в контакт-лист окна - обновляет через заданное время

check_auth_list();

function check_auth_list()
{
    if($('#main_chat').hasClass("chat_is_open")){
    $.getJSON('index.php?entryPoint=chat_window', function(data){
        jQuery.each(data, function(key, val){
            var user_id = key;

            if (val.auth_action == 1)
            {
                var user_str = '<div class="dialogue"><a href="#" class="active_user" id='+user_id+' style="text-decoration: none; color: blue; ">'+val.first_name+" "+val.last_name+'</a></div>';

                if($("#"+user_id).length)
                {
                    if($("#"+user_id).hasClass("not_active_user"))
                    {
                        $("#"+user_id).removeClass('not_active_user');
                        $("#"+user_id).addClass('active_user');
                        if($("#"+user_id).parent().hasClass('active_session')){

                            $("#"+user_id).parent().remove();
                            $("#contacts_list_on").append(user_str);
                            $("#"+user_id).parent().addClass('active_session');

                        }
                        else{

                            $("#"+user_id).parent().remove();
                            $("#contacts_list_on").append(user_str);
                        }
                    }

                }
                else
                {
                    $("#contacts_list_on").append(user_str);
                }
            }
            else
            {
                var user_str = '<div class="dialogue"><a href="#" class="not_active_user" id='+user_id+' style="text-decoration: none; color: gray; "> '+val.first_name+" "+val.last_name+'</a></div>';
                if($("#"+user_id).length)
                {
                    if($("#"+user_id).hasClass("active_user"))
                    {
                        $("#"+user_id).removeClass('active_user');
                        $("#"+user_id).addClass('not_active_user');
                        if($("#"+user_id).parent().hasClass('active_session')){

                            $("#"+user_id).parent().remove();
                            $("#contacts_list_off").append(user_str);
                            $("#"+user_id).parent().addClass('active_session');

                        }
                        else{

                            $("#"+user_id).parent().remove();
                            $("#contacts_list_off").append(user_str);
                        }

                    }
                }
                else
                {
                    $("#contacts_list_off").append(user_str);
                }
            }
        });

    });
    }
    setTimeout(check_auth_list, 2500);

}