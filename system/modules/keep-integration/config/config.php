<?php

/**
 * Bright Cloud Studio's Add User Fields
 *
 * Copyright (C) 2021 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/add-user-fields
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
**/

/* Hooks */
if (\Config::getInstance()->isComplete()) {
  $GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('CustomTags\AddUserFieldsTags', 'onReplaceTag');
}
