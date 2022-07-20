<?php

// Modify registration palette
$GLOBALS['TL_DCA']['tl_module']['palettes']['registration'] = str_replace(
    'protected;',
    'protected;{keapIntegration_legend},keapCliendID,keapClientSecret,keapRedirectUrl;',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['registration']
);

// Add fields
$GLOBALS['TL_DCA']['tl_module']['fields']['keapCliendID'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['keapCliendID'],
    'inputType'               => 'text',
    'default'		          => '',
    'search'                  => true,
    'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['keapClientSecret'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['keapClientSecret'],
    'inputType'               => 'text',
    'default'		          => '',
    'search'                  => true,
    'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['keapRedirectUrl'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['keapRedirectUrl'],
    'inputType'               => 'text',
    'default'		          => '',
    'search'                  => true,
    'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
];



