<?php

use Tak\FruitCraft\Client;

/* Please save the value of the variable below as you will use it later and there is no need to login every time */
$passport = md5('A value for the authentication key');

$client = new Client($passport);

/* Optional , Proxy settings to use Iranian IP */
$ip = '127.0.0.1';
$port = 443;
$username = 'country-ir';
$password = 'PaSsWoRd';

$client->sender->setOption(CURLOPT_PROXY,$ip.':'.$port);

$client->sender->setOption(CURLOPT_PROXYUSERPWD,$username.':'.$password);

/* If you save your `$passport`, you won't need to log in every time, so please be careful about logging in again */
$client->login('fight12345678');

/* 🎉 Now you can do anything with your account */
?>