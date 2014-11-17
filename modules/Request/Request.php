<?PHP

require_once('modules/Request/Request_sugar.php');
class Request extends Request_sugar {
	
	function Request(){
		parent::Request_sugar();
	}

    public function save()
    {
        parent::save();

        $db = DBManagerFactory::getInstance();

    }


	
}
?>