<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


$module_name='Realty';
$subpanel_layout = array(
//	'top_buttons' => array(
//		array('widget_class' => 'SubPanelTopCreateButton'),
//		array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $module_name),
//	),

	'where' => '',

	'list_fields' => array(
		'name'=>array(
	 		'vname' => 'LBL_NAME',
			'widget_class' => 'SubPanelDetailViewLink',
	 		'width' => '15%',
		),
        'totalcost'=>array(
            'vname' => 'LBL_TOTALCOST',
            'width' => '15%',
        ),

         'currency'=> array
         (
                'vname'=>'LBL_CURRENCY',
                'width'=>'10%',
          ),
		  
		'presentation_checked' =>array (
			'vname' => 'LBL_PRESENTATION_CHECKED',
			'width' => '5%',
			'default' => true,
			'sortable' => false,
		),
		'presentation_text' => array (
			'type' => 'varchar',
			'vname' => 'LBL_PRESENTATION_TEXT',
			'width' => '10%',
			'default' => true,
		),
		
        'square'=>array(
            'vname' => 'LBL_SQUARE',
            'width' => '15%',
        ),
        'operation'=>array(
            'vname' => 'LBL_OPERATION',
            'width' => '15%',
        ),
        'address_street'=>array(
            'vname' => 'LBL_ADDRESS_STREET',
            'width' => '15%',
        ),
        'date_entered'=>array(
            'vname' => 'LBL_DATE_ENTERED',
            'width' => '15%',
        ),
		'date_modified'=>array(
	 		'vname' => 'LBL_DATE_MODIFIED',
	 		'width' => '15%',
		),
//		'edit_button'=>array(
//            'vname' => 'LBL_EDIT_BUTTON',
//			'widget_class' => 'SubPanelEditButton',
//		 	'module' => $module_name,
//	 		'width' => '4%',
//		),
//		'remove_button'=>array(
//            'vname' => 'LBL_REMOVE',
//			'widget_class' => 'SubPanelRemoveButton',
//		 	'module' => $module_name,
//			'width' => '5%',
//		),
          'interest_button'=>array
            (
              'vname'=>'LBL_INTEREST',
              'module'=> $module_name,
              'width'=>'5%',
              'widget_class' => 'SubPanelInterestButton',
            ),

	),
);

?>