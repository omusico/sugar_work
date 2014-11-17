<?php
// created: 2014-03-17 16:54:24
$dictionary["mark_mark_costs"]["fields"]["realty_mark_mark_costs_1"] = array (
  'name' => 'realty_mark_mark_costs_1',
  'type' => 'link',
  'relationship' => 'realty_mark_mark_costs_1',
  'source' => 'non-db',
  'vname' => 'LBL_REALTY_MARK_MARK_COSTS_1_FROM_REALTY_TITLE',
  'id_name' => 'realty_mark_mark_costs_1realty_ida',
);
$dictionary["mark_mark_costs"]["fields"]["realty_mark_mark_costs_1_name"] = array (
  'name' => 'realty_mark_mark_costs_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_REALTY_MARK_MARK_COSTS_1_FROM_REALTY_TITLE',
  'save' => true,
  'id_name' => 'realty_mark_mark_costs_1realty_ida',
  'link' => 'realty_mark_mark_costs_1',
  'table' => 'realty',
  'module' => 'Realty',
  'rname' => 'name',
);
$dictionary["mark_mark_costs"]["fields"]["realty_mark_mark_costs_1realty_ida"] = array (
  'name' => 'realty_mark_mark_costs_1realty_ida',
  'type' => 'link',
  'relationship' => 'realty_mark_mark_costs_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_REALTY_MARK_MARK_COSTS_1_FROM_MARK_MARK_COSTS_TITLE',
);
