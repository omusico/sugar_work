<?php


$Contacts = new Contact();

$contacts_id = $_REQUEST['parent_record_id'];
$realty_id = $_REQUEST['id_record'];

$Contacts->retrieve($contacts_id);

$Contacts->load_relationships('realty_contacts_interest');

$Contacts->realty_contacts_interest->add($realty_id);