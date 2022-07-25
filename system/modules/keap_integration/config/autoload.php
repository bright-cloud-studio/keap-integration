<?php

/**
 * Bright Cloud Studio's Keap Integration
 *
 * Copyright (C) 2022 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/keap_integration
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
**/


/* Register Classes */
ClassLoader::addClasses(array
(
	'KeapIntegration\Handler' => 'system/modules/keap_integration/src/Handler.php'
	'KeapIntegration\EventListener' => 'system/modules/keap_integration/src/EventListener.php'
));
