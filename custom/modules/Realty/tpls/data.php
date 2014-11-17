<?php
// Please setup mysql connection in CMySQL.php
require_once('CMySQL.php');// Подключаем класс для работы с БД
global $sugar_config;

$mysql = new CMySQL($sugar_config['dbconfig']['db_name'],$sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']); // Объявляем экземпляр класса для работы с БД

if ($_REQUEST['field_name'] == 'city')
{
    $country = $_GET['country']; // Получаем Страну
    $city = $_GET['term']; // Получаем вводимые данные в поля город
    $region = $_GET['region'];
	
    $country=str_replace('&quot;', '', $country);
    $region=str_replace('&quot;', '', $region);
    $country=str_replace('"', '', $country);
    $region=str_replace('"', '', $region);

    $sql = "SELECT city.city_name_ru as city
            FROM city_ as city";
    if($country)
    {
        $sql .= " JOIN country_ as country ON country.country_name_ru = '{$country}'";
    }

    if(trim($region, '""'))
    {
        $sql .= " JOIN region_ as region ON region.region_name_ru = '{$region}'";
    }

    $sql .= " WHERE city.id_country = country.id
            AND city.city_name_ru LIKE '{$city}%'
            ORDER BY country_name_ru";

    $aItemInfo = $mysql->getAll($sql); // Получаем все записи, соответствующие запросу

    foreach ($aItemInfo as $aValues)
    {
        $data_cities[] = $aValues['city'] . "\n";
    }
    echo json_encode($data_cities);
}

elseif ($_REQUEST['field_name'] == 'region')
{
    $country = $_GET['country']; // Получаем Страну
    $region = $_GET['term']; // Получаем вводимые данные в поля город\
    $country=str_replace('&quot;', '', $country);
    $country=str_replace('"', '', $country);

    $sql = "SELECT region.region_name_ru as region
            FROM region_ as region
            JOIN country_ as country ON country.country_name_ru = '{$country}'
            WHERE region.id_country = country.id
            AND region.region_name_ru LIKE '{$region}%'
            ORDER BY country_name_ru";

   // $mysql = new CMySQL(); // Объявляем экземпляр класса для работы с БД
    $aItemInfo = $mysql->getAll($sql); // Получаем все записи, соответствующие запросу
    foreach ($aItemInfo as $aValues)
    {
        $data_regions[] = $aValues['region'] . "\n";
    }
    echo json_encode($data_regions);
}

elseif($_REQUEST['field_name'] == 'country')
{

    $sParam = $_GET['term']; // Получаем вводимые данные в поля страна

    $sql = "SELECT country_name_ru FROM country_ WHERE country_name_ru LIKE '{$sParam}%' ORDER BY country_name_ru";

   // $mysql = new CMySQL(); // Объявляем экземпляр класса для работы с БД
    $aItemInfo = $mysql->getAll($sql); // Получаем все записи, соответствующие запросу

    foreach ($aItemInfo as $aValues)
    {
        $data[] = $aValues['country_name_ru'] . "\n";
    }
    echo json_encode($data); //Возвращаем массив со списком стран
}
