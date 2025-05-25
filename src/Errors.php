<?php

declare(strict_types = 1);

namespace Tak\FruitCraft;

use Exception;

final class Errors extends Exception {
	protected string $type;
	protected string $description;
	protected int $value;

	protected const CODES = [
		400=>'BAD_REQUEST',
		404=>'NOT_FOUND',
		420=>'FLOOD'
	];
	protected const MESSAGES = [
		'INVALID_PATH_([\w/-]+)'=>'The request path X was not found and is invalid',
		'ERROR_CODE_(\d+)'=>'Server side error code X',
		'STATUS_CODE_(\d+)'=>'HTTP Error status code X',
		'FLOOD_WAIT_(\d+)'=>'A wait of X seconds is required'
	];

	public function __construct(string $message,int $code = 0){
		$this->type = isset(self::CODES[$code]) ? self::CODES[$code] : 'UNKNOWN';
		$this->description = 'UNKNOWN';
		$this->value = 0;
		foreach(self::MESSAGES as $name => $description):
			if(preg_match('~^'.$name.'$~',$message,$match)):
				if(count($match) > 1) $this->value = intval($match[true]);
				$this->description = str_replace(chr(88),strval($this->value),$description);
				break;
			endif;
		endforeach;
		parent::__construct($message,$code);
	}
	public function getType() : string {
		return $this->type;
	}
	public function getDescription() : string {
		return $this->description;
	}
	public function getValue() : int {
		return $this->value;
	}
	public function __toString(){
		return $this->getMessage().chr(32).$this->getCode().chr(32).chr(58).chr(32).$this->getDescription();
	}
}

?>