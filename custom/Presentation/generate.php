<?php

function decode($text){
	return iconv("utf-8", "windows-1251", $text);
}

function GeneratePresentation($realty_id)
{
	global $app_list_strings;
    $pdf = new FPDF();
    $pdf->AddFont('TimesNewRomanPSMT','','times.php');
    $pdf->AddFont('Times-Italic','I','timesi.php');
    $pdf->SetAuthor('OfficeWorld');
    $pdf->SetTitle('Presentation');
    $pdf->SetFont('TimesNewRomanPSMT','',25);
    $pdf->SetTextColor(100,100,100);
    $pdf->AddPage('L');
    $pdf->SetDisplayMode('real','default');
    
    $realty = new Realty();
    $realty->retrieve($realty_id);
	
    $image_main='';
    $image_map=array();
    $image_plan=array();
	$images = array();
	$address=array();
	$currency=($realty->currency=='RUR')?'рублей':'долларов';
	$operation_text = $app_list_strings['operation_realty_list'][$realty->operation];
	
	/*if($realty->address_country!='') $address[]=$realty->address_country;
	if($realty->address_region!='') $address[]=$realty->address_region;
	if($realty->address_city!='') $address[]=$realty->address_city;*/
	if($realty->metro!='') $address[]=$realty->metro;
	if($realty->address_street!='') $address[]=$realty->address_street;
	if($realty->address_house!='') $address[]=$realty->address_house;
	if($realty->address_apartment!='') $address[]="кв.".$realty->address_apartment;
	$address=implode(', ',$address);


    if(is_dir('upload/gallery_images/'.$realty->id))
    {
        $db_img= DBManagerFactory::getInstance();
        $sql_img = "SELECT galleria_c FROM realty_cstm WHERE id_c = '".$realty->id."'";
        $result_img = $db_img->query($sql_img);
        $row_img = $db_img->fetchByAssoc($result_img);
        $img_str = $row_img['galleria_c'];
        $image = explode('|', $img_str);
        foreach ($image as $key=>$value)
        {
            $value = str_replace('^,^', '|', $value);
            $value = str_replace('^', '', $value);
			$image_t = explode('|', $value);
			
			if($image_t[2] == 'main'){
				$image_main=$image_t[1];
			}elseif($image_t[8] == 'on'){
				$image_map=$image_t;
			}elseif($image_t[9] == 'on'){
				$image_plan=$image_t;
			}elseif($image_t[7]=='on'){
				$images[] = $image_t;
			}
        }
	}
	$pdf->SetXY(0,5);
	
	$text=decode("{$operation_text}\n{$address}");
	$pdf->MultiCell(297, 7, $text, 0, 'C');
	
	$y=$pdf->GetY()+5;
	
	if($image_main!=''){
		$img = "upload/gallery_images/{$realty->id}/{$image_main}";
		list($w_i, $h_i) = getimagesize($img);
		if($w_i-$h_i>$w_i*0.3){
			$y+=((184-$y)-$h_i*284/$w_i)/2;
			$pdf->Image($img, 6, 15+$y, 284, 0);
		}else{
			$x=(284-$w_i*(184-$y)/$h_i)/2;
			$pdf->Image($img, 6+$x, $y, 0, 184-$y);
		}
	}
	
	//Footer
    $pdf->Image('custom/Presentation/footer_main.png', 0, 172, 297,0);
	
//Page2
    $pdf->SetTextColor(255,255,255);
	
	if(isset($image_map[1])){
		$pdf->AddPage('L');
		$img = "upload/gallery_images/{$realty->id}/{$image_map[1]}";
		list($w_i, $h_i) = getimagesize($img);
		if($w_i-$h_i>$w_i*0.3){
			$y=(178-$h_i*284/$w_i)/2;
			$pdf->Image($img, 6, 15+$y, 284, 0);
		}else{
			$x=(284-$w_i*178/$h_i)/2;
			$pdf->Image($img, 6+$x, 15, 0, 178);
		}
		//Header
		$pdf->Image('custom/Presentation/header.png', 0, 0, 297,0);
		$pdf->SetXY(0,5);
		$pdf->SetFontSize(30);
		$text=decode($image_map[0]);
		$pdf->MultiCell(297, 7, $text, 0, 'C');
		//Footer
		$pdf->Image('custom/Presentation/footer.png', 0, 187, 297,0);
	}

//Page3
	if(isset($image_plan[1])){
		$pdf->AddPage('L');
		
		$img = "upload/gallery_images/{$realty->id}/{$image_plan[1]}";
		list($w_i, $h_i) = getimagesize($img);
		if($w_i-$h_i>$w_i*0.3){
			$y=(178-$h_i*284/$w_i)/2;
			$pdf->Image($img, 6, 15+$y, 284, 0);
		}else{
			$x=(284-$w_i*178/$h_i)/2;
			$pdf->Image($img, 6+$x, 15, 0, 178);
		}
		//Header
		$pdf->Image('custom/Presentation/header.png', 0, 0, 297,0);
		$pdf->SetXY(0,5);
		$pdf->SetFontSize(30);
		$text=decode($image_plan[0]);
		$pdf->MultiCell(297, 7, $text, 0, 'C');
		//Footer
		$pdf->Image('custom/Presentation/footer.png', 0, 187, 297,0);
	}
	
//Page OtherImages
	foreach($images as $image){
		$pdf->AddPage('L');
		
		$img = "upload/gallery_images/{$realty->id}/{$image[1]}";
		list($w_i, $h_i) = getimagesize($img);
		if($w_i-$h_i>$w_i*0.3){
			$y=(178-$h_i*284/$w_i)/2;
			$pdf->Image($img, 6, 15+$y, 284, 0);
		}else{
			$x=(284-$w_i*178/$h_i)/2;
			$pdf->Image($img, 6+$x, 15, 0, 178);
		}
		//Header
		$pdf->Image('custom/Presentation/header.png', 0, 0, 297,0);
		$pdf->SetXY(0,5);
		$pdf->SetFontSize(30);
		$text=decode($image[0]);
		$pdf->MultiCell(297, 7, $text, 0, 'C');
		//Footer
		$pdf->Image('custom/Presentation/footer.png', 0, 187, 297,0);
	}


//Page last
    $pdf->AddPage('L');
	//Header
	$pdf->Image('custom/Presentation/header.png', 0, 0, 297,0);
	$pdf->SetXY(0,5);
	$text=decode("Описание помещения");
	$pdf->MultiCell(297, 7, $text, 0, 'C');
	
	//Body
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(200,200,255);
	
	$pdf->SetY(40);
	//if($realty->operation=='rent'){
		$pdf->SetFontSize(24);
		drawProp($pdf, "Основная информация", '', true, 8);
		$pdf->SetFontSize(16);
		drawProp($pdf, "Вид объекта", $app_list_strings['kind_of_realty_list'][$realty->kind_of_realty], false, 8);
		drawProp($pdf, "Количество комнат", $realty->rooms_quantity, true, 8);
		drawProp($pdf, "Этаж/Этажность", "{$realty->floor}/{$realty->number_of_floors}", false, 8);
		$pdf->SetFontSize(20);
		drawProp($pdf, "Текущая цена", "{$realty->cost} {$currency}", true, 10);
		
		$pdf->SetY($pdf->GetY()+20);
		$pdf->SetFillColor(255,200,200);
		$pdf->SetFontSize(24);
		drawProp($pdf, "Параметры объекта:", '', true, 8);
		$pdf->SetFontSize(16);
		drawProp($pdf, "Общая площадь", $realty->square." кв.м", false, 8);
		drawProp($pdf, "Жилая площадь", $realty->living_square." кв.м", true, 8);
		drawProp($pdf, "Площадь кухни", $realty->kitchen_square." кв.м", false, 8);
		drawProp($pdf, "Состояние объекта", $app_list_strings['state_of_object_list'][$realty->state_of_object], true, 8);
	/*}else{
		$pdf->SetFontSize(18);
		drawProp($pdf, "Общая площадь", $realty->square_total." кв.м", true);
		$pdf->SetFontSize(28);
		$realty->cost_buying=number_format($realty->cost_buying, 0, ',', ' ');
	}*/
	
	//Footer
	$pdf->Image('custom/Presentation/footer.png', 0, 187, 297,0);
	
    /* $pdf->SetTextColor(255,255,255);
	$pdf->SetXY(20,190); 
    $pdf->SetFontSize(14);
	$text=decode("+7 (499) 707-50-57\n+7 (926) 531-09-93");
	$pdf->MultiCell(100, 1, $text, 0, 'L'); */
    
    $pdf->Output("custom/Presentation/pdf/ID-{$realty->id}.pdf");
	
    return ("custom/Presentation/pdf/ID-{$realty->id}.pdf");
}

function drawProp($pdf, $prop, $value, $fill=true, $h=9){
	$y=$pdf->GetY();
	$pdf->SetX(10);
	$prop=decode($prop);
	$value=decode($value);
	$pdf->MultiCell(142, $h, $prop, 0, 'L', $fill);
	$pdf->SetXY(142,$y);
	$pdf->MultiCell(140, $h, $value, 0, 'R', $fill);
}