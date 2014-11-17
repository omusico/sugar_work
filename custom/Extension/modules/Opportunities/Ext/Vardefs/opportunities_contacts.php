<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 $dictionary['Opportunity']['fields']['contact_id'] =
  array (
      'required' => false,
      'name' => 'contact_id',
      'vname' => '',
      'type' => 'id',
      'massupdate' => 0,
      'importable' => 'true',
      'audited' => 0,
      'len' => 36,
  );
  $dictionary['Opportunity']['fields']['contact_name'] =
  array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'contact_name',
      'vname' => 'LBL_CONTACT_NAME',
      'type' => 'relate',
      'massupdate' => 0,
      'comments' => '',
      'help' => '',
      'audited' => 1,
      'len' => '100',
      'id_name' => 'contact_id',
      'ext2' => 'Contacts',
      'module' => 'Contacts',
      'rname' => 'name',
      'studio' => 'visible',
  );