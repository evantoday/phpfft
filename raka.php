<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
/////// CONFIG ///////
$username = 'echaclrs';
$password = 'Faycantik123';
$ig = new \InstagramAPI\Instagram(false);
 $loginResponse = $ig->login($username, $password);

    if (!is_null($loginResponse) && $loginResponse->isTwoFactorRequired()) {
        $twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();

         // The "STDIN" lets you paste the code via terminal for testing.
         // You should replace this line with the logic you want.
         // The verification code will be sent by Instagram via SMS.
        $verificationCode = trim(fgets(STDIN));
        $ig->finishTwoFactorLogin($verificationCode, $twoFactorIdentifier);
    }