<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
$dictionary["Contact"]["fields"]["opportunity_contacts"] =
    array (
        'name' => 'opportunity_contacts',
        'type' => 'link',
        'relationship' => 'opportunity_contacts',
        'module'=>'Opportunities',
        'bean_name'=>'Opportunities',
        'source'=>'non-db',
        'vname'=>'LBL_OPPORTUNITIES_CONTACTS',
    );


$dictionary['Contact']['relationships']['opportunity_contacts'] =
    array (
        'lhs_module'=> 'Contacts',
        'lhs_table'=> 'contacts',
        'lhs_key' => 'id',
        'rhs_module'=> 'Opportunities',
        'rhs_table'=> 'opportunities',
        'rhs_key' => 'contact_id',
        'relationship_type'=>'one-to-many'
    );