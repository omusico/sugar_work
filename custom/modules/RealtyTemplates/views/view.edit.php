<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class RealtyTemplatesViewEdit extends ViewEdit {

    function RealtyTemplatesViewEdit()
    {
        parent::ViewEdit();
    }

    function display()
    {
        $geodata = array();
        global $current_user;
        if($this->bean->assigned_user_id == "") $this->bean->assigned_user_id = $current_user->id;
        if($_REQUEST['return_module'] == "Buildings"){
            $this->fix_fields_request();
            $geodata = $this->get_geocode($this->bean);
            $this->bean->sections_exist = 'no';
            $this->bean->latitude = $geodata['lat'];
            $this->bean->longitude = $geodata['lng'];
            if(isset($_POST['buildings_id']) && !empty($_POST['buildings_id'])) $this->bean->building_id = $_POST['buildings_id'];
            if(isset($_POST['buildings_name']) && !empty($_POST['buildings_name'])) $this->bean->building_name = $_POST['buildings_name'];
        }


//        if(isset($_POST['number_of_floors']) && !empty($_POST['number_of_floors'])) $this->bean->number_of_floors = $_POST['number_of_floors'];
         echo("<script src='cache/include/javascript/sugar_grp_yui_widgets.js' type='text/javascript'></script>");
         //echo("<script src='cache/include/javascript/sugar_grp1.js' type='text/javascript'></script>");
         //echo("<script src='cache/include/javascript/sugar_grp1_yui.js' type='text/javascript'></script>");
         echo("<script src='cache/include/javascript/sugar_grp_yui2.js' type='text/javascript'></script>");
         //echo("<script src='cache/include/javascript/sugar_grp_jsolait.js' type='text/javascript'></script>");
        parent::display();

        // Return realty email
//        if ($_REQUEST['em_dup'] == 1){
//
//            echo "<script type='text/javascript'>
//                function em_dup()
//                {
//                    $('#Realty0emailAddress0').val('{$_REQUEST['Realty0emailAddress0']}')
//                }
//                setTimeout(em_dup,10)
//            </script>";
//        }
    }

    function fix_fields_request()
    {
        if(!isset($_REQUEST['record']))
            foreach(array_keys($_POST) as $key)
                if(isset($this->bean->field_defs[$key])){
                        $this->bean->$key=$_POST[$key];
                }
    }


    function get_geocode(SugarBean $bean)
    {
        $full_address = $bean->address_city . "," . $bean->address_street . "," . $bean->address_house . "," . $bean->address_country;

        $xml = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?address=' . $full_address . '&sensor=false');

        $status = $xml->status;
        if ($status == 'OK')
        {
            $lat = $xml->result->geometry->location->lat;
            $lng = $xml->result->geometry->location->lng;
            return array('lat'=>$lat, 'lng'=>$lng);
        }
        else { return 0; }
    }


//    public function getMetaDataFile()
//    {
//        parent::getMetaDataFile();
//
//        global $current_user;
//
//        return $getMetaDataFile;
//    }
}
