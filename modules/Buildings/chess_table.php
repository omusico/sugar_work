
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="modules/Buildings/popup.css">
    <script type="text/javascript" src="modules/Buildings/popup_chess_table.js"></script>
    <style>
        .chess_table {

            border-collapse:collapse;
            margin:0px auto;
            /*font-family: Tahoma;*/
            /*font-size: 12px;*/
        }
        .chess_table td{
            border:1px solid black;
            border-collapse:collapse;
        }
        h1 {
            color:#B04500;
        }
        .flats {
            width:60px;
            height:60px;
            background-color: #F5F5F5;
        }
        .floor_class{
            font-size:16px;
            color:black;
            background-color: #B9D3EE;
        }
        .sections{
            background-color: #B9D3EE;
            font-size:16px;
            color:black;
        }
        .popup {
            display:none;
            width:350px;
            /*font:13px normal 'Tahoma';*/
            background:#ecf6ff;
            border:8px solid #A4D3EE;
            position:absolute;
            border-radius: 15px;
            -moz-box-shadow:0 0 5px 5px #708090; /* для Mozilla */
            -webkit-box-shadow:0 0 5px 5px #708090; /* для Webkit */
            box-shadow:0 0 5px 5px #708090;
        }
        .no {
            position:absolute;
            top:0;
            right:0;
        }
        #section_name{
            /*font:18px normal 'Tahoma';*/
            background:#ecf6ff;
            border-bottom:5px solid #A4D3EE;
            width:350px;
            height:25px;
            margin: 0px auto;
            padding-top: 5px;
        }
        .popup_content{
            /*font:14px normal 'Tahoma';*/
            padding: 10px 20px 20px 20px;
            clear: both;

        }
        .div_popup{
            float: left;
            color: #00688B;
            font-weight:bold;
            font-size:16px;
            clear: both;
            border-radius: 10px;
            margin: 0 0 10px 0;
            padding: 5px;
        }
        .button_edit{
            float:left;
            padding: 5px 0 5px 50px;
        }
        .button_view{
            float:right;
            padding: 5px 50px 0 5px;
        }
        .buttons{
            float: left;
            /*font:16px normal 'Tahoma';*/
            border-top:5px solid #A4D3EE;
            width:350px;

        }
        #view {
            background-color: #ecf6ff;
            font-weight:bold;
            color:#00688B;
            display: block;
            padding: 8px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            border: 1px solid black;
        }
        #view:hover {
            background-color: #A4D3EE;
            color: #00688B;
            font-weight: bold;
            cursor: pointer;
        }

        #edit {
            background-color: #ecf6ff;
            font-weight:bold;
            color:#00688B;
            display: block;
            padding: 8px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            border: 1px solid black;
        }
        #edit:hover {
            background-color: #A4D3EE;
            color: #00688B;
            font-weight: bold;
            cursor: pointer;
        }
        a {
            text-decoration: none;
        }

    </style>

    <script type="text/javascript">
        $(document).ready(function(){

            $('.no').click(function(){
                $('.popup').fadeOut('slow');
            });

            $('.show').click(function(e){
                $('.popup').fadeOut('slow');
                var field = $(this).attr('id');
                $('#'+ field).fadeIn('slow');

                var heightW = $('.popup').height();
                var widthW = $('.popup').width();
                console.log(heightW);
                console.log(heightW);

                var Y;
                var X;

                if(e.pageY + heightW > document.body.scrollHeight)
                {
                     Y = document.body.scrollHeight - heightW;
                }
                else {
                     Y = e.pageY;
                }

                if(e.pageX + widthW > document.body.scrollWidth)
                {
                    X = e.pageX - widthW;
                } else {
                    X = e.pageX;
                }
                console.log(window.screenX);

                $('#'+ field).css({
                    'top':Y,
                    'left':X
                });
            });
        });

    </script>




<?php
  global $db;
  $r = $db->query("SELECT id, name FROM realtytemplates WHERE building_id = '{$_REQUEST['record']}' AND deleted = 0");
?>

<!--[if lt IE 9]><div class="popup__overlay popup__overlay_ie"></div><![endif]-->
<div class="popup__overlay">
    <div class="popup2">
        <a href="#" class="popup__close">X</a>
        <h2>Выберите необходимый шаблон!</h2>
        <p id="desc_popup_floor" >  </p>
        <input type="hidden" id="floor_cht" name="floor_cht" />
        <input type="hidden" id="section_cht" name="section_cht" />
        <input type="hidden" id="build_id_cht" name="build_id_cht" value="<?php echo $_REQUEST['record'] ?>" />
        <div class="popup-form__row">
            <label for="popup_form_select">Список шаблонов</label>
            <select id="popup_form_select"  name="popup_form_select" value="" >
                <?php
                while($row = $db->fetchByAssoc($r) ){
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <input type="button" value="Создать по шаблону" id="create_tpl_obj" onclick="create_obj($('#build_id_cht').val(), $('#floor_cht').val(), $('#popup_form_select').val(), $('#section_cht').val())"/>
        &nbsp;<input type="button" value="Создать" id="create_obj"
		onclick="location.href='index.php?module=Realty&action=EditView&floor='+$('#floor_cht').val()+'&building_name='+$('#b_name').text()+'&building_id='+$('#build_id_cht').val()+'&return_action=chess_table&return_id='+$('#build_id_cht').val()+'&return_module=Buildings'"/>
    </div>
    <!--[if lt IE 9]><div class="popup__valignfix"></div><![endif]-->
</div>

<h1>Шахматка 
    <?php

    $building = new Buildings();
    $building->retrieve($_REQUEST['record']);
	echo  "<span id='b_name'>{$building->name}</span></h1>";
	echo '<table border="1" class="chess_table"  cellpadding=0>';
	
    $sec = $building->get_linked_beans('buildings_sections', 'Sections');

    if(count($sec) > 0)
    {
        $sections = $sec;
        $floors_quantity = $building->number_of_floors;

        echo "<tr>";

        foreach ($sections as $section)
        {
            $colspan = $section->flats_quantity;
            echo "<td class='floor_class' align='center' width='50px' height='50px' padding='6px' ><b>Этаж<b></td>
			   <td class='sections' align='center' height='50px' padding='6px' colspan='{$colspan}'><b>{$section->name}</b></td>";
        }
        echo "</tr>";

        $floor = $floors_quantity;
        for($i=0; $i<$floors_quantity; $i++)
        {
            echo "<tr>";
            foreach ($sections as $section)
            {
                $realty_list = $section->get_linked_beans('realty_sections', 'Realty');
                echo "<td class='floor_class' align='center' width='50px' height='50px' padding='6px'><b>{$floor}</b></td>";

                $counter = $section->flats_quantity;

                for($k=0; $k < count($realty_list); $k++)
                {
                    if($floor == $realty_list[$k]->floor)
                    {
                        if($realty_list[$k]->operation == 'rent' && $realty_list[$k]->operation_status == 'in_rent')
                        {
                            $bg_color = 'yellow';
                        }
                        elseif($realty_list[$k]->operation == 'buying' && $realty_list[$k]->operation_status == 'bought')
                        {
                            $bg_color = '#e66c6c';
                        } else{
                            $bg_color = '#a8dc8e';
                        }

                        $realty_type = "";
                        if($realty_list[$k]->type_of_realty == "living")
                        {
                            $realty_type = "Жилая";
                        }
                        elseif($realty_list[$k]->type_of_realty == "not_living")
                        {
                            $realty_type = "Не жилая";
                        }
                        elseif($realty_list[$k]->type_of_realty == "parcel")
                        {
                            $realty_type = "Земельный участок";
                        }


                        $realty_kind = "";
                        if($realty_list[$k]->kind_of_realty == "flat")
                        {
                            $realty_kind = "Квартира";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "room")
                        {
                            $realty_kind = "Комната";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "house")
                        {
                            $realty_kind = "Дом";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "stock")
                        {
                            $realty_kind = "Склад";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "office")
                        {
                            $realty_kind = "Офис";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "parcel")
                        {
                            $realty_kind = "Земельный участок";
                        }


                        $operation = "";
                        if($realty_list[$k]->operation == "rent")
                        {
                            $operation = "Аренда";
                        }
                        elseif($realty_list[$k]->operation == "buying")
                        {
                            $operation = "Продажа";
                        }

                        echo "<div class='popup' id='{$realty_list[$k]->id}' align='center'>
                    <div id='section_name'>{$realty_list[$k]->name}</div>
                    <b>Краткая информация об объекте</b>
                    <div class='popup_content'>

                    <div class='div_popup'>Операция:&nbsp;{$operation}</div>

                    <div class='div_popup'>Тип недвижимости:&nbsp;{$realty_type}</div>

                    <div class='div_popup'>Вид недвижимости:&nbsp;{$realty_kind}</div>

                    <div class='div_popup'>Площадь:&nbsp;{$realty_list[$k]->square}</div>

                    <div class='div_popup'>Итоговая стоимость:&nbsp;{$realty_list[$k]->totalcost}</div>

                    <div class='div_popup'>Адрес:&nbsp;{$realty_list[$k]->address_country} {$realty_list[$k]->address_city} {$realty_list[$k]->address_street} {$realty_list[$k]->address_house}</div>

                    </div>

                    <div class='buttons'>
                    <div class='button_view'><a href='index.php?module=Realty&action=DetailView&record={$realty_list[$k]->id}' target='_blank' id='view'>Просмотреть</a></div>
                    <div class='button_edit'><a href='index.php?module=Realty&action=EditView&record={$realty_list[$k]->id}' target='_blank' id='edit'>Редактировать</a></div>
                    </div>

                    <img src='modules/Buildings/img/close.png' class='subm no'>
                    <div class='for_height'><span class='error error_del'></span></div>
                    </div>";

                        echo "<td class='flats' align='center' style='background-color: {$bg_color}'>
                    <a href='#' class='show' id='{$realty_list[$k]->id}' style='text-decoration: none;' onclick='return false;'>{$realty_list[$k]->name}</a>
                    </td>";
                        $counter--;
                    }
                }

                for($j=0; $j<$counter; $j++)
                {
                    echo "<td class='flats' align='center'>
                <a style='text-decoration: none;' class='popup__toggle' href='#' onclick='openPopupWin(\"{$floor}\", \"{$section->id}\"); return false;' >
                Создать
                </a>
                </td>";
                }

            }
            echo "</tr>";
            $floor--;
        }
    }
    else {

        $floors_quantity = $building->number_of_floors;

        echo "<tr>";
            $colspan = $building->flats_quantity;
            echo "<td class='floor_class' align='center' width='50px' height='50px' padding='6px' ><b>Этаж<b></td>
			   <td class='sections' align='center' height='50px' padding='6px' colspan='{$colspan}'><b>{$building->name}</b></td>";
                echo "</tr>";

        $floor = $floors_quantity;
        for($i=0; $i<$floors_quantity; $i++)
        {
            echo "<tr>";
                $realty_list = $building->get_linked_beans('realty_buildings', 'Realty');
                echo "<td class='floor_class' align='center' width='50px' height='50px' padding='6px'><b>{$floor}</b></td>";

                $counter = $building->flats_quantity;

                for($k=0; $k < count($realty_list); $k++)
                {
                    if($floor == $realty_list[$k]->floor)
                    {
                        if($realty_list[$k]->operation == 'rent' && $realty_list[$k]->operation_status == 'in_rent')
                        {
                            $bg_color = 'yellow';
                        }
                        elseif($realty_list[$k]->operation == 'buying' && $realty_list[$k]->operation_status == 'bought')
                        {
                            $bg_color = '#e66c6c';
                        } else{
                            $bg_color = '#a8dc8e';
                        }

                        $realty_type = "";
                        if($realty_list[$k]->type_of_realty == "living")
                        {
                            $realty_type = "Жилая";
                        }
                        elseif($realty_list[$k]->type_of_realty == "not_living")
                        {
                            $realty_type = "Не жилая";
                        }
                        elseif($realty_list[$k]->type_of_realty == "parcel")
                        {
                            $realty_type = "Земельный участок";
                        }


                        $realty_kind = "";
                        if($realty_list[$k]->kind_of_realty == "flat")
                        {
                            $realty_kind = "Квартира";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "room")
                        {
                            $realty_kind = "Комната";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "house")
                        {
                            $realty_kind = "Дом";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "stock")
                        {
                            $realty_kind = "Склад";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "office")
                        {
                            $realty_kind = "Офис";
                        }
                        elseif($realty_list[$k]->kind_of_realty == "parcel")
                        {
                            $realty_kind = "Земельный участок";
                        }


                        $operation = "";
                        if($realty_list[$k]->operation == "rent")
                        {
                            $operation = "Аренда";
                        }
                        elseif($realty_list[$k]->operation == "buying")
                        {
                            $operation = "Продажа";
                        }

                        echo "<div class='popup' id='{$realty_list[$k]->id}' align='center'>
                    <div id='section_name'>{$realty_list[$k]->name}</div>
                    <b>Краткая информация об объекте</b>
                    <div class='popup_content'>

                    <div class='div_popup'>Операция:&nbsp;{$operation}</div>

                    <div class='div_popup'>Тип недвижимости:&nbsp;{$realty_type}</div>

                    <div class='div_popup'>Вид недвижимости:&nbsp;{$realty_kind}</div>

                    <div class='div_popup'>Площадь:&nbsp;{$realty_list[$k]->square}</div>

                    <div class='div_popup'>Итоговая стоимость:&nbsp;{$realty_list[$k]->totalcost}</div>

                    <div class='div_popup'>Адрес:&nbsp;{$realty_list[$k]->address_country} {$realty_list[$k]->address_city} {$realty_list[$k]->address_street} {$realty_list[$k]->address_house}</div>

                    </div>

                    <div class='buttons'>
                    <div class='button_view'><a href='index.php?module=Realty&action=DetailView&record={$realty_list[$k]->id}' target='_blank' id='view'>Просмотреть</a></div>
                    <div class='button_edit'><a href='index.php?module=Realty&action=EditView&record={$realty_list[$k]->id}' target='_blank' id='edit'>Редактировать</a></div>
                    </div>

                    <img src='modules/Buildings/img/close.png' class='subm no'>
                    <div class='for_height'><span class='error error_del'></span></div>
                    </div>";

                        echo "<td class='flats' align='center' style='background-color: {$bg_color}'>
                    <a href='#' class='show' id='{$realty_list[$k]->id}' style='text-decoration: none;' onclick='return false;'>{$realty_list[$k]->name}</a>
                    </td>";
                        $counter--;
                    }
                }

                for($j=0; $j<$counter; $j++)
                {
                    echo "<td class='flats' align='center'>
                <a style='text-decoration: none;' href='#' class='popup__toggle' onclick='openPopupWin(\"{$floor}\", \"\"); return false;'>
                Создать
                </a>
                </td>";
                }
            echo "</tr>";
            $floor--;
        }
    }
    ?>

</table>

