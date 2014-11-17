<?php 
$module_name = 'sugartalk_SMS';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => array (
		'form' => array ('buttons' => array ('EDIT', 'DUPLICATE', 'DELETE', array('customCode' => '{$APP.RESEND_BUTTON}'))),
		'maxColumns' => '2',
		'widths' => array ( 
					array ('label' => '10', 'field' => '30', ), 
					array ('label' => '10', 'field' => '30', ),
					),
		),
	
    'panels' => 
    array (
      'default' => 
      array ( 
        array (
          'name',
        ), 
        array ( 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ), 
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
		 
        array ( 
          array (
            'name' => 'phone_number',
			'studio' => 'visible',
            'label' => 'LBL_PHONE_NUMBER',
          ), 
          array (
            'name' => 'type',
            'studio' => 'visible',
            'label' => 'LBL_TYPE',
          ),
        ),
		
        array (
			'description',
			array (
				'name' => 'parent_name',
				'customLabel' => '{sugar_translate label=\'LBL_MODULE_NAME\' module=$fields.parent_type.value}', 
			), 
        ),
		
        array ( 
          array (
            'name' => 'api_message',
            'label' => 'LBL_API_MESSAGE',
          ),
        ),
      ),
    ),
  ),
);
?>
