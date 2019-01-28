<?php
require __DIR__.'/vendor/autoload.php';

/////// CONFIG ///////
$username = '';
$password = '';
$debug = false;
$truncatedDebug = false;
//////////////////////

// Create connection
$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

try {
    $ig->login($username, $password);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}

try {

    //Get Tag Active on Database.
    $tag = "photography";
    echo "Hashtag: " . $tag . "\n";

    // Generate a random rank token.
     $rankToken = \InstagramAPI\Signatures::generateUUID();
    echo "Rank Token: " . $rankToken . "\n";

    // Starting at "null" means starting at the first page.
    $maxId = null;
    echo "Max ID: " . $maxId  . "\n";

    do {
        // Request the page corresponding to maxId.
        // Note that we are using the same rank token for all pages.
        $response = $ig->hashtag->getFeed($tag, $rankToken, $maxId);

        if($response->isItems())
        {
            $items = $response->getItems();
        }
        else
        {
           $items = $response->getRankedItems();
        }

        echo "Numero de itens: " . sizeof($items) . "\n";

        // In this example we're simply printing the IDs of this page's items.
        foreach ($items as $item) {

            $itemId = $item->getId();
            echo "ID: " . $itemId . "\n";

            $user = $item->getUser();
            $username = $user->getUsername();
            echo "Username: " . $username . "\n";

            $userid = $user->getPk();
            echo "UserID: " . $userid . "\n";

            $ImageVersion = $item->getImageVersions2();

            if($ImageVersion != null){

                $UrlPhoto = $ImageVersion->getCandidates()[0]->getUrl();
                $caption = $item->getCaption()->getText();
                $numberOfLikes = $item->getLikeCount();

                echo "URL: " . $UrlPhoto . "\n";
                echo "Caption: " . $caption . "\n";
                echo "Likes: " . $numberOfLikes . "\n";

            }
            else
            {
                echo "Não encontrou Image Version\n";
            }
        }

        // Now we must update the maxId variable to the "next page".
        // This will be a null value again when we've reached the last page!
        // And we will stop looping through pages as soon as maxId becomes null.
        $maxId = $response->getNextMaxId();
        echo "Max ID: " . $maxId . "\n";

        // Sleep for 5 seconds before requesting the next page. This is just an
        // example of an okay sleep time. It is very important that your scripts
        // always pause between requests that may run very rapidly, otherwise
        // Instagram will throttle you temporarily for abusing their API!
        echo "Sleeping for 10s...\n";
        sleep(10);
    } while ($maxId !== null);

    echo "End Hastag: " . $tag . "\n";
    echo "Sleeping for 30s...\n";
    sleep(30);

    $ig->logout();

} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}