<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/DynamicFields/templates/Fields/TemplateText.php');

class TemplateGallery extends TemplateText
{

    var $type = 'gallery';
    var $reportable = false;
    var $importable = 'false';


    function TemplateGallery ()
    {
        $this->vardef_map['width'] = 'ext2';
        $this->vardef_map['height'] = 'ext3';
        $this->vardef_map['turn_on'] = 'ext4';
    }


    function get_db_type()
    {
        if ($GLOBALS['db']->dbType=='oci8')
        {
            return " CLOB ";
        }
        else if(!empty($GLOBALS['db']->isFreeTDS))
        {
            return " NTEXT ";
        }
        else
        {
            return " TEXT ";
        }
    }



    function set($values)
    {
        parent::set($values);

        if(!empty($this->ext2)){
            $this->width = $this->ext2;
        }
        if(!empty($this->ext3)){
            $this->height = $this->ext3;
        }
        if(!empty($this->ext4)){
            $this->turn_on = $this->ext4;
        }
    }



    function get_xtpl_detail()
    {
        $name = $this->name;
        return $this->bean->$name;
    }



    function get_field_def()
    {
        $def = parent::get_field_def();

        $def['dbType'] = 'text';
        $def['massupdate'] = 0;
        $def['importable'] = 0;
        $def['duplicate_merge'] = 0;
        $def['reportable'] = 0;
        //$def['len'] = 1000;
        $def['studio'] = 'visible';


        if ( isset ( $this->ext2 ) && isset ($this->ext3))
        {
            $def[ 'width' ] = $this->ext2 ;
            $def[ 'height' ] = $this->ext3 ;
        }

        if(isset ($this->ext4)) $def[ 'turn_on' ] = $this->ext4;

        if (isset( $this->width ) && isset ($this->height))
        {
            $def[ 'width' ] = $this->width ;
            $def[ 'height' ] = $this->height ;
        }

        if(isset ($this->turn_on))
        {
            $def[ 'turn_on' ] = $this->turn_on ;
        }


        return $def;
    }

    function get_db_default()
    {
        return null;
    }

}


?>
