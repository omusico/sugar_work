<?PHP
$fields = json_decode(htmlspecialchars_decode($_GET['data']['param'])); // Получаем сериаллизованный массив

require_once("custom/modules/XlsExport/Classes/PHPExcel.php");
require_once("include/database/DBManagerFactory.php");
set_time_limit(600);
ini_set('memory_limit', '1024M');

global $app_list_strings, $current_user;
// Start preparing data from SugarCRM
$db = DBManagerFactory::getInstance();

$data = array();
$sql_ids = "";
$sql_fields = array();
$sql_module = "";

$sheetData = array();

foreach ($fields as $field)
{


    if ($field[0] == 'module') // Получаем имя модуля в нижнем регистре
    {
        $module_name = $field[1];
        $sql_module = mb_strtolower($field[1]);
    }
    elseif ($field[0] == 'records') // Получаем список ID записей и преобразуем в формат для чтения MySQL
    {
        $ids = explode(",", $field[1]);
        foreach($ids as $id)
        {
            $sql_ids .= "'" . $id . "',";
        }
    }
    else {
        $sheetData['cols'][] = $field[0]; // Получаем список заголовков для столбцов документа
        $sql_fields[] = $field[1];
    }
}

//$sql_fields = trim($sql_fields, ","); // Убираем последние запятые
$sql_ids = trim($sql_ids, ","); // Убираем последние запятые

$filename = 'upload/' . $sql_module . '.xls';

$focus = BeanFactory::getBean($module_name);

$where = "";
if($_GET['all_list'] == 0)
{
    $where = "{$sql_module}.id IN ({$sql_ids})";
}

if(is_subclass_of($focus, "SugarBean") && !$current_user->is_admin) {
    if($focus->bean_implements('ACL')) {
        if(!ACLController::checkAccess($focus->module_dir, 'export', false)) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= "{$sql_module}.assigned_user_id = '" . $current_user->id . "'";
        }
    }
}

$query = $focus->create_new_list_query("", $where, $sql_fields, array(), 0, '', false, $focus, true, true);

$result = $db->query($query);

$data = array();

while($row = $db->fetchByAssoc($result))
{
    $data[] = $row;
}

$data_fields = $sql_fields;

$sheetData['data'] = array();

foreach($data as $item)
{
    $fields = array();

    foreach ($data_fields as $field_name)
    {
        $fields[] = getStandartField($focus, $field_name, $item[$field_name]);
    }
    $sheetData['data'][] = $fields;
}

// Caching must be enabled/configured before you load or instantiate any PHPExcel object
$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
$cacheSettings = array('cacheTime' => 600, 'memoryCacheSize' => '1024MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
$objPHPExcel = new PHPExcel();
$width = 0;
$height = 0;

$header = array();
$footer = array();

$type = "Excel";
$file_extension = ".xls";

$objPHPExcel->setActiveSheetIndex(0);

$styleArray = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFFFF')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    ),
    'wrap' => true,
    'indent' => 5,
);

$boldFont = array(
    'font'=>array(
        'name'=>'Arial Cyr',
        'size'=>'10',
        'bold'=>true
    )
);

$center = array(
    'alignment'=>array(
        'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$notBoldFont = array(
    'font'=>array(
        'name'=>'Arial Cyr',
        'size'=>'10',
        'bold'=>false
    )
);

$center_vertical = array(
    'alignment'=>array(
        'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
// Get letter
function getLetter($num)
{
    $Abc = array(
        'A','B','C','D','E','F',
        'G','H','I','J','K','L',
        'M','N','O','P','Q','R',
        'S','T','U','V','W','X',
        'Y','Z','AA','AB','AC','AD',
        'AE','AF','AG','AH','AI','AJ',
        'AK','AL','AM','AN','AO','AP',
        'AQ','AR','AS','AT','AU','AV',
        'AW','AX','AY','AZ','BA','BB',
        'BC','BD','BE','BF','BG','BH',
        'BI','BJ','BK','BL','BM','BN',
        'BO','BP','BQ','BR','BS','BT',
        'BU','BV','BW','BX','BY','BZ',
    );
    return $Abc[$num - 1];
}

$letter_num = count($sheetData['cols']);
$letter = getLetter($letter_num);

//Adding Columns Names
$columnLetter = 'A';
foreach($sheetData['cols'] as $colIndex => $colDef)
{
    $cl = $columnLetter++;

    $objPHPExcel->getActiveSheet()->getColumnDimension($cl)->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->getCell($cl . '1')->setValue($colDef);

    $objPHPExcel->getActiveSheet()->getStyle('A1:'. $letter .'1')->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()->getStyle('A1:'. $letter .'1')->applyFromArray($boldFont);

    $objPHPExcel->getActiveSheet()->getStyle('A1:'. $letter .'1')->applyFromArray($center);
}

$currentRow = 2;

//Adding data rows
foreach($sheetData['data'] as $rowIndex => $row)
{
    $columnLetter = 'A';
    foreach($row as $colIndex => $colValue)
    {
        $colValue = trim(html_entity_decode($colValue, ENT_QUOTES));
        $order = array("\r\n", "\n", "\r");
        $colValue = str_replace($order, ' ', $colValue);

        $objPHPExcel->getActiveSheet()->getCell($columnLetter . $currentRow)->setValue($colValue);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow . ":" . $letter . $currentRow)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow . ":" . $letter . $currentRow)->applyFromArray($notBoldFont);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$currentRow . ":" . $letter . $currentRow)->applyFromArray($center_vertical);
        $columnLetter++;
    }
    $currentRow++;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($filename);

$filename_arr['result'] = $filename;

echo json_encode($filename_arr);

function getStandartField($bean, $field_name, $field_value)
{
    global $app_list_strings, $mod_strings;
    global $timedate, $current_user;

    if (isset($bean->field_defs[$field_name]['type'])) //check for special type
    {
        $target_type = $bean->field_defs[$field_name]['type'];
        if ($target_type == 'bool')
        {
            if ($field_value == true)
                return 'Да';
            else
                return 'Нет';
        }
        elseif ($target_type == "datetime" || $target_type == "date")
        {
             if (!empty($field_value))
             {
                 if ($target_type == "datetime")
                    return $timedate->to_display_date_time($field_value, TRUE, TRUE, $current_user);
                 else
                     return $timedate->to_display_date($field_value, TRUE, TRUE, $current_user);
             }
             else
             {
                 return '';
             }
        }
        elseif ($target_type == "enum" OR $target_type == "multienum")
        {
            if (!empty($bean->field_defs[$field_name]['options']))
            {
                $option_array_name = $bean->field_defs[$field_name]['options'];
            }
            else
            {
                return $field_value;
            }

            if ($target_type == "multienum")
            {
                $field_value = trim($field_value, '^');
                $items = explode("^,^", $field_value);
                $vals = array();
                foreach($items as $item) {
                    if (!empty($app_list_strings[$option_array_name][$item]))
                    {
                        $vals[] = $app_list_strings[$option_array_name][$item];
                    }
                    else
                    {
                        $vals[] = $field_value;
                    }
                }
                return implode(", ", $vals);
            }
            elseif (!empty($app_list_strings[$option_array_name][$field_value]))
            {
                return $app_list_strings[$option_array_name][$field_value];
            }
            else
            {
                return $field_value;
            }
        }
    }
    return $field_value;
}
