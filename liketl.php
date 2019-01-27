
<?php
while(true){
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
$maxID = null;
do{
$response = $ig->timeline->getTimelineFeed($maxID);
foreach($response->getFeedItems() as $item){
    if($item->getMediaOrAd() !== null){
    $mumet = $item->getMediaOrAd()->getId();
    $ndasemumet = $ig->media->like($mumet);
    echo $ndasemumet . "sayaanggg ===> " .$mumet . "\n";
    $cekcok = $item->getMediaOrAd()->getHasLiked();
    var_dump($cekcok);
}
}
$maxId = $response->getNextMaxId();
}while($maxID !== null);

    sleep(300);
}