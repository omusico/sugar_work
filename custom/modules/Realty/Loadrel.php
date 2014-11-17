<?php

$module = $_REQUEST['from_module'];
$module_id = $_REQUEST['parent_record_id'];
$linked_module_id = $_REQUEST['id_record'];

loadRel($module, $module_id, $linked_module_id);

function loadRel($module, $module_id, $linked_module_id)
{
    
    if($module == 'Accounts')
    {
        $Accounts = new Account();

        $Accounts->retrieve($linked_module_id);

        $Accounts->load_relationships('realty_accounts_interest');

        $Accounts->realty_accounts_interest->add($module_id);
    }
    elseif($module == 'Contacts')
    {
        $Contacts = new Contact();

        $Contacts->retrieve($linked_module_id);

        $Contacts->load_relationships('realty_contacts_interest');

        $Contacts->realty_contacts_interest->add($module_id);
    }
    elseif($module == 'Request')
    {
        $Request = new Request();

        $Request->retrieve($linked_module_id);

        $Request->load_relationships('realty_requests_interest');

        $Request->realty_requests_interest->add($module_id);
    }
    
}