<?php

include_once('custom/include/OfficeReportsMerge/Reports/libs/tbs_class.php');
include_once('custom/include/OfficeReportsMerge/Reports/libs/plugins/tbs_plugin_aggregate.php');
include_once('custom/include/OfficeReportsMerge/Reports/libs/plugins/tbs_plugin_opentbs.php');

class Reports_Merge extends clsTinyButStrong
{
    private $extension;

    private $mimetype = array(
        'sxw'  => 'application/vnd.sun.xml.writer',
        'stw'  => 'application/vnd.sun.xml.writer.template',
        'sxg'  => 'application/vnd.sun.xml.writer.global',
        'sxc'  => 'application/vnd.sun.xml.calc',
        'stc'  => 'application/vnd.sun.xml.calc.template',
        'sxi'  => 'application/vnd.sun.xml.impress',
        'sti'  => 'application/vnd.sun.xml.impress.template',
        'sxd'  => 'application/vnd.sun.xml.draw',
        'std'  => 'application/vnd.sun.xml.draw.template',
        'sxm'  => 'application/vnd.sun.xml.math',
        'odt'  => 'application/vnd.oasis.OpenDocument.text',
        'ott'  => 'application/vnd.oasis.OpenDocument.text-template',
        'oth'  => 'application/vnd.oasis.OpenDocument.text-web',
        'odm'  => 'application/vnd.oasis.OpenDocument.text-master',
        'odg'  => 'application/vnd.oasis.OpenDocument.graphics',
        'otg'  => 'application/vnd.oasis.OpenDocument.graphics-template',
        'odp'  => 'application/vnd.oasis.OpenDocument.presentation',
        'otp'  => 'application/vnd.oasis.OpenDocument.presentation-template',
        'ods'  => 'application/vnd.oasis.OpenDocument.spreadsheet',
        'ots'  => 'application/vnd.oasis.OpenDocument.spreadsheet-template',
        'odc'  => 'application/vnd.oasis.OpenDocument.chart',
        'odf'  => 'application/vnd.oasis.OpenDocument.formula',
        'odb'  => 'application/vnd.oasis.OpenDocument.database',
        'odi'  => 'application/vnd.oasis.OpenDocument.image',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
    );


	public function __construct()
	{
		parent::__construct();

		$this->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load OpenTBS plugin
	}

	/**
	 * @param string $filename path for template
	 * @return bool
	 */
	public function templateExists($filename)
	{
		return file_exists($filename);
	}

	/**
	 * @param string $filename
	 */
	public function setTemplate($filename)
	{
        global $mod_strings;

        if (!$this->templateExists($filename))
        {
            die($mod_strings['ERR_TEMPLATE_DONT_EXIST']);
        }

        $this->extension = pathinfo($filename, PATHINFO_EXTENSION);

        $this->LoadTemplate($filename, OPENTBS_ALREADY_UTF8);
        //$this->LoadTemplate($filename, OPENTBS_ALREADY_XML);

        $config = Reports_Utils::get_config();
        if ($config['officeDocxDebugMode'] == true)
        {
            //$this->PlugIn(OPENTBS_DEBUG_INFO);
            $this->PlugIn(OPENTBS_DEBUG_XML_SHOW);
        }
	}

    /**
     * Get the mimetype of the current process file
     *
     * @return string The mimetype
     */
    public function getMimetype()
    {
      return isset($this->mimetype[$this->getExtension()]) ? $this->mimetype[$this->getExtension()] : null;
    }

    /**
     * Get the extension of the current process file
     *
     * @return string The extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    public function getContent()
    {
        return $this->Source;
    }

	/**
	 * create document
	 */
	public function createDocument()
	{
        $this->Show(OPENTBS_STRING);
	}

	/**
	 * @param array $arrBean
	 */
	public function assign($arrBean)
	{
		foreach ($arrBean as $key => $value)
		{
			if (is_array($value))
			{
                //redisign key array to human format
                //can use [block_name.$] operator for get number of element
                $numered_values = array();
                $i = 1;
                foreach ($value as $val)
                {
                    $numered_values[$i] = $val;
                    $i++;
                }
				$this->MergeBlock($key, $numered_values);
			}
			else
			{
				$this->mergeField($key, $value);
			}
		}
	}


}
