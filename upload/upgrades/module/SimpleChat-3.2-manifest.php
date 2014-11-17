	<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

	$manifest = array (
		 'acceptable_sugar_versions' =>
		  array (
            'regex_matches' => array (
              '6\.[3-9]\.*',
            ),
		  ),
		  'acceptable_sugar_flavors' =>
		  array(
		  	'CE', 'PRO','ENT'
		  ),
		  'readme'=>'',
		  'key'=>'let',
		  'author' => 'Letrium',
		  'description' => 'Simple Chat - simple way to communicate among SugarCRM users',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'Simple Chat for SugarCRM',
		  'published_date' => '2013-01-17',
		  'type' => 'module',
		  'version' => '3.2',
		  'remove_tables' => 'prompt',
		  );
$installdefs = array (
  'id' => 'Letrium',
  'beans' => 
  array (
    0 =>
    array (
      'module' => 'let_Chat',
      'class' => 'let_Chat',
      'path' => 'modules/let_Chat/let_Chat.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
  ),
  'relationships' =>
  array (
  ),
  'copy' =>
  array (
    array (
      'from' => '<basepath>/modules/let_Chat',
      'to' => 'modules/let_Chat',
    ),
    array (
      'from' => '<basepath>/others/Administration/simple_chat.php',
      'to' => 'custom/Extension/modules/Administration/Ext/Administration/simple_chat.php',
    ),
  ),
 'logic_hooks' => array(
	array(
		'module' => '',
		'hook' => 'after_ui_footer',
		'order' => 99,
		'description' => '',
		'file' => 'modules/let_Chat/show_chat.php',
		'class' => 'simple_chat',
		'function' => 'show',
		), 
	),  
  'language' =>
  array (
    array (
      'from' => '<basepath>/language/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    array (
      'from' => '<basepath>/others/Administration/en_us.simple_chat.php',
      'to_module' => 'Administration',
      'language' => 'en_us',
    ),
  ),
);
