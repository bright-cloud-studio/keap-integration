<?php

namespace KeapIntegration;

use Contao\System;

class EventListener extends System
{
    public function refreshKeapToken(): void
    {
       
        // Testing the controller log
        \Controller::log('Keap: Attempting Refresh',
            __CLASS__ . '::' . __FUNCTION__,
            'GENERAL'
        );
       
        // Retrieve the token from your saved file
        $token_file = file_get_contents('token.txt');
        $print_token = $token_file;
        $token = unserialize($token_file);

        $infusionsoft = new \Infusionsoft\Infusionsoft(array(
          'clientId'     => '2iqwVzl9wpZCxxpaUAyVOD819jXVIV1K',
          'clientSecret' => 'dRn6D94SH5TRUZVM',
          'redirectUri'  => 'https://epsteinfinancial.com/keap_auth.php',
        ));

        $infusionsoft->setToken($token);

        // Refresh the token
        $refreshed_token = $infusionsoft->refreshAccessToken();
        $_SESSION['token'] = serialize($refreshed_token);

        // Save it to the token file 
        $file_handle = fopen('token.txt', 'w');
        fwrite($file_handle, serialize($refreshed_token));

         // Testing the controller log
        \Controller::log('Keap: Token Reset - ' . serialize($refreshed_token) . '.',
            __CLASS__ . '::' . __FUNCTION__,
            'GENERAL'
        );
    }
}
