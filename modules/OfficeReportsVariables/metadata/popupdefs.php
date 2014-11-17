<?php
$popupMeta = array (
    'moduleMain' => 'OfficeReportsVariables',
    'varName' => 'OfficeReportVariable',
    'orderBy' => 'OfficeReportsVariables.name',
    'whereClauses' => array (
  'name' => 'OfficeReportsVariables.name',
  'friendly_name' => 'officereportsvariables.friendly_name',
),
    'searchInputs' => array (
  1 => 'name',
  7 => 'friendly_name',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'friendly_name' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FRIENDLY_NAME',
    'width' => '10%',
    'name' => 'friendly_name',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'FRIENDLY_NAME' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_FRIENDLY_NAME',
    'width' => '10%',
    'default' => true,
  ),
),
);
