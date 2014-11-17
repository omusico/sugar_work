<?php
class Chat_Hooks
{

    public function written_time_database($event, $arguments)
    {



        $html = "<img id='mess_blink' style='position: fixed; top: 178px; width:25px; height:25px; display: none;' src='custom/include/chat/img/email37.gif' /><div id='anchor'> <input type='submit' id='anchor_link' value='Chat  SugarTalk' style='width:80x;height: 30px; position: fixed; top: 253px;
    left: -55px;' ></div>";




        $html .= '<script type="text/javascript" src="custom/include/chat/search_new_message.js"></script>';

        $html .= '<script type="text/javascript" src="custom/include/chat/check_auth.js"></script>';

        $html .= '<script type="text/javascript" src="custom/include/chat/lead_anchor.js"></script>';

        $html .= '<script type="text/javascript" src="custom/include/chat/chat_window.js"></script>';

        $html .= "<body><div id='main_chat' style='display: none'>
        <div id='book' style='width:250px; height: 250px; float:right; overflow:auto; white-space: normal; word-wrap:break-word; background: white'><span id='message_list'></span>
        </div>

        <div id='contacts' style='width:145px; height: 250px; float:left; overflow:auto; background: #e0ffeb'><span id='contacts_list_on'></span><span id='contacts_list_off'></span>
        </div>

            <div id='button_zone' style='background: white; width:400px; height: 250px; clear:left;'>

        <div id='send_text'><textarea style='width:395px;'></textarea></div>

        <a href='#' ><img src='custom/include/chat/img/images_history.jpg' title='История переписки' id='open_history' style='float:left; padding-left:4px; width: 20px; height: 20px' ></a>

        <a href='#' ><img src='custom/include/chat/img/add_to_shopping_cart.png' title='Очистить диалог' id='clear_dialogue' style='float:left; padding-left:10px; width: 22px; height: 22px' ></a>

        <input type='submit' id='send_mess' style='float:right; height: 20px;' value='Отправить сообщение'>


        </div>

        </div>
            </div>
           </div>
        </body>";

        $html .= "<div id='history_chat'>
        <div id='history_list'></div>
        </div>";


        if($_REQUEST['action'] != 'xls_export' &&  (!isset($_REQUEST['to_pdf']) || $_REQUEST['to_pdf'] != "1") )
        {
            echo $html;
        }

    }
}



