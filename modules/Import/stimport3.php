<?php
header('Content-type: text/html; charset=utf-8');
echo "<script src='modules/Import/importajax.js'></script>";
$data = html_entity_decode ($_REQUEST['imported']);
$data = json_decode($data,1,4096);

?>
<div class="success">
    <input type="button" onclick="sql_backup()" value="Откатить изменения" class="fsSubmitButton">
    <h4 style="color:#F8003B;">Если закроите данную страницу, то отменить текущую загрузку будет невозможно!</h4><br/>
    <h3>Импорт успешно завершен</h3><br/>
    
    <h4>Обновлены:</h4>
    <br/>
    <?php 
    //TODO Название модулей перевести
    // Сделать нормальный внешний вид
    foreach ($data['success_updated'] as $module_name => $objects)
    {
        $translated = $app_list_strings['moduleList'][$module_name]; 
        
        echo '<br/><span class="expand"><b>Модуль '.$translated.'. Загружено '.count($objects).' объектов (Нажмите для просмотра деталей)</b><br/></span>';
        echo '<ul class="jlevel">';
        foreach ($objects as $object)
        {
            echo "<li>";
            //echo "<a href='index.php?module={$module_name}&action=DetailView&record={$object['result']['id']}'>".(($object['result']['name'])?($object['result']['name']):($object['result']['last_name']." ".$object['result']['first_name']))."</a><br/>";
            if($module_name == 'Contacts' || $module_name== 'Leads')
            {
                $name = $object['result']['last_name'].' '.$object['result']['first_name'];
            }
            else
            {
                $name = $object['result']['name'];
            }
            echo "<a href='index.php?module={$module_name}&action=DetailView&record={$object['result']['id']}'>{$name}</a><br/>";
            echo "</li>";
        }
        echo '</ul>';
    }
    ?>
    <br/>
    <h4>Добавлены:</h4>
    <br/>
    <?php 
    //TODO Название модулей перевести
    // Сделать нормальный внешний вид
    foreach ($data['success_inserted'] as $module_name => $objects)
    {
        $translated = $app_list_strings['moduleList'][$module_name]; 
        echo '<br/><span class="expand"><b>Модуль '.$translated.'. Загружено '.count($objects).' объектов (Нажмите для просмотра деталей)</b><br/></span>';
        echo '<ul class="jlevel">';
        foreach ($objects as $object)
        {
            echo "<li>";
            if($module_name == 'Contacts' || $module_name== 'Leads')
            {
                $name = $object['last_name'].' '.$object['first_name'];
            }
            else
            {
                $name = $object['name'];
            }
            echo "<a href='index.php?module={$module_name}&action=DetailView&record={$object['id']}'>{$name}</a><br/>";
            echo "</li>";
        }
        echo '</ul>';
    }
    ?>
    <br/>
    <?php 
    if(count($data['failure']) > 0)
    {
        echo ' <h4>Ошибка импорта в:</h4><br/>';
        foreach ($data['failure'] as $module_name => $objects)
        {
            $translated = $app_list_strings['moduleList'][$module_name]; 
            echo '<br/>Модуль '.$translated.': <br/>';
            echo count($objects)." объектов";
        }
    }
    
    ?>
</div>
<style>.success {font: 110% sans-serif; color: black; padding:2px 5px 2px 5px;}</style>
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
.fsSubmitButton
{
    padding: 10px 20px 11px !important;
    font-size: 21px !important;
    background-color: #F8003B;
    font-weight: bold;
    text-shadow: 1px 1px #F8003B;
    color: #ffffff;
    border-radius: 100px;
    -moz-border-radius: 100px;
    -webkit-border-radius: 100px;
    border: 1px solid #F8003B;
    cursor: pointer;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
    -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
}
.expand
{
    cursor: pointer;
}
</style> 