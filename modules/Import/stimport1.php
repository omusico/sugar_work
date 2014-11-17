<?php
header('Content-type: text/html; charset=utf-8');
echo "<script src='modules/Import/new.js'></script>";
?>
Выберите файл для импорта
<form enctype="multipart/form-data" action="index.php?module=Import&action=stimport2" method="POST">
    
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    <input name="userfile" type="file" accept=".csv"/>
    <select name="delimiter">
        <option value=",">Разделитель запятая</option>
        <option value=";">Разделитель точка с запятой</option>
        <option value="tab">Разделитель табуляция</option>
    </select>
    <select name="encode">
        <option value="Windows-1251">Windows-1251</option>
        <option value="utf-8">utf-8</option>
    </select>
    <input type="submit" value="Отправить файл" />
    
</form>
      

