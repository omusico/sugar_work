<?php
global $db;
$q = "	SELECT realty.id, realty.name FROM realty
		WHERE realty.id IN(
			SELECT rrit.realty_id
			FROM realty_requests_interest_table AS rrit
			LEFT JOIN request as r ON r.id = rrit.request_id
			WHERE r.parent_id = '{$_REQUEST['record']}'
				AND rrit.deleted = 0 AND r.deleted = 0
		)";
$res=$db->query($q);
$options='';
while($row=$db->fetchByAssoc($res)){
	$options.="<li record='{$row['id']}' >{$row['name']}</li>";
}
if(!$options)
	echo "нет интересующей недвижимости";
else
	echo"<ul class='_realty_interests_'>{$options}</ul>";