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

            $infusionsoft = new \Infusionsoft\Infusionsoft(array(
                'clientId' => 'IoAJ9zFbZnszZHWkTxp7vFj5zg0TII2g',
                'clientSecret' => 'xS3oRvWe5kgcXjdG',
                'redirectUri' => 'https://framework.brightcloudstudioserver.com/registration-success.html',
            ));
        
            // If the serialized token is available in the session storage, we tell the SDK
            // to use that token for subsequent requests.
            if (isset($_SESSION['token'])) {
                $infusionsoft->setToken(unserialize($_SESSION['token']));
            }

            // If we are returning from Infusionsoft we need to exchange the code for an
            // access token.
            if (isset($_GET['code']) and !$infusionsoft->getToken()) {
                $infusionsoft->requestAccessToken($_GET['code']);

                // Save the serialized token to the current session for subsequent requests
                $_SESSION['token'] = serialize($infusionsoft->getToken());
            }

            function add($infusionsoft, $email)
            {
                // build out the json data to send to Keap
                
                // DATA - Contact Type
                $contact_type = 'Website Lead - EFS Myths';
                
                 // DATA - Email
                $email1 = new \stdClass;
                $email1->field = 'EMAIL1';
                $email1->email = $email;
                
                // DATA - Family Name
                $family_name = $arrData['lastname'];
                
                // DATA - Given Name
                $given_name = $arrData['firstname'];
                
                // DATA - Lead Source ID
                $lead_source_id = '19';
                
                // Entire Contact
                $contact = ['given_name' => $given_name, 'family_name' => $family_name, 'email_addresses' => [$email1], 'contact_type' => $contact_type, 'lead_source_id' => $lead_source_id];

                return $infusionsoft->contacts()->create($contact);
            }

            if ($infusionsoft->getToken()) {
                try {

                    //$email = 'john.doe4@example.com';
                    $email = $arrData['email'];

                    try {
                        $cid = $infusionsoft->contacts()->where('email', $email)->first();
                    } catch (\Infusionsoft\InfusionsoftException $e) {
                        $cid = add($infusionsoft, $email);
                    }

                } catch (\Infusionsoft\TokenExpiredException $e) {
                    // If the request fails due to an expired access token, we can refresh
                    // the token and then do the request again.
                    $infusionsoft->refreshAccessToken();

                    $cid = add($infusionsoft);
                }

                $contact = $infusionsoft->contacts()->with('custom_fields')->find($cid->id);

                var_dump($contact->toArray());

                // Save the serialized token to the current session for subsequent requests
                $_SESSION['token'] = serialize($infusionsoft->getToken());
            } else {
                echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
            }
        
        
        
        
        
            // Testing the controller log
            \Controller::log('Keap Integration: ' . $email . ' sent to Keap using API',
                __CLASS__ . '::' . __FUNCTION__,
                'GENERAL'
            );
        
        
        
        
        
        
    }
}
