<?php
class userRelateFix{

    function onSave(&$bean)
    {
       $query = "SELECT id
                    FROM calls_users
                    WHERE
                        deleted <> 1 AND
                        call_id='{$bean->id}' AND
                        user_id='{$bean->assigned_user_id}'";
		$result = $bean->db->query($query);
		if(!$row = $bean->db->fetchByAssoc($result))
		{
		   $query = "INSERT INTO calls_users
						(id, call_id, user_id, deleted, required, accept_status, date_modified)
						VALUES
							('".create_guid()."', '{$bean->id}', '{$bean->assigned_user_id}', 0, 1, 'none', '".date('Y-m-d H:i:s')."')
					";
			$result = $bean->db->query($query);
		}
	}
}