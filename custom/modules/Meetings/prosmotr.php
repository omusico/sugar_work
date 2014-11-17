<?php
/**
 * Created by Kolerts
 * Protected by SugarTalk.ru
 */
 
if(isset($_REQUEST['record']))
{
	if(isset($_REQUEST['date']))
		gen_prosmotr_list();
	else
		gen_prosmotr();
}
else
	echo"<h1>Просмотровый лист НЕ создан</h1><br/>
	<b style='color:#b00;'>Ошибка. Не указана запись для которой необходимо создать просмотровый лист</b>";
	
function gen_prosmotr_list(){
	require_once ('custom/include/PHPWord/PHPWord.php');
	$doc = new Document; // создаем запись в документах и описание файла к нему
	$doc->id = create_guid();
    $doc->new_with_id = true;
	$doc->document_name="Просмотровый лист на {$_REQUEST['date']}";
	
	$doc->status_id="Active";
	
	$doc_rev = new DocumentRevision;
	$doc_rev->filename="просмотровый лист - {$_REQUEST['date']}.docx";
	$doc_rev->file_ext="docx";
	$doc_rev->file_mime_type="application/octet-stream";
	$doc_rev->revision="1";
	
	$doc_rev->document_id=$doc->id;
	$doc_rev->save();
	$doc->document_revision_id=$doc_rev->id;
	$doc->save();
	
	
	//Set table cells style
	$cellStyle = array(	'borderTopSize' => 1, 'borderTopColor'=>'000000',
						'borderLeftSize' => 1, 'borderLeftColor'=>'000000',
						'borderRightSize' => 1, 'borderRightColor'=>'000000',
						'borderBottomSize' => 1, 'borderBottomColor'=>'000000');
	// New Word Document
	$PHPWord = new PHPWord();
	// New portrait section
	$section = $PHPWord->createSection();
	//Add title
	$section->addText('Просмотровый лист', array('size'=>18, 'bold'=>true), array('align'=>'center'));
	// Add table
	$table = $section->addTable();
	$table->addRow();
	// Add Cell
	$table->addCell(1750, $cellStyle)->addText("Дата и время");
	$table->addCell(1750, $cellStyle)->addText("Показ");
	$table->addCell(1750, $cellStyle)->addText("Адрес");
	$table->addCell(1750, $cellStyle)->addText("Описание");
	$table->addCell(1750, $cellStyle)->addText("Объект");
	$table->addCell(1750, $cellStyle)->addText("Клиент");
	$table->addCell(1750, $cellStyle)->addText("Риэлтор");
	
	$records=explode('_',$_REQUEST['record']);
	foreach($records as $id){
		$bean = loadBean('Meetings');
		$bean->retrieve($id);
		$user = loadBean('Users'); // получаем реелтора
		$user->retrieve($bean->assigned_user_id);
		$client = loadBean($bean->parent_type);// получаем клиента
		$client->retrieve($bean->parent_id);
		$realty = loadBean('Realty');// получаем объект
		$realty->retrieve($bean->realty_id);
		/*$client = loadBean('Contacts');// получаем клиента
		$client->retrieve($bean->contact_id);*/
		
		$table->addRow();
		$table->addCell(1750, $cellStyle)->addText($bean->date_start);
		$table->addCell(1750, $cellStyle)->addText($bean->name);
		$table->addCell(1750, $cellStyle)->addText($bean->location);
		$table->addCell(1750, $cellStyle)->addText($bean->description);
		$table->addCell(1750, $cellStyle)->addText($realty->name);
		$table->addCell(1750, $cellStyle)->addText($client->first_name.' '.$client->last_name);
		$table->addCell(1750, $cellStyle)->addText($user->first_name.' '.$user->last_name);
	}
	
	// Save File
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save("upload/{$doc_rev->id}");
	
	echo"<h1>Просмотровый лист создан</h1><br/>
		<a href='index.php?entryPoint=download&id={$doc_rev->id}&type=Documents'>Скачать файл</a><br/>
		<a href='index.php?module=Documents&action=DetailView&record={$doc->id}'>Перейти в документ</a><hr/>
		<a href='index.php?module=Meetings&action=DetailView&record={$_REQUEST['record']}'>Вернуться в карточку показа</a>
		";
}
function gen_prosmotr(){
	require_once ('custom/include/PHPWord/PHPWord.php');
	$bean = loadBean('Meetings');
	$bean->retrieve($_REQUEST['record']);
	$user = loadBean('Users'); // получаем реелтора
	$user->retrieve($bean->assigned_user_id);
	$client = loadBean($bean->parent_type);// получаем клиента
	$client->retrieve($bean->parent_id);
	$realty = loadBean('Realty');// получаем объект
	$realty->retrieve($bean->realty_id);
	/*$client = loadBean('Contacts');// получаем клиента
	$client->retrieve($bean->contact_id);*/
	
	$doc = new Document; // создаем запись в документах и описание файла к нему
	$doc->id = create_guid();
    $doc->new_with_id = true;
	$doc->document_name="Просмотровый лист по показу {$bean->name}";
	$doc->status_id="Active";
	
	$doc_rev = new DocumentRevision;
	$doc_rev->filename="просмотровый лист - {$bean->name}.docx";
	$doc_rev->file_ext="docx";
	$doc_rev->file_mime_type="application/octet-stream";
	$doc_rev->revision="1";
	
	$doc_rev->document_id=$doc->id;
	$doc_rev->save();
	$doc->document_revision_id=$doc_rev->id;
	$doc->save();
	
	/*$client->load_relationship('documents'); // цепляем документ к клиенту
	$client->documents->add($doc->id,array());*/
	
	//Set table cells style
	$cellStyle = array(	'borderTopSize' => 1, 'borderTopColor'=>'000000',
						'borderLeftSize' => 1, 'borderLeftColor'=>'000000',
						'borderRightSize' => 1, 'borderRightColor'=>'000000',
						'borderBottomSize' => 1, 'borderBottomColor'=>'000000');
	// New Word Document
	$PHPWord = new PHPWord();
	// New portrait section
	$section = $PHPWord->createSection();
	//Add title
	$section->addText('Просмотровый лист', array('size'=>18, 'bold'=>true), array('align'=>'center'));
	// Add table
	$table = $section->addTable();
	$table->addRow();
	// Add Cell
	$table->addCell(1750, $cellStyle)->addText("Дата и время");
	$table->addCell(1750, $cellStyle)->addText("Адрес");
	$table->addCell(1750, $cellStyle)->addText("Описание");
	$table->addCell(1750, $cellStyle)->addText("Объект");
	$table->addCell(1750, $cellStyle)->addText("Клиент");
	$table->addCell(1750, $cellStyle)->addText("Риэлтор");
	$table->addRow();
	$table->addCell(1750, $cellStyle)->addText($bean->date_start);
	$table->addCell(1750, $cellStyle)->addText($bean->location);
	$table->addCell(1750, $cellStyle)->addText($bean->description);
	$table->addCell(1750, $cellStyle)->addText($realty->name);
	$table->addCell(1750, $cellStyle)->addText($client->first_name.' '.$client->last_name);
	$table->addCell(1750, $cellStyle)->addText($user->first_name.' '.$user->last_name);
	// Save File
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save("upload/{$doc_rev->id}");
	
	echo"<h1>Просмотровый лист создан</h1><br/>
		<a href='index.php?entryPoint=download&id={$doc_rev->id}&type=Documents'>Скачать файл</a><br/>
		<a href='index.php?module=Documents&action=DetailView&record={$doc->id}'>Перейти в документ</a><hr/>
		<a href='index.php?module=Meetings&action=DetailView&record={$_REQUEST['record']}'>Вернуться в карточку показа</a>
		";
}
?>