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

class Handler
{
    protected static $arrUserOptions = array();

    public function newUserCreated($intId, $arrData, $objModule)
    {
        
        // Store the registration data.
        self::$arrUserOptions       = $arrData;
        self::$arrUserOptions['id'] = $intId;

	    // Retrieve the token from your saved file
    	$token_file = file_get_contents('token.txt');
    	$token = unserialize($token_file);
    
    	$infusionsoft = new \Infusionsoft\Infusionsoft(array(
    		'clientId'     => '2iqwVzl9wpZCxxpaUAyVOD819jXVIV1K',
    		'clientSecret' => 'dRn6D94SH5TRUZVM',
    		'redirectUri'  => 'https://www.epsteinfinancial.com/registration-page.html',
    	));
    
    	$infusionsoft->setToken($token);


        function add($infusionsoft, $email, $arrData)
        {
            // DATA - Contact Type
            $contact_type = 'Website Lead - EFS Myths';

             // DATA - Email
            $email1 = new \stdClass;
            $email1->field = 'EMAIL1';
            $email1->email = $email;

            // DATA - Family Name
            $family_name =  $arrData['lastname'];

            // DATA - Given Name
            $given_name =  $arrData['firstname'];
		
            // DATA - Lead Source ID
            //$lead_source_id =  67;

            // DATA - Contact Type
            //$contact_type =  'Prospect';

            // Entire Contact
            //$contact = ['contact_type' => $contact_type, 'lead_source_id' => $lead_source_id, 'given_name' => $given_name, 'family_name' => $family_name, 'email_addresses' => [$email1]];
            $contact = ['given_name' => $given_name, 'family_name' => $family_name, 'email_addresses' => [$email1]];

            return $infusionsoft->contacts()->create($contact);
        }

	    // STEP 3 - WE HAVE A TOKEN
        if ($infusionsoft->getToken()) {
            try {
                $email = $arrData['email'];
                try {
                    $cid = $infusionsoft->contacts()->where('email', $email)->first();
                } catch (\Infusionsoft\InfusionsoftException $e) {
                    $cid = add($infusionsoft, $email, $arrData);
                }
            } catch (\Infusionsoft\TokenExpiredException $e) {
    		// our token is expired
    		$infusionsoft->refreshAccessToken();
    		$cid = add($infusionsoft);
	    }

            //$contact = $infusionsoft->contacts()->with('custom_fields')->find($cid->id);
            
            // update the Contact with the rest of the details
            $contact = $infusionsoft->contacts()->find($cid->id);
            $contact->given_name = $arrData['firstname'];
            $contact->family_name = $arrData['lastname'];
            $contact->contact_type = 'Prospect'
            $contact->lead_source_id = 67;
            
            // DATA - Address
            $address = new \stdClass;
            $address->field = 'BILLING';
            $address->line1 = $arrData['street'];
            $address->locality = $arrData['city'];
            $address->region = $arrData['state'];
            $address->postal_code = $arrData['postal'];
            $address->zip_code = $arrData['postal'];
            
            $contact->addresses = [$address];
            
            $contact->save();
            
            //var_dump($contact->toArray());
		
            // Add our user to the requested campaign
            $integration = 'suz811';
            $callName = 'MythsAPICall';
            $infusionsoft->funnels()->achieveGoal($integration, $callName, $cid->id);
            
            
            // Save the serialized token to the current session for subsequent requests
            $_SESSION['token'] = serialize($infusionsoft->getToken());
        }
        
        // Testing the controller log
        \Controller::log('Keap Integration: ' . $email . ' sent to Keap using API',
            __CLASS__ . '::' . __FUNCTION__,
            'GENERAL'
        );
    }
    
    
    
    public function accountActivated($member, $module)
    {
        // Do Stuff
        
        // Testing the controller log
        \Controller::log('Keap Integration: Member Account Activated',
            __CLASS__ . '::' . __FUNCTION__,
            'GENERAL'
        );
    }
    
    
    public function storeRefreshToken($objModule, $token)
    {
        $strType = '';
        $query = \Database::getInstance()
            ->prepare("UPDATE `tl_module` SET `keapRefreshToken` = '".$token."' WHERE `tl_module`.`id` = ".$objModule->id.";")
            ->execute($strType);
    }
    public function storeAccessToken($objModule, $token)
    {
        $strType = '';
        $query = \Database::getInstance()
            ->prepare("UPDATE `tl_module` SET `keapAccessToken` = '".$token."' WHERE `tl_module`.`id` = ".$objModule->id.";")
            ->execute($strType);
    }
    public function storeJSONToken($objModule, $token)
    {
        $strType = '';
        $query = \Database::getInstance()
            ->prepare("UPDATE `tl_module` SET `keapJSONToken` = '".$token."' WHERE `tl_module`.`id` = ".$objModule->id.";")
            ->execute($strType);
    }
    
}
