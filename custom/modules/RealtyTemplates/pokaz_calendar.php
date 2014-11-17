<?php
if(isset($_REQUEST['uid']) && $_REQUEST['uid']!='')
	SugarApplication::redirect("index.php?module=Meetings&action=pokaz_calendar&realty_ids={$_REQUEST['uid']}");
?>
