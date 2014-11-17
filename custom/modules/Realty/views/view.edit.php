<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class RealtyViewEdit extends ViewEdit {

    function UsersViewEdit()
    {
        parent::ViewEdit();
    }

    function display()
    {
		$this->fix_fields_request();
        parent::display();
        // Return realty email
        if ($_REQUEST['em_dup'] == 1){

            echo "<script type='text/javascript'>
                function em_dup()
                {
                    $('#Realty0emailAddress0').val('{$_REQUEST['Realty0emailAddress0']}')
                }
                setTimeout(em_dup,10)
            </script>";
        }
    }
	function fix_fields_request() // ��������� ������ ���� �� GET �������, ��� ���������� �������� ��� �������� //fix
	{
		if(!isset($_REQUEST['record']))
			foreach(array_keys($_GET) as $key)
				if(isset($this->bean->field_defs[$key])){
					$this->bean->$key=$_GET[$key];
		}
	}

    public function getMetaDataFile()
    {
        parent::getMetaDataFile();

        global $current_user;

        if ($this->bean->realty_status == 'realtor' && $current_user->id != $this->bean->assigned_user_id)
        {
            //$getMetaDataFile = 'custom/modules/Realty/metadata/editviewdefsTypeRealtor.php';
            $getMetaDataFile = 'custom/modules/Realty/metadata/editviewdefs.php';
        }
        else
        {
            $getMetaDataFile = 'custom/modules/Realty/metadata/editviewdefs.php';
        }

        return $getMetaDataFile;
    }
}
