<?php

declare(strict_types = 1);

namespace Tak\FruitCraft;

use ReflectionMethod;

abstract class Tools {
	public function serialize(array $request,string $key) : string {
		return $this->xor_encrypt(json_encode($request),$key);
	}
	public function unserialize(string $response,string $key) : object {
		return json_decode($this->xor_decrypt($response,$key));
	}
	public function xor_encrypt(string $message,string $key) : string {
		$encrypted = strval(null);
		for($i = 0;$i < strlen($message);$i++):
			$encrypted .= chr(ord($message[$i]) ^ ord($key[$i % strlen($key)]));
		endfor;
		$plaintext = base64_encode($encrypted);
		return $plaintext;
	}
	public function xor_decrypt(string $message,string $key) : string {
		$ciphertext = base64_decode($message);
		$decrypted = strval(null);
		for($i = 0;$i < strlen($ciphertext);$i++):
			$decrypted .= chr(ord($ciphertext[$i]) ^ ord($key[$i % strlen($key)]));
		endfor;
		return $decrypted;
	}
	protected function arguments(string $method,array $arguments) : array {
		$reflection = $this->reflection($method);
		$result = array();
		$parameters = $reflection->getParameters();
		foreach($parameters as $i => $parameter):
			$value = ($arguments[$i] ?? $parameter->getDefaultValue());
			if(is_null($value) === false):
				$result[$parameter->getName()] = $value;
			endif;
		endforeach;
		return $result;
	}
	protected function reflection(string $method) : object {
		$reflection = new ReflectionMethod($method);
		$attributes = $reflection->getAttributes();
		array_map(fn(object $attribute) : mixed => $attribute->newinstance()->check($this),$attributes);
		return $reflection;
	}
}

?>