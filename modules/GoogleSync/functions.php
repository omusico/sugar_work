<?php
/*******************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * 
 * The Original Code is: SugarCRM Open Source
 * 
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): EMPPOR GmbH
 ******************************************************************************/

if (!function_exists("toTimestamp")) {
function toTimestamp($d, &$hastime = null) { // TODO: mit Auslagern AACHTUNG: PHP5 only (&hastime = null)
    $time = null;
    global $timedate;
    $hastime = false;
    if (is_int($d) || (function_exists("ctype_digit") && ctype_digit($d))) {
        $time = $d;
        $hastime = true;;
    } elseif (preg_match("/^\d{4}\-\d{2}\-\d{2}/", $d)) {
        if (strpos($d, " ") > 0) $hastime = true;
        $time = strtotime($d);
    } else {
        if (strpos($d, " ") > 0) {
            $hastime = true;
            $time = strtotime($timedate->to_db_date_time($d));
        } else {
            $d .= " ".date($timedate->get_time_format(),0);
            $time= strtotime($timedate->to_db_date($d));
        }
    }
    return $time;
}}

?>
