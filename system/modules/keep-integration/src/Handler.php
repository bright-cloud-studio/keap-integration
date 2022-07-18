<?php

/**
 * Bright Cloud Studio's Keap Integration
 *
 * @copyright  2022 Bright Cloud Studio
 * @package    keap_integration
 * @license    GNU/LGPL
 * @filesource
 */

namespace KeapIntegration;


/**
 * Class keap_integration
 *
 * @package KeapIntegration
 */
class Handler
{
    /**
     * Must be static because the loadLanguageFile hook call the method
     * without an instance. so we need a static property here ...
     *
     * @var array
     */
    protected static $arrUserOptions = array();

    /**
     * Send an email if a new user registers on the contao installation.
     *
     * @param int     $intId     The id of the new member.
     *
     * @param array   $arrData   The data of the new member.
     *
     * @return void
     */
    public function newUserCreated($intId, $arrData, $objModule)
    {
            // Store the registration data.
            self::$arrUserOptions       = $arrData;
            self::$arrUserOptions['id'] = $intId;
        
            // Testing the controller log
            \Controller::log('Keap Integration: the newUserCreated function has been triggered.',
                __CLASS__ . '::' . __FUNCTION__,
                'GENERAL'
            );
        
    }
}
