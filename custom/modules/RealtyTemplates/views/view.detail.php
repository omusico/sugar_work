<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/MVC/View/views/view.detail.php');

class RealtyTemplatesViewDetail extends ViewDetail
{
 	public function display()
 	{
            //global $current_user;
            
            parent::display();
            echo("<script src='custom/include/javascript/ajaxButton.js'></script>");
 	}

    public function getMetaDataFile()
    {
        parent::getMetaDataFile();

        global $current_user;

        if ($this->bean->realty_status == 'realtor' && $current_user->id != $this->bean->assigned_user_id)
        {
            $getMetaDataFile = 'custom/modules/RealtyTemplates/metadata/detailviewdefsTypeRealtor.php';
        }
        else
        {
            $getMetaDataFile = 'custom/modules/RealtyTemplates/metadata/detailviewdefs.php';
        }

        return $getMetaDataFile;
    }
}
