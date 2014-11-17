<?PHP

require_once('modules/Buildings/Buildings_sugar.php');
class Buildings extends Buildings_sugar {

	function Buildings(){
		parent::Buildings_sugar();
	}

    public function save()
    {
        if(empty($_POST['record']) && empty($this->id) && (!empty($_POST['new_with_id'])))
         {

            $this->new_with_id = true;

            //$this->id = $_POST['record'];

            $this->id = $_POST['new_with_id'];

         }



        parent::save();

        $db = DBManagerFactory::getInstance();

        if((empty($this->latitude) AND empty($this->longitude)) OR $this->address_country != $this->fetched_row['address_country'] OR $this->address_city != $this->fetched_row['address_city'] OR $this->address_street != $this->fetched_row['address_street'] OR $this->address_house != $this->fetched_row['address_house'])
        {
            $country_res = $db->query("SELECT address_country,address_city,address_street,address_house FROM buildings WHERE id = '{$this->id}' ");
            $result = $db->fetchByAssoc($country_res);


            $this->address_country = $result['address_country'];
            $this->address_city = $result['address_city'];
            $this->address_street = $result['address_street'];
            $this->address_house = $result['address_house'];

            $lat = $this->get_geocode('lat');
            $lng = $this->get_geocode('lng');

            $db->query("UPDATE buildings SET latitude = '{$lat}', longitude = '{$lng}' WHERE id = '{$this->id}' ");
        }

		$this->fix_galery($this->id, $this->galeria_c);
    }
	function fix_galery($id, $gallery_field){
		global $db;
		$sql="UPDATE buildings_cstm SET galeria_c='{$gallery_field}' WHERE id_c='{$id}'";
		$db->query($sql);
	}

    function get_geocode($data_return)
    {
        $full_address = $this->address_city . "," . $this->address_street . " " . $this->address_house . "," . $this->address_country;

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

}
?>