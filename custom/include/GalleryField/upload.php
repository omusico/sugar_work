<?php

require_once('include/utils.php');


function convertImageToJpeg ($file_name_without_ext, $file_type)
{
    $to = 'jpeg';

    if ($to == $file_type) {
        return true;
    }

    $file = $file_name_without_ext . '.' . $file_type;

    $save_as = $file_name_without_ext . '.' .  $to;

    $image_ext_jpeg = array('jpeg', 'JPEG', 'jfif', 'JTIF', 'jpg', 'JPG', 'jpe', 'JPE');

    if (array_search($file_type, $image_ext_jpeg))
    {
        $image = @imagecreatefromjpeg($file);
    }

    switch ($file_type)
    {
        case('gif'):
            $image = @imagecreatefromgif($file);
            break;

        case('png'):
            $image = @imagecreatefrompng($file);
            break;
    }

    if ($image) {
        @imagejpeg($image, $save_as);
        unlink($file);
    }

    return $image;
}




//$result = array('status' => 'fail');

$prefix = $_POST['module_name'] . 'imageFlag';

$upload_path = 'upload/gallery_images/';

$upload_path_with_id = $upload_path . $_POST['record_id'] . '/'; //определение директории

$image_ext = array('jpeg', 'JPEG', 'jfif', 'JTIF', 'jpg', 'JPG', 'jpe', 'JPE', 'png', 'PNG', 'gif', 'GIF');


@mkdir('upload/', 0777);

if(!is_dir($upload_path))
{
    @mkdir($upload_path, 0777);
}

if(!is_dir($upload_path_with_id))
{
    @mkdir($upload_path_with_id, 0777);
}


$temp_images = array();



if(!empty($_FILES) && $_POST['record_id'] != '') //добавлены или изменены файлы
{
	// echo "<pre>";print_r($_FILES);echo "</pre>";
	if(isset($_FILES['gallery_upload_multy']))
	{
		$val=$_FILES['gallery_upload_multy'];
		$f_count=count($val['name']);
		for($i=0;$i<$f_count;$i++){
			
			$image_prop = @getimagesize($val['tmp_name'][$i]);

			$file_type = substr($val['name'][$i], strrpos($val['name'][$i], '.') + 1);

			if($val['size'][$i] == 0 || $val['size'][$i] > 10240000) //проверка на размер файла
			{
				continue;
			}

			if ((!$image_prop || $image_prop[0] > 10000 || $image_prop[1] > 10000)
					&& !array_search($file_type, $image_ext) && !$image_prop) //проверка на разрешение изображения и тип файла
			{
				continue;
			}

			else //загруженный файл корректный
			{

				$file_name_without_ext = $file_name = create_guid(); //генерация имени файла

				$file_name .= '.' . $file_type;

				move_uploaded_file($val['tmp_name'][$i], $upload_path_with_id . $file_name); //сохранение файла

				if (!convertImageToJpeg($upload_path_with_id.$file_name_without_ext, $file_type)) {
					$result[]['status'] = 'fail';
					header('Content-Type: text/html');
				   // echo json_encode($result);
				   // exit;
				   continue;
				}

				if ($_POST['old_image'] != '' && is_file($upload_path_with_id.$_POST['old_image'])) {
					unlink($upload_path_with_id.$_POST['old_image']);

					if (is_file($upload_path_with_id. 'origin_' . $_POST['old_image'])) {
						unlink($upload_path_with_id . 'origin_' . $_POST['old_image']);
					}
				}

				if (is_file($upload_path_with_id . $file_name_without_ext . '.jpeg')) {
					chmod($upload_path_with_id . $file_name_without_ext . '.jpeg', 0777);
				}

				$result[] = array('status' => 'ok',
								'file_name' => $file_name_without_ext . '.jpeg');

			}
		}
	}else{
		foreach($_FILES as $key => $val)
		{
			$result[0] = array('status' => 'fail');
			if (strpos($key, $prefix . '2_') === 0)
			{
				$new_key = intval(str_replace($prefix . '2_', '', $key));

				$image_prop = @getimagesize($val['tmp_name']);

				$file_type = substr($val['name'], strrpos($val['name'], '.') + 1);

				if ($val['error'] != 0) //проверка на имя и ошибки новых файлов
				{
					if(empty($images[$new_key]['path'])) //если нет старого значения
					{
						continue;
					}
				}

				if($val['size'] == 0 || $val['size'] > 10240000) //проверка на размер файла
				{
					continue;
				}

				if ((!$image_prop || $image_prop[0] > 10000 || $image_prop[1] > 10000)
						&& !array_search($file_type, $image_ext) && !$image_prop) //проверка на разрешение изображения и тип файла
				{
					continue;
				}

				else //загруженный файл корректный
				{

					$file_name_without_ext = $file_name = create_guid(); //генерация имени файла

					$file_name .= '.' . $file_type;

					move_uploaded_file($val['tmp_name'], $upload_path_with_id . $file_name); //сохранение файла

					if (!convertImageToJpeg($upload_path_with_id.$file_name_without_ext, $file_type)) {
						$result[0]['status'] = 'fail';
						header('Content-Type: text/html');
					   // echo json_encode($result);
					   // exit;
					   continue;
					}

					if ($_POST['old_image'] != '' && is_file($upload_path_with_id.$_POST['old_image'])) {
						unlink($upload_path_with_id.$_POST['old_image']);

						if (is_file($upload_path_with_id. 'origin_' . $_POST['old_image'])) {
							unlink($upload_path_with_id . 'origin_' . $_POST['old_image']);
						}
					}

					if (is_file($upload_path_with_id . $file_name_without_ext . '.jpeg')) {
						chmod($upload_path_with_id . $file_name_without_ext . '.jpeg', 0777);
					}

					$result[0] = array('status' => 'ok',
									'file_name' => $file_name_without_ext . '.jpeg');

				}
			}
		}
	}
}



header('Content-Type: text/html'); //Устанавливаем заголовок

//Кодируем массив в JSON и выдаем на вывод
echo json_encode($result);