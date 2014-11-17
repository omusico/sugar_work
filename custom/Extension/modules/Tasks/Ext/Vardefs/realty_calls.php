<?php
/**
 * Created by iluxovi4
 * Protected by SugarTalk.ru
 */
 $dictionary['Task']['fields']['realty_id'] =
  array (
      'required' => false,
      'name' => 'realty_id',
      'vname' => '',
      'type' => 'id',
      'massupdate' => 0,
      'importable' => 'true',
      'audited' => 0,
      'len' => 36,
  );

  $dictionary['Task']['fields']['realty_name'] =
  array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'realty_name',
      'vname' => 'LBL_REALTY_NAME',
      'type' => 'relate',
      'massupdate' => 0,
      'comments' => '',
      'help' => '',
      'audited' => 1,
      'len' => '100',
      'id_name' => 'realty_id',
      'ext2' => 'Realty',
      'module' => 'Realty',
      'rname' => 'name',
      'studio' => 'visible',
  );