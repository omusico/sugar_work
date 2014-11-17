<?php
global $sugar_config, $db, $timedate;
$current_date = date('Y-m-d H:i');
?>

<style>
    .CallCenterTable td{
        border: 1px solid black;
        padding: 3px;
        margin: 0;
        width: 80px;
        text-align: center;
    }
    .CallCenterResultTable td{
        border: 1px solid black;
        padding: 3px;
        margin: 0;
        width: 160px;
        text-align: center;
    }
    .CallCenterTable, .CallCenterResultTable{
        border: 1px solid black;
    }
    .headerTR td{
        background-color: #ff0;
    }

    #parameterHeader{
        margin:0 auto;
        width: 1000px;
    }
</style>
<script src="custom/modules/ZuckerReports/js/htmlReports.js" type="text/javascript"></script>
<script src="include/javascript/jquery/jscharts.js" type="text/javascript"></script>

<table id="parameterHeader" align="left">
    <tr style="height:15px;">
        <td class="td-form";>
            <span>Отчёт:</span>  
        </td> 
        <td class="td-form";>
            <span id="list_label";></span>
        </td> 
        <td class="td-form";>
            <span>Период с:</span>  
        </td>
        <td class="td-form";>
             <span>Период по:</span>       
        </td>  
        <td class="td-form";>                    
        </td>    
    </tr>
    <tr style="height:75px;">
        <td class="td-form"; style="vertical-align:top;">
            <span style="top:0px;" >
                <select id="reports" tabindex="0" size="1">
                <option value="0"></option>
                <option value="1">Отчет по результатам работы</option>
                <option value="2">Отчет по рекламным источникам</option>
                </select>
            </span>    
        </td>
        <td class="td-form"; style="width:275px;">
            <span id="list_data"; style="position:relative; top:0px; display: none;">
                <select id="users" tabindex="0" size="4" multiple="multiple">       
                </select>
            </span>
        </td>
         <td class="td-form"; style="vertical-align:top;">
            <input id="date_time_start_date" type="text" onchange="combo_date_time_start.update(); " onblur="combo_date_time_start.update();" tabindex="0" title="" maxlength="10" size="11" value="" autocomplete="off" style="position:relative; top:4px">
            <img id="date_time_start_trigger" border="0" style="position:relative; top:6px;padding-right: 5px" alt="Ввод даты" src="themes/SugarTalk_theme/images/jscalendar.gif">
            <div id="date_time_start_time_section" style="display: none;">
            <span style="position:relative; top:0px;">
                <select id="date_time_start_hours" class="datetimecombo_time" onchange="combo_date_time_start.update(); " tabindex="0" size="1">
                    <option value="00">00</option>
                </select>
                 :  
                <select id="date_time_start_minutes" class="datetimecombo_time" onchange="combo_date_time_start.update(); " tabindex="0" size="1">
                <option></option>
                    <option value="00">00</option>
                </select>
            </span>
        </div>
        <input id="date_time_start" class="DateTimeCombo" type="hidden" value="" name="date_time_start">
        <script src="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js" type="text/javascript"></script>
        <script type="text/javascript">
            date_time_start_setup("");
            var combo_date_time_start;
            function date_time_start_setup(time_to_set)
            {
                combo_date_time_start = new Datetimecombo(time_to_set, "date_time_start", "23:00", "0", '', false, true);
                text = combo_date_time_start.html('');
                document.getElementById('date_time_start_time_section').innerHTML = text;
                eval(combo_date_time_start.jsscript(''));
     
                YAHOO.util.Event.onDOMReady(function()
                {
                Calendar.setup ({
                onClose : update_date_time_start,
                inputField : "date_time_start_date",
                ifFormat : "%Y-%m-%d %H:%M",
                daFormat : "%Y-%m-%d %H:%M",
                button : "date_time_start_trigger",
                singleClick : true,
                step : 1,
                weekNumbers: false,
                startWeekday: 0,
                comboObject: combo_date_time_start
                });
                combo_date_time_start.update(false);

                });
            }
        </script> 
        </td> 
         <td class="td-form"; style="vertical-align:top;">
            <input id="date_time_end_date" type="text" onchange="combo_date_time_end.update(); " onblur="combo_date_time_end.update();" tabindex="0" title="" maxlength="10" size="11" value="" autocomplete="off" style="position:relative; top:4px">
            <img id="date_time_end_trigger" border="0" style="position:relative; top:6px;padding-right: 5px" alt="Ввод даты" src="themes/SugarTalk_theme/images/jscalendar.gif">
            <div id="date_time_end_time_section" style="display: none;">
            <span style="position:relative; top:0px;">
                <select id="date_time_end_hours" class="datetimecombo_time" onchange="combo_date_time_start.update(); " tabindex="0" size="1">
                    <option value="00">00</option>
                </select>
                 :  
                <select id="date_time_end_minutes" class="datetimecombo_time" onchange="combo_date_time_end.update(); " tabindex="0" size="1">
                <option></option>
                    <option value="00">00</option>
                </select>
            </span>
            </div>
            <input id="date_time_end" class="DateTimeCombo" type="hidden" value="" name="date_time_end">
            <script src="include/SugarFields/Fields/Datetimecombo/Datetimecombo.js" type="text/javascript"></script>
            <script type="text/javascript">
                date_time_end_setup("");
                var combo_date_time_end;
                function date_time_end_setup(time_to_set)
                {
                    combo_date_time_end = new Datetimecombo(time_to_set, "date_time_end", "23:00", "0", '', false, true);
                    text = combo_date_time_end.html('');
                    document.getElementById('date_time_end_time_section').innerHTML = text;
                    eval(combo_date_time_end.jsscript(''));
                    YAHOO.util.Event.onDOMReady(function()
                    {
                    Calendar.setup ({
                    onClose : update_date_time_end,
                    inputField : "date_time_end_date",
                    ifFormat : "%Y-%m-%d %H:%M",
                    daFormat : "%Y-%m-%d %H:%M",
                    button : "date_time_end_trigger",
                    singleClick : true,
                    step : 1,
                    weekNumbers: false,
                    startWeekday: 0,
                    comboObject: combo_date_time_end
                    });
                    combo_date_time_end.update(false);
                    }); 
                }
            </script>      
        </td>  
        <td style="padding-left: 0px; padding-top: 5px; vertical-align:top;">
            <input type="button" id="generate_report" value="Сформировать отчет" name="generate_report">                
        </td>
    </tr>  
</table>
<div id="graph" style="float: left;"></div>       
<div id="table_container" style="padding-top: 10px; float: left;"></div>





