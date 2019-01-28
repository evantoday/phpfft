
<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__ . '/vendor/autoload.php';

// ///// CONFIG ///////

$username = '';
$password = '';
$debug = false;
$truncatedDebug = false;

function komen()
	{
	$kata = 'like back dan Follow back ya🙏 | follback dan like back🙏 | follback ya👌 | salken, follback dan like back ya👍 | salam kenal follback dan likeback ya kak👍 | orang mana? follback dan likeback ya👍 | salken ya, boleh minta follback dan likeback? | follback yo | follbackk | follback bgsd like back ya cok 😀 | followback ya | udah aku follow dan like bisa minta follback dan likeback gak hehe | follback dan likeback yo kak udah difollow kok | follback dan likeback kak sudah aku follow dan like | bisa minta follow back kak hehe? | followback yo 😀 | salken, follback ya 🙂 | salken, follback aku yah | salken, btw follback ya | salken, follback juga yah hehe | salamkenal, follback yah hehe | bisa follback ? | follback yow | follback yapp | Follback hihihihi | follbackk saya ya 🙂 | Orang mana kak, like back dan Follback ya | Salam kenal kak hehe likeback dan follback ya | Salkus ya kak like back dan follback ya | Mari berteman kak,like back dan follback ya | Orang mana kak, Salam kenal ya tod , likeback dan Follback yaa | Orang mana kak?, likeback dan Follback dong | Namanya siapa, Salam kenal ya, like back dan follback ya | Saling follback ya kak, makasih | Orang mana kak, likeback dan Follbackdong hehehe | halo kak salken ya,, like back dan Follback ya | Mari berteman ya kak saling dan follback hehe | Kenalan dong kak heheh likeback dan follback ya | Likeback dan follback hihi salam kenal ya | Hallo kak salam kenal ya hehe likeback dan follback juga ya';
	$komen = explode('|', $kata);
	$ra = rand(0, count($komen));
	$raimu = json_encode($komen);
	$asu = json_decode($raimu);
	return $asu[$ra];
	}

// ////////////////////

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
$loginResponse = $ig->login($username, $password);

if (!is_null($loginResponse) && $loginResponse->isTwoFactorRequired())
	{
	$twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();

	// The "STDIN" lets you paste the code via terminal for testing.
	// You should replace this line with the logic you want.
	// The verification code will be sent by Instagram via SMS.

	$verificationCode = trim(fgets(STDIN));
	$ig->finishTwoFactorLogin($verificationCode, $twoFactorIdentifier);
	}

$rankToken = \InstagramAPI\Signatures::generateUUID();
try
	{
	$following = [];
	$userId = $ig->people->getUserIdForName('tahusunduk');
	$maxId = null;
	do
		{
		$response = $ig->people->getFollowers($userId, $rankToken, null, $maxId);
		foreach($response->getUsers() as $mothy)
			{
			$idcok = $mothy->getPk();
			$info = $ig->people->getFriendship($idcok);
			 $userInfo = $ig->people->getInfoById($idcok);
 $private = $userInfo->getUser()->getIsPrivate();
 if($private == false){
			if (($info->getFollowing()) == false)
				{
				$fallaw = $ig->people->follow($idcok);
				echo $mothy->getUsername() . " ====>>> follow ===>>" . $fallaw->getStatus() . "\n";
				$userId = $ig->people->getUserIdForName($mothy->getUsername());
				$feed = $ig->timeline->getUserFeed($userId);
				$i = 0;

				// komen + like

				foreach($feed->getItems() as $feeds)
					{

					$like = $ig->media->like($feeds->getId());
					echo "cek like ===>>  "  .$like ."\n";
					$bacot = $ig->media->comment($feeds->getId() , komen());
					echo "cek bacotan ==>>>".$bacot . "\n";
					$userids = [];
					var_dump($feeds->getId());
					echo "\n";
					print ($bacot->getStatus());
					$i++;
					if ($i == 3)
						{
						break;
						}
					}

				echo "\n";
				sleep(10);
				}

			  else
				{
				echo "sudah follow " . $mothy->getUsername() . "cok jadi di skip cok '\n'";
				}
			}else{
			    echo "akun e di private cok skip wae ya . \n";
			}
			}

		$maxId = $response->getNextMaxId();
		}

	while ($maxId !== null);
	}

catch(Exception $e)
	{
	echo 'Something went wrong: ' . $e->getMessage() . "\n";
	}
