<?php

// manifest file for information regarding application of new code
$manifest = array(
    // only install on the following regex sugar versions (if empty, no check)
    'acceptable_sugar_versions' => array (
        'regex_matches' => array (
            0 => "6\\.*",
        ),
	),

    // name of new code
    'name' => 'GoogleCalSync',

    // description of new code
    'description' => 'Hidden Module for automatic Google Syncronisation',

    // author of new code
    'author' => 'EMPPOR GmbH',

    // date published
    'published_date' => '2008/01/24',

    // version of code
    'version' => '0.20',

    // type of code (valid choices are: full, langpack, module, patch, theme )
    'type' => 'module',

    // icon for displaying in UI (path to graphic contained within zip package)
    'icon' => 'module/GoogleSync/icon.gif',
    
    'is_uninstallable' => true,
);



$installdefs = array(
    'id'=> 'GoogleSync',
    //'image_dir'=>'<basepath>/images',
    'copy' => array(
        array('from'=> '<basepath>/module/GoogleSync',
            'to'=> 'modules/GoogleSync',
        ),
        array('from'=> '<basepath>/include/ZendGdata',
            'to'=> 'include/ZendGdata',
        ),
	array('from'=> '<basepath>/custom/modules/Schedulers/_AddJobsHere.php',
            'to'=> 'custom/modules/Schedulers/_AddJobsHere.php',
        ),
	array('from'=> '<basepath>/custom/modules/Schedulers/language/ru_ru.lang.php',
            'to'=> 'custom/modules/Schedulers/language/ru_ru.lang.php',
        ),
	array('from'=> '<basepath>/custom/modules/Schedulers/language/en_us.lang.php',
            'to'=> 'custom/modules/Schedulers/language/en_us.lang.php',
        ),
    ),
    'beans'=> array(
        array('module'=> 'GoogleSync',
            'class' => 'GoogleSync',
            'path'=> 'modules/GoogleSync/GoogleSync.php',
            'tab'=> false,
        ),
    ),
);
?>
