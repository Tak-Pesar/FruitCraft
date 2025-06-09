<?php

$path = __DIR__.DIRECTORY_SEPARATOR.'fruitcraft.phar';

// my domain is not available anymore, so you can use the phar file from my github repository
// if(file_exists($path) === false) copy('https://fruitcraft.phar.fun/fruitcraft.phar',$path);

require_once $path;

use Tak\FruitCraft\Client;

use Tak\FruitCraft\Errors;

# your restore key, you can get it from the game settings
$restore_key = 'fight123456789';

$passport = md5($restore_key);

$session_path = __DIR__.DIRECTORY_SEPARATOR.$passport.'.txt';

$client = new Client(passport : $passport);

# Save it to use it later for load the plyer and set the $client->player
if(file_exists($session_path)){
    $client->player = unserialize(file_get_contents($session_path));
} else {
    $player = $client->login($restore_key)->data;
    echo 'Sign in as '.$player->name , PHP_EOL;
}

file_put_contents($session_path,serialize($client->player));

# Just load the errors with that language you want
$client->geterrors('fa-IR');

$opponents = $client->getopponents();

# Choosing strong cards along with a hero card
$sorted = $client->sortcards(index : 'power',order : 'DESC');
$choice = array_slice($sorted,0,4);

$heroes = $client->getheroes();
$hero = array_slice($heroes,0,1);

$cards = array_column(array_merge($choice,$hero), 'id');

var_dump($cards); # The selected ID cards are

foreach($opponents->data->players as $opponent){
    $try = 0;
    if($opponent->def_power < intval($client->player->def_power * 0.9) and $opponent->level < intval($client->player->level + 100)){
        repeat:
        echo 'Attacking '.$opponent->name.' she/he is level '.$opponent->level.' , who is in Tribe '.$opponent->tribe_name , PHP_EOL;
        try {
            $client->healall($cards);
        } catch(Errors $e){
            if($e->getCode() === 400){
                # ERROR_CODE_{$X} : 400 #
                echo 'Error : ' , $client->geterrormessage($e->getValue()) , PHP_EOL;
            } elseif($e->getCode() === 420){
                # FLOOD_WAIT_{$X} : 420 #
                echo $e->getDescription() , PHP_EOL;
                sleep($e->getValue());
                $try++;
                if($try < 3){
                    goto repeat;
                }
            } else {
                echo 'Error : ' , strval($e) , PHP_EOL;
            }
        }
        try {
            $attack = $client->battle(opponent_id : $opponent->id,cards : $cards);
            if($attack->data->gold_added > 0){
                echo 'We won !' , PHP_EOL;
                goto repeat;
            } else {
                var_dump($attack);
            }
        } catch(Errors $e){
            if($e->getCode() === 400){
                # ERROR_CODE_{$X} : 400 #
                echo 'Error : ' , $client->geterrormessage($e->getValue()) , PHP_EOL;
            } elseif($e->getCode() === 420){
                # FLOOD_WAIT_{$X} : 420 #
                echo $e->getDescription() , PHP_EOL;
                sleep($e->getValue());
                $try++;
                if($try < 3){
                    goto repeat;
                }
            } else {
                echo 'Error : ' , strval($e) , PHP_EOL;
            }
        }
        # break;
    }
}

file_put_contents($session_path,serialize($client->player));

?>
