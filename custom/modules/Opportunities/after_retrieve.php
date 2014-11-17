<?php

class retrieve_opp
{

    function execute(&$bean, $event, $arguments)
    {

        if($_REQUEST['action'] != 'EditView' && $_REQUEST['action'] != 'Delete' && $_REQUEST['module'] == 'Opportunities')
        {
            $temp = $bean -> date_entered;

            $bean -> save();

            $bean -> date_entered = $temp;
        }

    }

}
