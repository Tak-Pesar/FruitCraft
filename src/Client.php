<?php

declare(strict_types = 1);

namespace Tak\FruitCraft;

use Tak\FruitCraft\Attributes\NeedLoadPlayer;

use Tak\FruitCraft\Attributes\NeedLoadErrors;

use Exception;

use Throwable;

final class Client extends Tools {
	public readonly string $passport;
	public readonly object $sender;
	public object $player;
	public object $errors;

	public function __construct(string $passport = null,public string $xorkey = 'ali1343faraz1055antler288based',public string $url = 'https://iran.fruitcraft.ir',array $options = array()){
		$this->sender = new Requests($url);
		if(is_null($passport) === false) $this->passport = $passport;
		array_map($this->sender->setOption(...),array_keys($options),array_values($options));
	}
	public function login(string $restore_key = null,string $game_version = '1.10.10700',string $udid = '4a87f9b929db1587',int $os_type = 2,string $os_version = '11',string $kochava_uid = 'KA1712090878T500V53fac2e74fa74e07933510deaf8f1d96',string $model = 'Redmi Note 8 Pro',string $metrix_uid = 'f97b1d7b-7a66-466c-909b-3a9b6b9bb52a',string $appsflyer_uid = '1712057203523-4308222745853444926',string $device_name = 'unknown',string $store_type = 'myket') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$player = $this('player/load',$parameters);
		$this->player = $player->data;
		return $player;
	}
	public function comeback(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('player/comeback',$parameters);
	}
	public function systemmessages(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('message/systemmessages',$parameters);
	}
	public function tribebroadcast(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('message/tribebroadcast',$parameters);
	}
	public function getshopitems(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('store/getshopitems',$parameters);
	}
	public function myparticipatedauctions(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('auction/loadmyparticipatedauctions',$parameters);
	}
	public function myauctions(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('auction/loadmyauctions',$parameters);
	}
	public function bid(int $auction_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('auction/bid',$parameters);
	}
	public function sale(int $card_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('auction/setcardforauction',$parameters);
	}
	public function searchpower() : mixed {
		$parameters = ['query_type'=>1];
		return $this('auction/search',$parameters);
	}
	public function searchfruit(int $base_card_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['query_type'] = 2;
		return $this('auction/search',$parameters);
	}
	public function searchtime() : mixed {
		$parameters = ['query_type'=>3];
		return $this('auction/search',$parameters);
	}
	public function searchprice(int $category,int $rarity,bool $cheapest = true) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['query_type'] = 6;
		$parameters['cheapest'] = intval($parameters['cheapest']) + 1;
		return $this('auction/search',$parameters);
	}
	public function geterrors(string $lang_id = 'en-US') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$errors = $this('error/messages',$parameters);
		$this->errors = $errors->data;
		return $errors;
	}
	public function league(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('ranking/league',$parameters);
	}
	public function getopponents(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('battle/getopponents',$parameters);
	}
	public function livebattle(int $opponent_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('live-battle/livebattle',$parameters);
	}
	public function livebattlejoin(int $mainEnemy,int $battle_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('live-battle/livebattlejoin',$parameters);
	}
	public function setcardforlivebattle(int $round,int $card,int $battle_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('live-battle/setcardforlivebattle',$parameters);
	}
	public function triggerability(int $hero_id,int $ability_type,int $battle_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('live-battle/triggerability',$parameters);
	}
	public function help(int $battle_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('live-battle/help',$parameters);
	}
	public function collectgold(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('cards/collectgold',$parameters);
	}
	public function evolve(int ...$sacrifices) : mixed {
		if(count($sacrifices) > 0):
			$parameters = ['sacrifices'=>json_encode($sacrifices)];
			# TODO : change the cards of player object ...
			return $this('cards/evolve',$parameters);
		else:
			throw new Exception('Sacrifices must be at least one');
		endif;
	}
	public function enhance(int $card_id,int ...$sacrifices) : mixed {
		if(count($sacrifices) > 0):
			$parameters = ['card_id'=>$card_id,'sacrifices'=>json_encode($sacrifices)];
			# TODO : change the cards of player object ...
			return $this('cards/enhance',$parameters);
		else:
			throw new Exception('Sacrifices must be at least one');
		endif;
	}
	public function defend(array $cards) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['type'] = 1003;
		$parameters['cards'] = json_encode(array_values($parameters['cards']));
		return $this('cards/assign',$parameters);
	}
	public function attack(array $cards) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['type'] = 1002;
		$parameters['cards'] = json_encode(array_values($parameters['cards']));
		return $this('cards/assign',$parameters);
	}
	public function mine(array $cards) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['type'] = 1001;
		$parameters['cards'] = json_encode(array_values($parameters['cards']));
		return $this('cards/assign',$parameters);
	}
	public function cooloff(int $card_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('cards/cooloff',$parameters);
	}
	public function potionize(int $hero_id,int $potion = null) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('cards/potionize',$parameters);
	}
	public function fillpotion(int $amount = -1) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('player/fillpotion',$parameters);
	}
	public function setinfo(string $name = null,string $realname = null,string $phone = null,string $address = null,int $gender = null,string $birth_year = null,int $mood_id = null,string $lang = 'en') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('player/setplayerinfo',$parameters);
	}
	#[NeedLoadPlayer]
	public function turnthewheel(int $store = 8) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['check'] = md5(strval($this->player->q));
		return $this('player/turnthewheel',$parameters);
	}
	#[NeedLoadPlayer]
	public function advertisment() : mixed {
		$parameters = ['check'=>md5(strval($this->player->q))];
		return $this('player/claimadvertismentreward',$parameters);
	}
	public function deposittobank(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('player/deposittobank',$parameters);
	}
	public function withdrawfrombank(int $amount = 0) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('player/withdrawfrombank',$parameters);
	}
	public function donate(int $tribe_id,int $gold) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/donate',$parameters);
	}
	public function members(bool $coach_tribe = false) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/members',$parameters);
	}
	public function poke(int $tribe_id,int $member_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/poke',$parameters);
	}
	public function leave(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/leave',$parameters);
	}
	public function find(string $query) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/find',$parameters);
	}
	public function joinrequest(int $tribe_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/joinrequest',$parameters);
	}
	public function recommended(string $client = 'iOS') : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('tribe/recommended',$parameters);
	}
	public function getinfo(int $player_id) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('player/getplayerinfo',$parameters);
	}
	#[NeedLoadPlayer]
	public function battle(int $opponent_id,array $cards,int $attacks_in_today = 0) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['check'] = md5(strval($this->player->q));
		$parameters['cards'] = json_encode(array_values($parameters['cards']));
		$battle = $this('battle/battle',$parameters);
		$this->player->q = $battle->data->q;
		return $battle;
	}
	#[NeedLoadPlayer]
	public function quest(array $cards) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		$parameters['check'] = md5(strval($this->player->q));
		$parameters['cards'] = json_encode(array_values($parameters['cards']));
		$quest = $this('battle/quest',$parameters);
		$this->player->q = $quest->data->q;
		return $quest;
	}
	#[NeedLoadPlayer]
	public function getheroes() : mixed {
		$this->reflection(__METHOD__);
		return $this->player->hero_id_set;
	}
	#[NeedLoadPlayer]
	public function getcards(mixed ...$arguments) : mixed {
		$this->reflection(__METHOD__);
		$filters = array_filter($arguments,is_string(...),ARRAY_FILTER_USE_KEY);
		return array_values(array_filter($this->player->cards,fn(object $card) : bool => array_intersect_assoc((array) $card,$filters) == $filters));
	}
	#[NeedLoadPlayer]
	public function sortcards(string $index = 'power',string $order = 'DESC',mixed ...$filters) : mixed {
		$this->reflection(__METHOD__);
		$rand = $this->player->cards[array_rand($this->player->cards)];
		$keys = array_keys((array) $rand);
		if(in_array($index,$keys)):
			uasort($this->player->cards,fn(mixed $a,mixed $b) : int => $order === 'DESC' ? $b->$index <=> $a->$index : $a->$index <=> $b->$index);
			return $this->getcards(...$filters);
		else:
			throw new Exception('There isn\'t '.$index.' key in the cards');
		endif;
	}
	#[NeedLoadErrors]
	public function geterrormessage(int $code) : string {
		$this->reflection(__METHOD__);
		return $this->errors->$code ?? throw new Exception('The error message related to code '.$code.' was not found');
	}
	public function getavatar(int $avatar_id,string $dir = null,bool $asurl = false) : string {
		if($avatar_id === 0) $avatar_id += 1;
		if(is_dir($dir ? $dir : chr(46)) or mkdir($dir,0777,true)):
			$directory = realpath(strval($dir));
			$path = $directory.DIRECTORY_SEPARATOR.$avatar_id.'.png';
			if(is_file($path) === false):
				$photo = $this->sender->request('GET','cardpool/Assets-SD/Avatars/Avatar'.$avatar_id.'@2x.png');
				$status = $this->sender->getStatus();
				$status === 200 || throw new Errors('STATUS_CODE_'.$status,400);
				file_put_contents($path,$photo);
			endif;
			if($asurl):
				if(isset($_SERVER['REQUEST_SCHEME'],$_SERVER['HTTP_HOST'],$_SERVER['DOCUMENT_ROOT'])):
					return strval($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'],strval(null),$path));
				else:
					throw new Exception('This option should be accessed via a web server , not from the command line');
				endif;
			else:
				return $path;
			endif;
		else:
			throw new Exception('Failed to create directories');
		endif;
	}
	public function docaptcha(int $resp) : mixed {
		$parameters = $this->arguments(__METHOD__,func_get_args());
		return $this('bot/challengeresponse',$parameters);
	}
	public function getcaptcha(string $path,bool $asurl = false) : string {
		$dir = dirname($path);
		$file = basename($path);
		if(is_dir($dir ? $dir : chr(46)) or mkdir($dir,0777,true)):
			$directory = realpath(strval($dir));
			$path = $directory.DIRECTORY_SEPARATOR.$file;
			if(is_file($path) === false):
				$photo = $this->sender->request('GET','bot/getcaptcha');
				$status = $this->sender->getStatus();
				$status === 200 || throw new Errors('STATUS_CODE_'.$status,400);
				file_put_contents($path,$photo);
			endif;
			if($asurl):
				if(isset($_SERVER['REQUEST_SCHEME'],$_SERVER['HTTP_HOST'],$_SERVER['DOCUMENT_ROOT'])):
					return strval($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'],strval(null),$path));
				else:
					throw new Exception('This option should be accessed via a web server , not from the command line');
				endif;
			else:
				return $path;
			endif;
		else:
			throw new Exception('Failed to create directories');
		endif;
	}
	public function generatepassport(bool $new = false,bool $login = true) : string {
		if($new === true or isset($this->passport) === false):
			$this->passport = md5(strval(rand(0x400,0x2800)));
			if($login === true) $this->login();
		endif;
		return $this->passport;
	}
	public function __invoke(string $path,array $request,string $key = null) : mixed {
		if(is_null($key)) $key = $this->xorkey;
		if(isset($this->passport) === false) $this->generatepassport(login : boolval($path !== 'player/load'));
		$body = $this->serialize($request,$key);
		$datas = ['edata'=>$body];
		$headers = ['Cookie: FRUITPASSPORT='.$this->passport.chr(59)];
		$response = $this->sender->request('POST',$path,$datas,$headers);
		try {
			$body = $this->unserialize(rawurldecode($response),$key);
		} catch(Throwable){
			$status = $this->sender->getStatus();
			$body = match($status){
				200 => json_validate($response) ? json_decode($response) : $response,
				404 => throw new Errors('INVALID_PATH_'.$path,404),
				429 => throw new Errors('FLOOD_WAIT_4',420),
				default => throw new Errors('STATUS_CODE_'.$status,400)
			};
		}
		if(is_object($body) and $body->status === false):
			match($body->data->code){
				# 156 => throw new Errors('FLOOD_WAIT_4',420), # We need your name or restore key for your identification
				124 , 184 => throw new Errors('FLOOD_WAIT_2',420),
				default => throw new Errors('ERROR_CODE_'.$body->data->code,400)
			};
		endif;
		return $body;
	}
	public function __call(string $name,array $arguments) : mixed {
		$path = strtolower(preg_replace('/([a-z])([A-Z])/','$1-$2',str_replace(chr(95),chr(47),$name)));
		$parameters = array_filter($arguments,is_string(...),ARRAY_FILTER_USE_KEY);
		return $this($path,$parameters);
	}
	public function __sleep() : array {
		return array('url','passport','player','xorkey');
	}
	public function __wakeup() : void {
		$this->sender = new Requests($this->url);
	}
}

?>