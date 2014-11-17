<?php
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

$manifest = array (
	 'acceptable_sugar_versions' => 
	  array (
		 'regex_matches' => array (
		0 => "6.3.*",
		1 => "6.4.*",
	       2 => "6.5.*",
	      ),
	  ),
	  'acceptable_sugar_flavors' =>
	  array(
		'CE','OS'
	  ),
	  'readme'=>'',
	  'key'=>'sugartalk',
	  'author' => 'sugartalk',
	  'description' => 	'sugartalk SMS позволяет отправлять текстовые сообщения из формы просмотра или из формы списка. ' .
						'Он также позволяет отправлять SMS уведомлений через маркетинговые кампании. ',
	  'icon' => '',
	  'is_uninstallable' => true,
	  'name' => 'sugartalk_SMS',
	  'published_date' => '2011-01-19',
	  'type' => 'module',
	  'version' => '1.1.2', 
	  );
		  
		  
$installdefs = array (
  'id' => 'sugartalk_SMS',
  'beans' => 
  array ( 
    array (
      'module' => 'sugartalk_SMS',
      'class' => 'sugartalk_SMS',
      'path' => 'modules/sugartalk_SMS/sugartalk_SMS.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
  ),
  'relationships' => 
  array (
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array ( 
		array(
			'from' => '<basepath>/smsReceive.php',
			'to' => 'smsReceive.php',
		), 
		array (
		  'from' => '<basepath>/SugarModules/modules/sugartalk_SMS',
		  'to' => 'modules/sugartalk_SMS',
		),
		array(
			'from' => '<basepath>/sms',
			'to' => 'custom/sms',
		), 
		array(
			'from' => '<basepath>/Administration',
			'to' => 'modules/Administration',
		),  
		array(
			'from' => '<basepath>/sms_phone_fields.php',
			'to' => 'custom/fieldFormat/sms_phone_fields.php',
		),
		array(
			'from' => '<basepath>/include/generic/SugarWidgets/SugarWidgetSubPanelSMSButton.php',
			'to' => 'include/generic/SugarWidgets/SugarWidgetSubPanelSMSButton.php',
		), 
		array(
			'from' => '<basepath>/include/generic/LayoutManager.php',
			'to' => 'include/generic/LayoutManager.php',
		), 
		array(
			'from' => '<basepath>/include/ListView/ListViewDisplay.php',
			'to' => 'include/ListView/ListViewDisplay.php',
		),		
		array(
			'from' => '<basepath>/modules/EmailTemplates/EditView.php',
			'to' => 'modules/EmailTemplates/EditView.php',
		),
		array(
			'from' => '<basepath>/modules/EmailTemplates/EditViewMain.html',
			'to' => 'modules/EmailTemplates/EditViewMain.html',
		),
		array(
			'from' => '<basepath>/modules/EmailTemplates/DetailView.php',
			'to' => 'modules/EmailTemplates/DetailView.php',
		),
		array(
			'from' => '<basepath>/modules/EmailTemplates/DetailView.html',
			'to' => 'modules/EmailTemplates/DetailView.html',
		),
		array(
			'from' => '<basepath>/modules/EmailTemplates/metadata/searchdefs.php',
			'to' => 'modules/EmailTemplates/metadata/searchdefs.php',
		),
		array(
			'from' => '<basepath>/modules/EmailTemplates/metadata/listviewdefs.php',
			'to' => 'modules/EmailTemplates/metadata/listviewdefs.php',
		),
		array(
			'from' => '<basepath>/modules/EmailTemplates/EmailTemplate.js',
			'to' => 'modules/EmailTemplates/EmailTemplate.js',
		),
		array(
			'from' => '<basepath>/modules/EmailMarketing/EditView.php',
			'to' => 'modules/EmailMarketing/EditView.php',
		),
		
		array(
			'from' => '<basepath>/modules/EmailMarketing/language/en_us.lang.php',
			'to' => 'modules/EmailMarketing/language/en_us.lang.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/language/en_us.lang.php',
			'to' => 'modules/Campaigns/language/en_us.lang.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/language/sms.lang.php',
			'to' => 'modules/Campaigns/language/sms.lang.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/tpls/WizardHomeStart.tpl',
			'to' => 'modules/Campaigns/tpls/WizardHomeStart.tpl',
		), 
		array(
			'from' => '<basepath>/modules/Campaigns/tpls/WizardCampaignTargetListForNonNewsLetter.tpl',
			'to' => 'modules/Campaigns/tpls/WizardCampaignTargetListForNonNewsLetter.tpl',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/views/view.detail.php',
			'to' => 'modules/Campaigns/views/view.detail.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/TrackDetailView.php',
			'to' => 'modules/Campaigns/TrackDetailView.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/WizardHome.php',
			'to' => 'modules/Campaigns/WizardHome.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/WizardMarketing.html',
			'to' => 'modules/Campaigns/WizardMarketing.html',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/WizardMarketing.php',
			'to' => 'modules/Campaigns/WizardMarketing.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/WizardNewsletter.php',
			'to' => 'modules/Campaigns/WizardNewsletter.php',
		),
		array(
			'from' => '<basepath>/modules/Campaigns/QueueCampaign.php',
			'to' => 'modules/Campaigns/QueueCampaign.php',
		),
		array(
			'from' => '<basepath>/modules/EmailMan/EmailMan.php',
			'to' => 'modules/EmailMan/EmailMan.php',
		),
		array(
			'from' => '<basepath>/modules/EmailMan/EmailManDelivery.php',
			'to' => 'modules/EmailMan/EmailManDelivery.php',
		),
		array(
			'from' => '<basepath>/modules/EmailMan/SMSManDelivery.php',
			'to' => 'modules/EmailMan/SMSManDelivery.php',
		),
		array(
			'from' => '<basepath>/modules/EmailMarketing/EditView.html',
			'to' => 'modules/EmailMarketing/EditView.html',
		),
		array(
			'from' => '<basepath>/modules/EmailMarketing/DetailView.php',
			'to' => 'modules/EmailMarketing/DetailView.php',
		),
		array(
			'from' => '<basepath>/modules/EmailMarketing/DetailView.html',
			'to' => 'modules/EmailMarketing/DetailView.html',
		),
		array(
			'from' => '<basepath>/modules/Schedulers/language/en_us.lang.php',
			'to' => 'modules/Schedulers/language/en_us.lang.php',
		), 
		array(
			'from' => '<basepath>/custom/modules/sugartalk_SMS/Hook.php',
			'to' => 'custom/modules/sugartalk_SMS/Hook.php',
		), 
		array(
			'from' => '<basepath>/custom/modules/sugartalk_SMS/logic_hooks.php',
			'to' => 'custom/modules/sugartalk_SMS/logic_hooks.php',
		), 
  ),
  
  'administration' => 
  array( 
    array(
       'from' => '<basepath>/sms.ext.php',
    ),
  ), 
  'language' => 
  array ( 
    array (
      'from' 		=> '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' 	=> 'application',
      'language' 	=> 'en_us',
    ),
      array (
      'from' 		=> '<basepath>/SugarModules/language/application/ru_ru.lang.php',
      'to_module' 	=> 'application',
      'language' 	=> 'ru_ru',
    ),
	array (
      'from' 		=> '<basepath>/ext/Language/EmailTemplates/en_us.for_sms_lang.php',
      'to_module' 	=> 'EmailTemplates',
      'language' 	=> 'en_us',
    ),
      array (
      'from' 		=> '<basepath>/ext/Language/EmailTemplates/ru_ru.for_sms_lang.php',
      'to_module' 	=> 'EmailTemplates',
      'language' 	=> 'ru_ru',
    ),
  ),
  'vardefs' => array(
     array(
       'from'		=> '<basepath>/ext/Vardefs/EmailTemplates/for_sms.php', 
       'to_module'	=> 'EmailTemplates',
     ),
	 array(
       'from'		=> '<basepath>/ext/Vardefs/Employees/sms_fields_for_employees.php', 
       'to_module'	=> 'Employees',
     ),
   ),

);
