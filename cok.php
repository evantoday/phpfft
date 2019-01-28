
<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
/////// CONFIG ///////
$username = '';
$password = '';
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
    $following = [];
	$userId = $ig->people->getUserIdForName('tahusunduk');
    $maxId = null;
    do {
		$response = $ig->people->getFollowers($userId,$rankToken,null,$maxId);
		foreach($response->getUsers() as $mothy){
		   $idcok = $mothy->getPk();
		   $info = $ig->people->getFriendship($idcok);
		   if(($info->getFollowing()) == false){
		   $fallaw = $ig->people->follow($idcok);
		   echo $mothy->getUsername() . " ====>>> " .$fallaw->getStatus();
		   echo "\n";
		   sleep(10);
		   }else{
		       echo "sudah follow ". $mothy->getUsername()."cok jadi di skip cok '\n'";
		   }
		}
        $maxId = $response->getNextMaxId();
    } while ($maxId !== null);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}