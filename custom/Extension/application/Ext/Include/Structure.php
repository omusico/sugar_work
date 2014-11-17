<?php 
 //WARNING: The contents of this file are auto-generated
$beanList['Branch'] = 'Branch';
$beanFiles['Branch'] = 'modules/Branch/Branch.php';
$moduleList[] = 'Branch';
$beanList['Department'] = 'Department';
$beanFiles['Department'] = 'modules/Department/Department.php';
$moduleList[] = 'Department';


$moduleList[] = 'ProjectTask';

foreach($modInvisList as $id => $module) {
    if($module == 'ProjectTask') {
        unset($modInvisList[$id]);
    }
}  
?>