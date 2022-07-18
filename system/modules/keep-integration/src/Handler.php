<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2016
 * @package    registration_info_mailer
 * @license    GNU/LGPL
 * @filesource
 */

namespace RegistrationInfoMailer;

use NotificationCenter\Model\Notification;

/**
 * Class registration_info_mailer
 *
 * @package RegistrationInfoMailer
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
     * @param \Module $objModule The module and his current settings.
     *
     * @return void
     */
    public function sendRegistrationMail($intId, $arrData, $objModule)
    {
        // Check if the registration mail should be send.
        if ($objModule->rim_active == 1) {
            // Store the registration data.
            self::$arrUserOptions       = $arrData;
            self::$arrUserOptions['id'] = $intId;

            // Check if we have all needed data.
            if (!strlen($objModule->rim_mailtemplate)) {
                \Controller::log(
                    'RIM: failed to send the registration mail. The module needs more email information. Please check the module configuration.',
                    __CLASS__ . '::' . __FUNCTION__,
                    'ERROR'
                );

                return;
            }

            /** @var Notification $objNotification */
            $objNotification = Notification::findByPk($objModule->rim_mailtemplate);
            if (null !== $objNotification) {
                $arrTokens = $arrData;
                $objNotification->send($arrTokens, $arrData['language']); // Language is optional
            }

            // Log to tl_log if the user set the option.
            if ($objModule->rim_do_syslog == 1) {
                \Controller::log('RIM: a registration info mail has been send. Check your email.log for more information.',
                    __CLASS__ . '::' . __FUNCTION__,
                    'GENERAL'
                );
            }

            // done :) lets cleanup and get some food, maybe a big pizza or a nice tasty burger.
            unset($objMail);
        }
    }
}
