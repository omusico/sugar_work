<?php
# This module show an sms icon to phone numbers where a user can send sms
# Applicable to Detail View
# c/o tracy
if(isset($_GET['pnum']) && $_GET['pnum']!='')
{
	global $db;
	$query = "	SELECT id
					FROM {$_GET['module']}
					WHERE
						deleted = 0
						AND SUBSTRING_INDEX({$_GET['fname']}, '^|^', -1 ) = '{$_GET['pnum']}'
				";
	if($_GET['id']!='')
		$query .= " AND id <> '{$_GET['id']}'";
	$result = $db->query($query);
	if($row = $db->fetchByAssoc($result))
		echo 'true';
	else
		echo $query;
}

?>
