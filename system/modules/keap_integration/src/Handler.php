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

		// STEP 1 - set up infusionsoft
        //$infusionsoft = new \Infusionsoft\Infusionsoft(array(
         //   'clientId' => $objModule->keapCliendID,
         //   'clientSecret' => $objModule->keapClientSecret,
         //   'redirectUri' => $objModule->keapRedirectUrl,
        //));

		// STEP 2 - if there us a token, apply it
		//$infusionsoft->setToken(unserialize($objModule->keapJSONToken));
		
		// Retrieve the token from your saved file
    	$token_file = file_get_contents('/token.txt');
    	$token = unserialize($token_file);
    
    	$infusionsoft = new \Infusionsoft\Infusionsoft(array(
    		'clientId'     => 'IoAJ9zFbZnszZHWkTxp7vFj5zg0TII2g',
    		'clientSecret' => 'xS3oRvWe5kgcXjdG',
    		'redirectUri'  => 'https://framework.brightcloudstudioserver.com/keap_auth.php',
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
            $lead_source_id = '19';

            // Entire Contact
            $contact = ['given_name' => $given_name, 'family_name' => $family_name, 'email_addresses' => [$email1]];

            return $infusionsoft->contacts()->create($contact);
        }

		// STEP 3 - WE HAVE A TOKEN
        if ($infusionsoft->getToken()) {
            echo 'WE HAVE A TOKEN';
            try {
                $email = $arrData['email'];
                try {
                    $cid = $infusionsoft->contacts()->where('email', $email)->first();
                } catch (\Infusionsoft\InfusionsoftException $e) {
                    $cid = add($infusionsoft, $email, $arrData);
                }
            } catch (\Infusionsoft\TokenExpiredException $e) {
    		// our token is expired
    		echo "TOKEN EXPIRED";
    		$infusionsoft->refreshAccessToken();
    		$cid = add($infusionsoft);
	    }

            $contact = $infusionsoft->contacts()->with('custom_fields')->find($cid->id);

            var_dump($contact->toArray());
            
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
