
<?php
error_reporting(0);
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
$userId = $ig->people->getUserIdForName('tahusunduk');
$feed = $ig->timeline->getUserFeed($userId);
$i=0;
/*foreach ($feed->getItems() as $feeds){
    //$likbe = $ig->media->like($feeds->getId());
    //$bacot = $ig->media->comment($feeds->getId() , "sayang intannnnnnn");
    var_dump($feeds->getId());
    echo "\n";
    print($bacot->getStatus());
$i++;
if($i == 3){
    break;
}
}

$userId = $ig->people->getUserIdForName('tahusunduk');
$userids = [];
$userids[] = $userId;
var_dump($userids);
$text = "intaannn";

$send = $ig->direct->sendText(["users"=>$userids], $text);
*/
$rankToken = \InstagramAPI\Signatures::generateUUID();
$storyfeed = $ig->story->getReelsTrayFeed($rankToken);
/////////////////////////////////////////////


/*
$tray = $storyfeed->getTray();
$json = ($tray[0]->getItems());
$id = $json[0]->getId();
echo $id;
*/
$tray = $storyfeed->getTray();
foreach($tray as $tai){
foreach($tai->getItems() as $cok){
    $anu =($cok->getId());
    $delok = $ig->story->markMediaSeen(["item"=>$cok]);
    echo $delok . "\n" .$cok . "\n";
}
}