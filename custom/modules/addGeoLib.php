<?php
class addGeoLib
{
	function add()
	{
		if (
			!isset($_REQUEST['to_pdf']) &&
			(in_array($_REQUEST['module'], array(
				'Realty',
				'Buildings',
				'Contacts',
				'Accounts',
			)))
		){
			echo '<script src="custom/modules/Realty/tpls/jquery.geocomplete.min.js"></script>';
		}
	}
 }
