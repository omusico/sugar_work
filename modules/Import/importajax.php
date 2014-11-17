<?php

//file_put_contents(__DIR__."/upload.sql", $sql_dump);
global $sugar_config;

$host = $sugar_config['dbconfig']['db_host_name'];
$user = $sugar_config['dbconfig']['db_user_name'];
$pass = $sugar_config['dbconfig']['db_password'];
$name = $sugar_config['dbconfig']['db_name'];

$link = mysql_connect($host,$user,$pass);
//    mysql_query("SET NAMES cp1251");
    mysql_select_db($name,$link);
    
if(file_exists (__DIR__."/upload.sql"))
{
    $sql_dump = file_get_contents(__DIR__."/upload.sql");
    $sql_dump_array = explode("; \n", $sql_dump);
    $i=0;
    foreach ($sql_dump_array as $value)
    {
        mysql_query($value);
        $i++;
    }
//    echo '<pre>';
//    echo $sql_dump;
//    echo '</pre>';
    
    if($i)
    {
        echo '"Откат данных закончен!"';
        exit();
    }
    else
    {
        echo '"Произошла ошибка отката данных"';
        exit();
    }
}
else
{
    echo '"Файла с дампом не с существует, или его невозможно прочитать!"';
    exit();
}


