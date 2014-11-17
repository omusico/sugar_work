<?php
global $db;
$sql = 'SELECT *
        FROM accounts
        WHERE deleted = 0
        ';
$result = $db->query($sql); 
While($row = $db->fetchByAssoc($result))
{
    $request = new Request();
    $request->name = 'Заявка '.$row['name'];
    $request->parent_type = 'Accounts';
    $request->parent_id = $row['id'];
    $request->description = $row['realty_description'];
    $request->operation = $row['operation'];
    $request->type_of_realty = $row['type_of_realty'];
    $request->kind_of_realty = $row['kind_of_realty'];
    $request->rooms_quantity = $row['rooms_quantity'];
    $request->cost_to = $row['cost_to'];
    $request->square_min = $row['square_min'];
    $request->square_max = $row['square_max'];
    $request->min_floor = $row['min_floor'];
    $request->max_floor = $row['max_floor'];
    $request->metro = $row['metro'];
    $request->layout = $row['layout'];
    $request->state_of_object = $row['state_of_object'];
    $request->address_city = $row['address_city'];
    $request->address_country = $row['address_country'];
    $request->address_street = $row['address_street'];
    $request->address_region = $row['address_region'];
    $request->currency = $row['currency'];
    $request->save();
}

$sql = 'SELECT *
        FROM contacts
        WHERE deleted = 0
        ';
$result = $db->query($sql); 
While($row = $db->fetchByAssoc($result))
{
    $request = new Request();
    $request->name = 'Заявка '.$row['last_name'].' '.$row['first_name'];
    $request->parent_type = 'Contacts';
    $request->parent_id = $row['id'];
    $request->description = $row['realty_description'];
    $request->operation = $row['operation'];
    $request->type_of_realty = $row['type_of_realty'];
    $request->kind_of_realty = $row['kind_of_realty'];
    $request->rooms_quantity = $row['rooms_quantity'];
    $request->cost_to = $row['cost_to'];
    $request->square_min = $row['square_min'];
    $request->square_max = $row['square_max'];
    $request->min_floor = $row['min_floor'];
    $request->max_floor = $row['max_floor'];
    $request->metro = $row['metro'];
    $request->layout = $row['layout'];
    $request->state_of_object = $row['state_of_object'];
    $request->address_city = $row['address_city'];
    $request->address_country = $row['address_country'];
    $request->address_street = $row['address_street'];
    $request->address_region = $row['address_region'];
    $request->currency = $row['currency'];
    $request->save();
}