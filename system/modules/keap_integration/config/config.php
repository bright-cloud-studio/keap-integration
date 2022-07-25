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

/* Hooks */
$GLOBALS['TL_HOOKS']['createNewUser'][]      = array('KeapIntegration\Handler', 'newUserCreated');
$GLOBALS['TL_HOOKS']['activateAccount'][]    = array('KeapIntegration\Handler', 'accountActivated');

/* Crons */
$GLOBALS['TL_CRON']['minutely'][] = ['KeapIntegration\EventListener\CronListener', 'refreshKeapToken'];
