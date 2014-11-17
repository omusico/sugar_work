<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$result = array();

$result['status'] = 'ok';
$result['file_name'] = $_POST['image_name'];
$result['origin_name_chanched'] = 'true';

    $targ_x = $_POST['x'];
    $targ_y = $_POST['y'];

	$targ_w = $_POST['w'];
    $targ_h = $_POST['h'];

    $width_resize = $_POST['width_resize'];


    $origin_file = $_POST['upload_path'] . 'origin_' . $_POST['image_name'];

    if (!is_file($origin_file)) {
        rename($_POST['upload_path'] . $_POST['image_name'], $origin_file);
    }

    if ($_POST['w'] != 'NaN' && $_POST['w'] != '') {
        $img_r = imagecreatefromjpeg($origin_file);
    
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
    
        imagecopyresampled($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_w, $targ_h, $targ_w, $targ_h);
    
    
        if (!imagejpeg($dst_r, $_POST['upload_path'] . $_POST['image_name'], 100)) {
            $result['status'] = 'fail';
        }

        if ($_POST['replace_origin'] == 'on') {
            if (is_file($origin_file)) {
                unlink($origin_file);
            }
            $origin_file = $_POST['upload_path'] . $_POST['image_name'];

            $result['origin_name_chanched'] = 'false';
            $result['origin_chanched'] = 'true';
        }
    }

    else {
        if (is_file($_POST['upload_path'] . $_POST['image_name'])) {
            unlink($_POST['upload_path'] . $_POST['image_name']);
        }
        rename($origin_file, $_POST['upload_path'] . $_POST['image_name']);

        $origin_file = $_POST['upload_path'] . $_POST['image_name'];

        $result['origin_name_chanched'] = 'false';
    }

    if (is_file($origin_file)) {
        chmod($origin_file, 0777);
    }
    if (is_file($_POST['upload_path'] . $_POST['image_name'])) {
        chmod($_POST['upload_path'] . $_POST['image_name'], 0777);
    }



    require_once('custom/include/GalleryField/resize.php');

    $jpeg_quality = $_POST['quality'];

    $width_resize = $_POST['width_resize'];
    $width_in_persent = false;

    if (!strrpos($width_resize, '%') === false) {
        $width_resize = substr($width_resize, 0, strrpos($width_resize, '%'));
        $width_in_persent = true;
    }

    if (($_POST['isValidResizeValues'] == "true") && ($jpeg_quality != '' || $width_resize != '')) {
        resize($origin_file, $origin_file, $width_resize, 0, $width_in_persent, $jpeg_quality);
        $result['origin_chanched'] = 'true';
    }


    header('Content-Type: text/html'); //Устанавливаем заголовок

    //Кодируем массив в JSON и выдаем на вывод
    echo json_encode($result);