<?php
// created: 2013-09-19 16:39:19
$dictionary["Note"]["fields"]["realty_notes_1"] = array (
  'name' => 'realty_notes_1',
  'type' => 'link',
  'relationship' => 'realty_notes_1',
  'source' => 'non-db',
  'vname' => 'LBL_REALTY_NOTES_1_FROM_REALTY_TITLE',
  'id_name' => 'realty_notes_1realty_ida',
);
$dictionary["Note"]["fields"]["realty_notes_1_name"] = array (
  'name' => 'realty_notes_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_REALTY_NOTES_1_FROM_REALTY_TITLE',
  'save' => true,
  'id_name' => 'realty_notes_1realty_ida',
  'link' => 'realty_notes_1',
  'table' => 'realty',
  'module' => 'Realty',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["realty_notes_1realty_ida"] = array (
  'name' => 'realty_notes_1realty_ida',
  'type' => 'link',
  'relationship' => 'realty_notes_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_REALTY_NOTES_1_FROM_NOTES_TITLE',
);
