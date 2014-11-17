<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/MVC/View/views/view.detail.php');

class RealtyViewDetail extends ViewDetail
{
 	public function display()
 	{
            //global $current_user;
            parent::display();
            echo("<script src='custom/include/javascript/ajaxButton.js'></script>");
            echo "<input title='Отправить презентацию' class='button' onclick='window.open(\"index.php?module=Realty&action=generate_presentation_from_application&id={$_REQUEST['record']}\")' value='Отправить презентацию' type='button'>";
            echo "
            <style>
                ._realty_interests_{
                    background-color:#fff;
                    border:1px solid #222;
                    width:250px;
                    padding:1px;
                    margin:0px;
                }
                ._realty_interests_ li{
                    padding:2px;
                    margin:0px;
                }
                ._realty_interests_ li:hover{
                    background-color:#24D;
                    color:#fff;
                }
            </style>";
 	}

    public function getMetaDataFile()
    {
        parent::getMetaDataFile();

        global $current_user;

        if ($this->bean->realty_status == 'realtor' && $current_user->id != $this->bean->assigned_user_id)
        {
            //$getMetaDataFile = 'custom/modules/Realty/metadata/detailviewdefsTypeRealtor.php';
            $getMetaDataFile = 'custom/modules/Realty/metadata/detailviewdefs.php';
        }
        else
        {
            $getMetaDataFile = 'custom/modules/Realty/metadata/detailviewdefs.php';
        }

        return $getMetaDataFile;
    }
}
