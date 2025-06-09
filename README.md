# FruitCraft
Complete management of your FruitCraft accounts

## Installation
```bash
composer require takpesar/fruitcraft
```

## Requirements

This package requires PHP 8.2 or later. Curl extensions require this package

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

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

# You are now ready to use the implemented methods :)
# for example ...

$heroes = $client->getheroes();
$ids = array_column($heroes,'id');

foreach($ids as $id){
    try {
        var_dump($client->player_fillpotion(amount : 50));
        var_dump($client->cards_potionize(hero_id : $id));
    } catch(Errors $e){
        echo 'Error : ' , strval($e) , PHP_EOL;
    }
}

?>
```
