<?php

/**
 * Member contact settings extension for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2017 Contao Bayern
 * @author     Jörg Moldenhauer
 * @author     Andreas Fieger
 * @license    https://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 *
 * @see        https://github.com/ContaoBayern/contao-member-contact-settings
 */

// Legends
$GLOBALS['TL_LANG']['tl_module']['keapIntegration_legend'] = 'Keap Integration Settings';

// Fields
$GLOBALS['TL_LANG']['tl_module']['keapCliendID'] = ['API Client ID', 'Enter the Keap app\'s Client ID.'];
$GLOBALS['TL_LANG']['tl_module']['keapClientSecret'] = ['API Client Secret', 'Enter the Keap app\'s Client Secret.'];
$GLOBALS['TL_LANG']['tl_module']['keapRedirectUrl'] = ['API Redirect URL', 'Enter the URL to be redirected to after successfully passing data to Keap.'];

// oauth2
$GLOBALS['TL_LANG']['tl_module']['keapRefreshToken'] = ['Keap Refresh Token', 'Lifetime: Six Months'];
$GLOBALS['TL_LANG']['tl_module']['keapAccessToken'] = ['Keap Access Token', 'Lifetime: 24 Hours'];
