<?PHP


class Request_sugar extends Basic {
    var $new_schema = true;
    var $module_dir = 'Request';
    var $object_name = 'Request';
    var $table_name = 'request';
    var $importable = false;
    var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;
    function Request_sugar()
    {
        parent::Basic();
        $cont = new Contact();
        $cont->retrieve('f0552f45-5d45-b8cd-b32c-521730a146f2');
        /*$rabbit = new SugarRabbit();
        $rabbit->CreateContact($cont);*/
    }

    function bean_implements($interface)
    {
        switch($interface)
        {
            case 'ACL': return true;
        }
        return false;
    }
		
}
?>