
<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
/////// CONFIG ///////
$username = 'evannurr';
$password = 'sihdaunix123';
$debug = true;
$truncatedDebug = false;
//////////////////////
$ig = new \InstagramAPI\Instagram(false,false);
 $loginResponse = $ig->login($username, $password);

    if (!is_null($loginResponse) && $loginResponse->isTwoFactorRequired()) {
        $twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();

         // The "STDIN" lets you paste the code via terminal for testing.
         // You should replace this line with the logic you want.
         // The verification code will be sent by Instagram via SMS.
        $verificationCode = trim(fgets(STDIN));
        $ig->finishTwoFactorLogin($verificationCode, $twoFactorIdentifier);
    }
 $rankToken = \InstagramAPI\Signatures::generateUUID();
try {
	$userId = $ig->people->getUserIdForName('vivalatino');
    $maxId = null;
    do {
		$response = $ig->people->getFollowers($userId,$rankToken,null,$maxId);
		echo $response->getUsers()->getUsername();
        $maxId = $response->getNextMaxId();
    } while ($maxId !== null);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
};