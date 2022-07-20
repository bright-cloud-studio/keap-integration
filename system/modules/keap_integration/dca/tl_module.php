<?php

// Modify registration palette
$GLOBALS['TL_DCA']['tl_module']['palettes']['registration'] = str_replace(
    'disableCaptcha;',
    'disableCaptcha;{fieldDependencySettings_legend},mcsUseJavaScript;',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['registration']
);

// Add fields
$GLOBALS['TL_DCA']['tl_module']['fields']['mcsUseJavaScript'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['mcsUseJavaScript'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true
    ],
    'sql' => "char(1) NOT NULL default '1'",
];
