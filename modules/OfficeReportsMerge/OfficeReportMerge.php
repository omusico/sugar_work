<?PHP
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'custom/include/OfficeReportsMerge/Reports/Merge/Utils.php';

class OfficeReportMerge extends Basic
{
	public $new_schema = true;
	public $module_dir = 'OfficeReportsMerge';
	public $object_name = 'OfficeReportMerge';
	public $table_name = 'officereportsmerge';
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
	public $filename;
	public $report_module;
	public $report_filename;
	public $date_format_for_name = '%d-%m-%Y %H:%M';
	public $report_vars;
    public $extension_template;

	function __construct()
	{
		parent::Basic();
	}

	function save($notification=false)
	{
		$focus = new Reports_Merge_Utils();
		$focus->uploadTemplate($this);

        $info = pathinfo($this->filename);
        $this->extension_template = $info['extension'];

		if (empty($this->report_filename))
		{
			$this->report_filename = $info['filename'] . ' ' . $this->date_format_for_name;
		}

		parent::save($notification);
	}

	function bean_implements($interface)
	{
		switch($interface)
		{
			case 'ACL': return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param string $record_id ID of Report
	 * @return Reports_Merge
	 */
	public function buildReport($record_id)
	{
		if (empty($this->id)) return;

		global $beanList;

		$focus = new Reports_Merge_Utils();

		$filename = $this->getStoredFileName();

		$officeDocx = $focus->getDocxObject();

		$officeDocx->setTemplate($filename);

		$seed = new $beanList[$this->report_module];
		$seed->retrieve($record_id);
		$field_values = Reports_Utils::define_fields_value($seed, unencodeMultienum($this->report_vars));
		unset($seed);

		$officeDocx->assign($field_values);

		$officeDocx->createDocument();

		return $officeDocx;
	}

	public function getStoredFileName()
	{
		global $sugar_config;

		$filename = $this->id .'_'. $this->filename;

		$end = (strlen($filename) > 176) ? 176 : strlen($filename);
		$stored_file_name = substr($filename, 0, $end);

		$stored_file_name = $sugar_config['upload_dir'].$stored_file_name;

		return $stored_file_name;
	}

}

?>
