<?PHP
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class OfficeReportVariable extends Basic
{
	public $new_schema = true;
	public $module_dir = 'OfficeReportsVariables';
	public $object_name = 'OfficeReportVariable';
	public $table_name = 'officereportsvariables';
	public $importable = false;
	public $disable_row_level_security = true ;
	public $id;
	public $name;
	public $date_entered;
	public $date_modified;
	public $modified_user_id;
	public $modified_by_name;
	public $created_by;
	public $created_by_name;
	public $description;
	public $deleted;
	public $created_by_link;
	public $modified_user_link;
	public $assigned_user_id;
	public $assigned_user_name;
	public $assigned_user_link;

	function __construct()
	{
		parent::Basic();
	}

	function save($notification=false)
	{
		parent::save($notification);
	}

	function bean_implements($interface)
	{
		return FALSE;
	}

}

?>
