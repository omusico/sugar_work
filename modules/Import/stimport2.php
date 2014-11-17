<?php
header('Content-type: text/html; charset=utf-8');
echo "<script src='modules/Import/stimport.js'></script>";

global $sugar_config, $current_user, $moduleList;
$upload_dir = $sugar_config['upload_dir'];
$file_name = 'importer_' . time() . '.csv';

if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_dir . $file_name)) 
{
    SugarApplication::redirect("index.php?module=Import&action=stimport1");
}
else
{
    $str ="";
    $f = fopen($upload_dir . $file_name, "r");
    echo '<input type="hidden" id="delimiter" value="' . $_REQUEST['delimiter'] . '"></input>';
    echo '<input type="hidden" id="encode" value="' . $_REQUEST['encode'] . '"></input>';
    //$str .= '<option value=""></option>';

    $unwanted_modules = array(
        'Home',
        'Calendar',
        'Emails',
        'ProspectLists',
        'Documents',
        'Project',
        'Bugs'
    );

    foreach ($moduleList as $module) 
    {
        if ((isset($GLOBALS['app_list_strings']['moduleList'][$module]))
             && !in_array($module, $unwanted_modules))
        {
            $str .= '<option value="' 
            . $module 
            . '">' 
            . $GLOBALS['app_list_strings']['moduleList'][$module] 
            . '</option>';
        } 
    }
    $str .= '</select>';
    $blank_select = '<option value=""></option></select>';

    echo '<hr>Выберите модуль для импорта: '
    . '<select id="modules_main" onchange="get_modules($(\'#modules_main\').val())">'
    . $str 
    . 'Тип импорта:'
    . '<select id="import_type">'
    . '<option value="create">Создавать новые объекты</option>'
    . '<option value="update">Обновлять объекты</option>'
    . '<option value="mixed">Смешанный тип</option>'
    . '</select>' 
    . '    <button onclick="do_import(\'' . $upload_dir . $file_name . '\')">Начать импорт</button><hr>';

    $first = true;
    //////формирование таблицы
    echo "<html><body><table class='table_csv'>\n\n";
    $lines = 0;
    $encode_detected = false;
    $delimiter = $_REQUEST['delimiter'];
    $encode = $_REQUEST['encode'];
    $delimiter = ($delimiter == 'tab')?("\t"):($delimiter);

    //$file = fopen ("http://www.example.com/", "r");
 

    
    /* Сработает, только если заголовок и сопутствующие теги расположены в одной строке */

    //while (($line = fgetcsv($f, 0, $delimiter)) !== false) 
    while (!feof ($f))
    { 
        $lin = fgets ($f, 2048);
        $line = explode($delimiter, $lin);
        echo "<tr>";
        $i = 0;

        foreach ($line as $cell) 
        { 
            //echo $cell;
            if($encode == 'Windows-1251')
            {
                //$cell = mb_convert_encoding($cell, 'utf-8', $encode);
                $cell =  iconv ('CP1251', 'utf-8',$cell);
            }
            if ($first) 
            {
                echo "<td class='csv_head' id='td_csv_head" . $i . "' >" 
                . "<div style='width:190px;'>"
                . htmlspecialchars($cell) 
                . '</br><select id="td_csv_modules' . $i . '" class="td_csv_modules" onchange="get_submodules($(\'#td_csv_modules' . $i . '\').val(), ' . $i . ')" style="width:190px;">' 
                . $blank_select // </select>
                . '</br><select id="td_csv_fields' . $i . '" class="td_csv_fields" style="width:190px;"><option value=""></option></select>'
                . '</br><span>Загружать это поле<input type="checkbox" id="td_csv_upload' . $i . '" class="td_csv_upload" checked></span>'
                . '</br><span>Искать по этому полю<input type="checkbox" id="td_csv_search' . $i . '" class="td_csv_search"></span>'
                . '<br/><select id="search_func' . $i . '" class="search_func"><option value="eq">=</option><option value="like">LIKE %...%</option></select>'        
                . '<br/>'
                    . '<select id="string_func' . $i . '" class="string_func" data-num="' . $i . '">'
                        . '<option value="no_func"></option>'
                        . '<option value="add">+</option>'
                        . '<option value="subtract">-</option>'
                        . '<option value="multiply">*</option>'
                        . '<option value="div">/</option>'
                        . '<option value="concat">Дописать текст</option>'
                    . '</select>'
                . '<br/><div id="string_func_div' . $i . '" class="string_func_div"></div>' 
                . "</div></td>";
            }
            else 
            {
                echo "<td class='td_csv'>" . htmlspecialchars($cell) . "</td>";
            }
            $i++;
        }
        $first = false;
        echo "</tr>\n";
        $lines++;
        if($lines==5)
        {
            break;
        }
    }
    echo "\n</table><br/></body></html><style>.table_csv, .td_csv {font: 110% sans-serif; border: 1px solid black; border-collapse: collapse;padding:10px 5px 10px 5px;} table.table_csv td#csv_head {font: bold 110% sans-serif; border: 1px solid black; border-collapse: collapse;padding:2px 5px 2px 5px;}</style>";
    //////конец таблицы
    fclose($f);
    ////////закрытие файла
    echo 'File: ' . $upload_dir . $file_name;
    
    echo "<div id='module_order'></div>";
    echo "<div id='additional_relationships'></div>";
    echo "<div id='alternative_relationships'></div>";
    echo "<form style='display: none' action='index.php?module=Import&action=stimport3' method='POST' id='submit_form'>"
         ."<textarea style='display: none' name='imported' id='imported'></textarea>"
         ."</form>";
    //unlink ($upload_dir . $file_name);
}

?>
<div class="b-container" style="display: none;">
    Sample Text
</div>
<div id = "b-popup" class="b-popup" style="display: none;">
    <div class="b-popup-content">
        Подождите, идёт загрузка
    </div>
</div>

<style type="text/css">

.b-container{
    width:200px;
    height:150px;
    background-color: #ccc;
    margin:0px auto;
    padding:10px;
    font-size:30px;
    color: #fff;
}
.b-popup{
    width:100%;
    height: 2000px;
    background-color: rgba(0,0,0,0.5);
    overflow:hidden;
    position:fixed;
    top:0px;
}
.b-popup .b-popup-content{
    margin:40px auto 0px auto;
    width:100px;
    height: 40px;
    padding:10px;
    background-color: #c5c5c5;
    border-radius:5px;
    box-shadow: 0px 0px 10px #000;
}

</style> 