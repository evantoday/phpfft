
<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
/////// CONFIG ///////
$username = 'fchrbass';
$password = 'fikri83900';
$debug = true;
$truncatedDebug = false;
//////////////////////
$ig = new \InstagramAPI\Instagram(false,false);
$loginResponse = $ig->login($username, $password);
$userId = $ig->people->getUserIdForName('tahusunduk');
$feed = $ig->timeline->getUserFeed($userId);
$i=0;
foreach ($feed->getItems() as $feeds){
    $likbe = $ig->media->like($feeds->getId());
    $bacot = $ig->media->comment($feeds->getId() , "sayang intannnnnnn");
    var_dump($feeds->getId());
    echo "\n";
    print($bacot->getStatus());
$i++;
if($i == 3){
    break;
}
}