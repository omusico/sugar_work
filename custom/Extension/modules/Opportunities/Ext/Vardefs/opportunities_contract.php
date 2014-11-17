<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */



$dictionary['Opportunity']['fields']['contract_id'] =
            array (
                'required' => false,
                'name' => 'contract_id',
                'vname' => '',
                'type' => 'id',
                'massupdate' => 0,
                'importable' => 'true',
                'audited' => 0,
                'len' => 36,
            );
 $dictionary['Opportunity']['fields']['contract_name'] =
  array (
      'name' => 'contract_name',
      'vname' => 'LBL_CONTRACT_NAME',
      'type' => 'relate',
      'reportable' => false,
      'link' => 'contract_link',
      'rname' => 'name',
      'source' => 'non-db',
      'table' => 'contract',
      'id_name' => 'contract_id',//это как раз таки id из другой таблицы, который указывает на текущую запись
      'module' => 'Contract',
      'duplicate_merge' => 'disabled',
      'importable' => 'false',
  );
  $dictionary['Opportunity']['fields']['contract_link'] =
  array (
      'name' => 'contract_link',
      'type' => 'link',
      'relationship' => 'opportunities_contract',
      'vname' => 'LBL_CONTRACT_LINK',
      'link_type' => 'one',
      'module' => 'Contract',
      'bean_name' => 'Contract',
      'source' => 'non-db',
  );

$dictionary['Opportunity']['relationships']['opportunities_contract'] =
    array (
        'lhs_module' => 'Opportunities',
        'lhs_table' => 'opportunities',
        'lhs_key' => 'id',
        'rhs_module' => 'Contract',
        'rhs_table' => 'contract',
        'rhs_key' => 'opp_id',
        'relationship_type' => 'one-to-many',
    );