<?php

$file = "custom/modules/Realty/number_days_new_application.txt";

if(!isset($_REQUEST['to_save']))
{

$form_config = '<div><br/><br/><form name="days_new" method="post" action="http://localhost/realty/index.php?module=Realty&action=DaysSettings&to_save=true">
  <div>Период выделения "новой" недвижимости:<input type="text" size="4" value="';
$form_config .=file_get_contents($file);
$form_config .='" id="days_new" name="days_new"></div><input /title="Сохранить" class="button primary" id ="days_new" name="save" type="submit" value="Сохранить">
 </form></div>';

echo $form_config;
}
else
{
	
	file_put_contents($file, $_REQUEST['days_new']);
	SugarApplication::redirect('index.php');
}

