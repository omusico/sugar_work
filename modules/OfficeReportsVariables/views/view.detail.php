<?php
require_once('include/MVC/View/views/view.detail.php');

class OfficeReportsVariablesViewDetail extends ViewDetail
{

 	function OfficeReportsVariablesViewDetail()
 	{
 		parent::ViewDetail();
 	}

 	function display()
 	{
 		echo '<style type="text/css">@import url("custom/include/OfficeReportsMerge/Prettify/prettify.css"); </style>';
 		echo '<script>YAHOO.util.Event.onDOMReady(function() {prettyPrint();});</script>';

 		$this->dv->process();
 		parent::display();
 	}
}
?>