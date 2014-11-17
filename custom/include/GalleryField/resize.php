<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function resize($file_input, $file_output, $w_o, $h_o, $percent = false, $quality)
{
	list($w_i, $h_i) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		//echo 'Невозможно получить длину и ширину изображения';
		return;
    }

    $img = @imagecreatefromjpeg($file_input);

	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}

	if (!$h_o) {
        $h_o = $w_o/($w_i/$h_i);
    }
	if (!$w_o) {
        $w_o = $h_o/($h_i/$w_i);
    }

    if ($h_o == 0 && $w_o == 0) {
        $h_o = $h_i;
        $w_o = $w_i;
    }
    if ($quality == '') {
        $quality = 100;
    }


	$img_o = @imagecreatetruecolor($w_o, $h_o);

	@imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);

    return @imagejpeg($img_o, $file_output, $quality);
}