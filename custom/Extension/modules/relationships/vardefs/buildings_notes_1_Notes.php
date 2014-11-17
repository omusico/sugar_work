<?php
// created: 2013-09-19 16:38:29
$dictionary["Note"]["fields"]["buildings_notes_1"] = array (
  'name' => 'buildings_notes_1',
  'type' => 'link',
  'relationship' => 'buildings_notes_1',
  'source' => 'non-db',
  'vname' => 'LBL_BUILDINGS_NOTES_1_FROM_BUILDINGS_TITLE',
  'id_name' => 'buildings_notes_1buildings_ida',
);
$dictionary["Note"]["fields"]["buildings_notes_1_name"] = array (
  'name' => 'buildings_notes_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BUILDINGS_NOTES_1_FROM_BUILDINGS_TITLE',
  'save' => true,
  'id_name' => 'buildings_notes_1buildings_ida',
  'link' => 'buildings_notes_1',
  'table' => 'buildings',
  'module' => 'Buildings',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["buildings_notes_1buildings_ida"] = array (
  'name' => 'buildings_notes_1buildings_ida',
  'type' => 'link',
  'relationship' => 'buildings_notes_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_BUILDINGS_NOTES_1_FROM_NOTES_TITLE',
);
