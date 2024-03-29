<?PHP
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Professional Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-professional-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2010 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/sugartalk_SMS/sugartalk_SMS_sugar.php');
class sugartalk_SMS extends sugartalk_SMS_sugar {
	
	function sugartalk_SMS(){
		parent::sugartalk_SMS_sugar();
		global $app_strings;
		if ($GLOBALS['action'] == 'DetailView') {
			if ($_REQUEST['module']=='sugartalk_SMS' and isset($_REQUEST['record'])) {
				require_once("modules/Administration/sugartalk_smsPhone/smsPhone.js.php");
				$btn = $this->type=='inbound' ? 'Reply' : 'Resend';
				$app_strings['RESEND_BUTTON'] = '<input type="button" class="button" id="resend_sms" onclick="load_sms_for_resending();" value="'.$btn.'" >';
			} 
		}

	}
	
}
?>