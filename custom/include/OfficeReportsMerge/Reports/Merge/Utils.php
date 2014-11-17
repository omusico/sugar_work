<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Reports_Merge_Utils
{
	private $officeDocx = NULL;
	private $methods = array();
	private $options = array();

	public function __construct()
	{
		require_once 'custom/include/OfficeReportsMerge/Reports/Merge.php';
		$this->officeDocx = new Reports_Merge();
		$this->methods = get_class_methods('Reports_Merge');

		$this->setOptions();
	}


	private function setOptions()
	{
		$this->options = Reports_Utils::get_config();
	}

	/**
	 * @param SugarBean $bean
	 * @return string uploaded file name
	 */
	public function uploadTemplate(&$bean)
	{
        global $mod_strings;

		$GLOBALS['log']->debug("Reports_Merge_Utils->uploadTemplate");

		//we need to manually set the id if it is not already set
		//so that we can name the file appropriately

		if(empty($bean->id))
		{
			$bean->id = create_guid();
			$bean->new_with_id = true;
		}

        $field_name = 'filename';

		if (!empty($_FILES[$field_name]['name']))
		{
			global $sugar_config;
			//if a previous file has been uploaded then remove it now

            $path_parts = pathinfo($_FILES[$field_name]['name']);
            if (!Reports_Utils::check_extension_template($path_parts['extension']))
            {
                sugar_die('ERROR: ' . $mod_strings['ERR_UPLOADED_FILE_EXTENSION_NOT_SUPPORT']);
            }

			if(!empty($_REQUEST['old_'.$field_name]))
			{
				// create a non UTF-8 name encoding
				// 176 + 36 char guid = windows' maximum filename length
				$old_file_name = $_REQUEST['old_'.$field_name];

				$end = (strlen($old_file_name) > 176) ? 176 : strlen($old_file_name);

				$stored_file_name = substr($old_file_name, 0, $end);
				$old_photo = $sugar_config['upload_dir'].$bean->id.'_'.$old_file_name;
				$GLOBALS['log']->debug("Reports_Merge_Utils->uploadTemplate: Deleting old template: ".$old_photo);

				unlink($old_photo);
			}


			$file_name = $bean->id.'_'.$_FILES[$field_name]['name'];

			//save the file name to the database
			$bean->$field_name = $_FILES[$field_name]['name'];

			if(!is_uploaded_file($_FILES[$field_name]['tmp_name']))
			{
				sugar_die("ERROR: {$mod_strings['ERR_NOT_UPLOAD']}");
				//return false;
			}
			elseif($_FILES[$this->field_name]['size'] > $sugar_config['upload_maxsize'])
			{
                sugar_die("ERROR: {$mod_strings['ERR_MAX_SIZE_UPLOAD_FILE']}: {$sugar_config['upload_maxsize']}");
			}


			// create a non UTF-8 name encoding
			// 176 + 36 char guid = windows' maximum filename length
			$end = (strlen($file_name) > 176) ? 176 : strlen($file_name);
			$stored_file_name = substr($file_name, 0, $end);

			$destination =$sugar_config['upload_dir'].$stored_file_name;

			if(!is_writable($sugar_config['upload_dir']))
			{
                sugar_die("ERROR: {$mod_strings['ERR_CANNT_WRITE_DIR']}: {$sugar_config['upload_dir']} for uploads");
			}

			//$destination = clean_path($this->get_upload_path($bean_id));
			if(!move_uploaded_file($_FILES[$field_name]['tmp_name'], $destination))
			{
                sugar_die("ERROR: {$mod_strings['ERR_CANNT_MOVE']} $destination. {$mod_strings['ERR_NEED_WRITABLE_DIR']}");
			}

			return $bean->$field_name;

		}
	}


	/**
	 * @return Reports_Merge
	 */
	public function getDocxObject()
	{
		return $this->officeDocx;
	}


}