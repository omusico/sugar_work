<?PHP

require_once('modules/RealtyTemplates/RealtyTemplates_sugar.php');
class RealtyTemplates extends RealtyTemplates_sugar {
    var $importable = true;


//    function RealtyTemplates(){
//        parent::RealtyTemplates_sugar();
//    }

    public function __construct()
    {
        parent::RealtyTemplates_sugar();
        $this->emailAddress = new SugarEmailAddress();
//        if($_REQUEST['action'] == 'EditView' && empty($_REQUEST['record']))
//        {
//            $this->id = create_guid();
//        }

    }

    public function retrieve($id = -1, $encode=true)
    {
        $ret_val = parent::retrieve($id, $encode);
        $this->emailAddress->handleLegacyRetrieve($this);
        return $ret_val;
    }

    public function save($check_notify=false)
    {
        if(empty($_POST['record']) && empty($this->id) && (!empty($_POST['new_with_id'])))
        {
           $this->new_with_id = true;
           //$this->id = $_POST['record'];
           $this->id = $_POST['new_with_id'];
        }
        $ori_in_workflow = empty($this->in_workflow) ? false : true;
        $this->emailAddress->handleLegacySave($this, $this->module_dir);

        if($this->type_of_realty == "not_living" || $this->type_of_realty == "parcel")
        {
            $this->totalcost = $this->cost * $this->square;
        }

        if($this->type_of_realty == "living")
        {
            $this->totalcost = $this->cost;
        }

		/*if($this->period == 'year')
		{
			$this->totalcost = $this->totalcost * 12;
		}*/

        parent::save($check_notify);


        $override_email = array();
        if(!empty($this->email1_set_in_workflow)) {
            $override_email['emailAddress0'] = $this->email1_set_in_workflow;
        }
        if(!empty($this->email2_set_in_workflow)) {
            $override_email['emailAddress1'] = $this->email2_set_in_workflow;
        }
        if(!isset($this->in_workflow)) {
            $this->in_workflow = false;
        }
        if($ori_in_workflow === false || !empty($override_email)){
            $this->emailAddress->save($this->id, $this->module_dir, $override_email,'','','','',$this->in_workflow);
        }

        $db = DBManagerFactory::getInstance();

        if((empty($this->latitude) AND empty($this->longitude)) OR $this->address_country != $this->fetched_row['address_country'] OR $this->address_city != $this->fetched_row['address_city'] OR $this->address_street != $this->fetched_row['address_street'] OR $this->address_house != $this->fetched_row['address_house'])
        {
            $res = $db->query("SELECT address_country,address_city,address_street,address_house FROM realtytemplates WHERE id = '{$this->id}' ");
            $result = $db->fetchByAssoc($res);

            $this->address_country = $result['address_country'];
            $this->address_city = $result['address_city'];
            $this->address_street = $result['address_street'];
            $this->address_house = $result['address_house'];

            $lat = $this->get_geocode('lat');
            $lng = $this->get_geocode('lng');

            $db->query("UPDATE realtytemplates SET latitude = '{$lat}', longitude = '{$lng}' WHERE id = '{$this->id}' ");
        }

        return $this->id;
    }

    /* if $data_return == lat, function returns latitude
    * if $data_return == lng, function return longitude
    * address format should be:
    * Street City, Address, State, Country
    */
    function get_geocode($data_return)
    {
        $full_address = $this->address_city . "," . $this->address_street . "," . $this->address_house . "," . $this->address_country;

        $xml = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?address=' . $full_address . '&sensor=false');

        $status = $xml->status;
        if ($status == 'OK')
        {
            $lat = $xml->result->geometry->location->lat;
            $lng = $xml->result->geometry->location->lng;
            if($data_return == 'lat')
            {
                return $lat;
            }
            if($data_return == 'lng')
            {
                return $lng;
            }
        }
        else { return 0; }
    }

    function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean=null, $singleSelect = false, $ifListForExport = false)
    {
        $where = str_replace('\\', '', $where);
        $_REQUEST['account_name_advanced'] = str_replace('\\', '', $_REQUEST['account_name_advanced']);
//        $where = str_replace('\"', '"', $where);
        $ret_array = parent::create_new_list_query($order_by, $where, $filter, $params, $show_deleted, $join_type, $return_array, $parentbean, $singleSelect);

        global $db;
        $sql = 'SELECT realtytemplates.latitude, realtytemplates.longitude, realtytemplates.name, realtytemplates.id '.$ret_array['from'].$ret_array['where'];
        $res = $db->query($sql);

        While($result = $db->fetchByAssoc($res))
        {
            if($_REQUEST['action'] != 'xls_export' &&  (!isset($_REQUEST['to_pdf']) || $_REQUEST['to_pdf'] != "1") )
                echo('<input type="hidden" class="realty_map" data-lat="'.$result['latitude'].'" data-lon="'.$result['longitude'].'" data-name="'.$result['name'].'" data-id="'.$result['id'].'">');
        }
        //print_r($ret_array);
        return $ret_array;
    }

}
?>
