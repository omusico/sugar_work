<?php


$Request = new Request();

$requests_id = $_REQUEST['parent_record_id'];
$realty_id = $_REQUEST['id_record'];

$Request->retrieve($requests_id);

$Request->load_relationships('realty_requests_interest');

$Request->realty_requests_interest->add($realty_id);