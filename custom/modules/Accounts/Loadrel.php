<?php


$Accounts = new Account();

$accounts_id = $_REQUEST['parent_record_id'];
$realty_id = $_REQUEST['id_record'];

$Accounts->retrieve($accounts_id);

$Accounts->load_relationships('realty_accounts_interest');

$Accounts->realty_accounts_interest->add($realty_id);