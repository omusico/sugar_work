<?php

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldGallery extends SugarFieldBase
{


    function __construct($type)
    {
        parent::SugarFieldBase($type);
    }



    public function formatField($rawField, $vardef)
    {
        if (empty($rawField)) return $rawField;

        $fields = explode('^|^', $rawField);

        $params = array('', '');

        foreach($fields as $field)
        {
            $params = explode('^,^', $field);
        }
        return $params[1];
    }






    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $position =0;

        $fields = explode('^|^', $vardef['value']);
        $params = array();
        foreach($fields as $key => $field)
        {
            if(strpos($field,'^main^') !== FALSE)
            {
                $position = $key;
                break;
            }

        }

        $this->ss->assign('position', $position);

        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch('include/SugarFields/Fields/Gallery/DetailView.tpl');
    }


    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        global $module;
        $a=5;
        $this->ss->assign('module_name', $module);
        $this->ss->assign('record_id', $_REQUEST['record']);
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch('include/SugarFields/Fields/Gallery/EditView.tpl');
    }


    function getSearchViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);
        return $this->fetch('include/SugarFields/Fields/Gallery/SearchView.tpl');
    }







    public function save(&$bean, $params, $field, $properties, $prefix = '')
    {
        global $module;
        
        if ($_REQUEST['action'] == 'MassUpdate')
        {
            return;
        }
        $prefix = $module . 'imageFlag';
        $images = array();

        $upload_path = 'upload/gallery_images/';

        /**
         * bagfix
         */
        if( (!isset($bean->id) || empty($bean->id)) && isset($params['new_with_id']) && !empty($params['new_with_id']) ){
            $params['record'] = $params['new_with_id'];
            $params['duplicateSave'] = "false";
            $_REQUEST['duplicateSave'] = "false";

        }

        $upload_path_with_id = $upload_path . $params['record'] . '/'; //определение директории

        $temp_images = array();


        foreach ($params as $key => $val)
        {



            if (strpos($key, $prefix . '0_') === 0) //заголовок
            {
//                $new_key = 0;
//
//                if(substr($key, -3) === 'KEY')
//                {
//                    $new_key = $params[$key];
//                }

                $new_key = intval(str_replace($prefix . '0_', '', $key));

                $images[$new_key]['title'] = $val;
            }

            if (strpos($key, $prefix . '1_') === 0) //загружаем старые данные
            {
                $new_key = intval(str_replace($prefix . '1_', '', $key));

                if (empty($val)) //старого значения нет, проверим потом есть ли новое
                {
                    continue;
                }

                $images[$new_key]['path'] = $val;

                $temp_images[] = $val;
            }

        }




        foreach ($params as $key => $val)
        {
            if (strpos($key, $prefix . '2_') === 0)
            {
                $new_key = intval(str_replace($prefix . '2_', '', $key));

                if (empty($val))
                {
                    if ($images[$new_key]['path'] == '') {
                        unset($images[$new_key]);
                        continue;
                    }
                }

                else {
                    $images[$new_key]['path'] = $val;
                    $temp_images[] = $val;
                }
            }
        }



        // foreach ($params as $key => $val)
        // {
            // if (strpos($key, $prefix . '3_') === 0) //заголовок
            // {
                // $new_key = intval(str_replace($prefix . '3_', '', $key));

                // $images[$new_key]['x'] = $val;
            // }

            // if (strpos($key, $prefix . '4_') === 0) //заголовок
            // {
                // $new_key = intval(str_replace($prefix . '4_', '', $key));

                // $images[$new_key]['y'] = $val;
            // }

            // if (strpos($key, $prefix . '5_') === 0) //заголовок
            // {
                // $new_key = intval(str_replace($prefix . '5_', '', $key));

                // $images[$new_key]['w'] = $val;
            // }

            // if (strpos($key, $prefix . '6_') === 0) //заголовок
            // {
                // $new_key = intval(str_replace($prefix . '6_', '', $key));

                // $images[$new_key]['h'] = $val;
            // }

            // if (intval(str_replace($prefix . '0_', '', $key)) == $params['main_pos'])
            // {
                // $images[$params['main_pos']]['main'] = 'main';
            // } else {
                // if (strpos($key, $prefix . '6_') === 0 and (intval(str_replace($prefix . '6_', '', $key)) != $params['main_pos']))
                // {
                    // $new_key = intval(str_replace($prefix . '6_', '', $key));

                    // $images[$new_key]['main'] = '';
                // }
            // }

        // }
		$my_flags=array();//kolerts

        foreach ($params as $key => $val) // kolerts rewrite
        {
			switch(substr($key, 0, strpos($key, '_')))
			{
				case $prefix . '3':
					$new_key = intval(str_replace($prefix . '3_', '', $key));
					$images[$new_key]['x'] = $val;
				break;
				case $prefix . '4':
					$new_key = intval(str_replace($prefix . '4_', '', $key));
					$images[$new_key]['y'] = $val;
				break;
				case $prefix . '5':
					$new_key = intval(str_replace($prefix . '5_', '', $key));
					$images[$new_key]['w'] = $val;
				break;
				case $prefix . '6':
					$new_key = intval(str_replace($prefix . '6_', '', $key));
					$images[$new_key]['h'] = $val;
				break;

				case $prefix . '7':
					$new_key = intval(str_replace($prefix . '7_', '', $key));
					$my_flags[$new_key]['n'] = $val;
				break;
			}

			if (intval(str_replace($prefix . '0_', '', $key)) == $params['main_pos'])
            {
                $images[$params['main_pos']]['main'] = 'main';
            } else {
                if (strpos($key, $prefix . '6_') === 0 and (intval(str_replace($prefix . '6_', '', $key)) != $params['main_pos']))
                {
                    $new_key = intval(str_replace($prefix . '6_', '', $key));

                    $images[$new_key]['main'] = '';
                }
            }
        }
	//kolerts - fix of empty entryes
	//$count_im=count(array_keys($images));
	//for($i=0;$i<$count_im;$i++)
	foreach(array_keys($images) as $i)
	{
		if(!isset($images[$i]['y']))
			$images[$i]['y']='';
		if(!isset($images[$i]['x']))
			$images[$i]['x']='';
		if(!isset($images[$i]['w']))
			$images[$i]['w']='';
		if(!isset($images[$i]['h']))
			$images[$i]['h']='';

		if(!isset($images[$i]['main']))
			$images[$i]['main']='';

		if(!isset($my_flags[$i]['n']))
			$images[$i]['n']='off';
		else
			$images[$i]['n']=$my_flags[$i]['n'];

	}



        $old_values = $bean -> fetched_row[$field]; //проверка на удаление ненужных файлов
        $old_values = explode('^|^', $old_values);

        foreach($old_values as $key => $old_val)
        {
            $old_val = explode('^,^', $old_val);

            if(!in_array($old_val[1], $temp_images) && is_file($upload_path_with_id . $old_val[1])  && $old_val != '')
            {
                if (is_file($upload_path_with_id . $old_val[1])) {
                    unlink($upload_path_with_id . $old_val[1]);
                }
            }
        }



        if (!empty($images) &&  $_REQUEST['duplicateSave'] != 'true') {
            foreach ($images as $key => $val)
            {
                if(!is_file($upload_path_with_id . $val['path']) && $val != '') {
                    unset($images[$key]);
                }
            }
        }


        $a=5;

        if (!empty($images) &&  $_REQUEST['duplicateSave'] != 'true')
        {
            $ext_image = array();
            foreach($images as $key=>$val)
            {
                //iluxovi4 SORTING
                $params_key = "KEY_" . $key;
                $key_to_sort = $params[$params_key];

                if (!empty($key_to_sort))
                {
                    $ext_image[$key_to_sort] = join('^,^', $val);
                }
                else {
                    $ext_image[] = join('^,^', $val);
                }
            }
            ksort($ext_image);
            $bean -> $field = join('^|^', $ext_image);
        }
        else
        {
            $bean -> $field = '';
        }
    }


}