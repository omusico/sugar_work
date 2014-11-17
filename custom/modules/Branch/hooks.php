<?php
/*
*	Created by Kolerts
*/
class myHookBranch 
{
    function changeUserTitle(SugarBean $bean, $event, $arguments)
    {
		if($bean->fetched_row['assigned_user_id']!=$bean->assigned_user_id)
		{
			$user = loadBean('Users');
			$user->retrieve($bean->assigned_user_id);
			$user->title='branch';
			$user->save();
		}
    }
 
}