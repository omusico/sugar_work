<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class RealtyViewLIST extends ViewList {

    function display()
    {
       parent::display();
       echo('<div id="map_div" style="display:none;position:fixed;width:100%; height:95%;padding:0;top:0px;left:0px;z-index:100;">');
        $map_html = '<style>';
        $map_html .= ' .ui-autocomplete {';
        $map_html .= ' background-color: white;';
        $map_html .= ' width: 300px;';
        $map_html .= ' border: 1px solid #cfcfcf;';
        $map_html .= ' list-style-type: none;';
        $map_html .= ' padding-left: 0px;}';
        $map_html .= ' </style>';
        $map_html .= ' <input id="address" type="hidden"/>';
        $map_html .= ' <div id="map_canvas" style="width:100%; height:100%; border: 1px solid; margin:0;"></div></div>';
    echo($map_html);




//       echo('<div type="button" id="map_knopke" value="Карта Google" title="Карта Google" style="position:fixed; top:200px;right: 0px;z-index:200;width:1em; line-height:1em;border:1px solid black;background-color:#58b;opacity:0.6;-moz-opacity:0.6;color:white;font-weight:bold;padding:3px;cursor:pointer;">К А Р Т А &nbsp; &nbsp; G O O G L E</div>');
        echo('<div type="button" id="map_knopke" value="Карта Google" title="Карта Google" style="
           position:fixed;
           top:250px;
           right: -37px;
           z-index:200;
           line-height:1em;
           border:1px solid black;
           background-color:#356B83;
           background-image:linear-gradient(to bottom, #609EB9, #356B83);
           border-color: #356B83 #356B83 #002A80;
           transform: rotate(90deg);
           -webkit-transform: rotate(90deg);
           -o-transform: rotate(90deg);
           -ms-transform: rotate(90deg);
           color:white;
           padding:5px;
           font-size: 15px;
           border-radius: 3px;
           text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
           cursor:pointer;">Карта Google</div>');


       echo('<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>');

       echo('<script type="text/javascript" src="https://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.11/src/infobox.js"></script>');
       echo("<script src='custom/modules/Realty/js/listview.js'></script>");


    }

	public function preDisplay()
	{
		parent::preDisplay();
		$this->lv->actionsMenuExtraItems[] = $this->pokaz_calendar();
        echo '<script type="text/javascript" src="custom/modules/Realty/js/assisJSON.js"></script>';
	}

	protected function pokaz_calendar()
	{
		global $app_strings;
		return "
			<a class='menuItem'  href='#'
				onmouseover='hiliteItem(this,\"yes\");'
				onmouseout='unhiliteItem(this);'
				onclick=\"sugarListView.get_checks();
					if(sugarListView.get_checks_count() &lt; 1) {
						alert('{$app_strings['LBL_LISTVIEW_NO_SELECTED']}');
						return false;
					}
					document.MassUpdate.action.value='pokaz_calendar';
					document.MassUpdate.submit();
				\">
			Календарь показов</a>
		";
	}
}
