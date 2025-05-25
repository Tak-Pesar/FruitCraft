<?php

declare(strict_types = 1);

namespace Tak\FruitCraft;

use CurlHandle;

use Exception;

final class Requests {
	private CurlHandle $curl;

	public function __construct(public string $url){
		$this->curl = curl_init();
		$this->setDefaults($this->curl);
	}
	public function request(string $method,string $path,array | object $datas = array(),array $headers = array()) : string {
		$fields = is_object($datas) ? json_encode($datas) : http_build_query($datas);
		switch($method){
			case 'POST':
				curl_setopt($this->curl,CURLOPT_URL,(filter_var($path,FILTER_VALIDATE_URL) ? $path : $this->url.'/'.$path));
				curl_setopt($this->curl,CURLOPT_POSTFIELDS,$fields);
				curl_setopt($this->curl,CURLOPT_POST,true);
			break;
			case 'GET':
				curl_setopt($this->curl,CURLOPT_URL,(filter_var($path,FILTER_VALIDATE_URL) ? $path : $this->url.'/'.$path.'?'.$fields));
				curl_setopt($this->curl,CURLOPT_HTTPGET,true);
			break;
			default:
				throw new Exception('The request method is inappropriate for the URL !');
			break;
		}
		curl_setopt($this->curl,CURLOPT_HTTPHEADER,array_merge($headers,array('Content-Type: application/'.(is_object($datas) ? 'json' : 'x-www-form-urlencoded').'; charset=UTF-8','Content-Length: '.strlen($fields),'User-Agent: Dalvik/2.1.0 (Linux; U; Android 11; Redmi Note 8 Pro Build/RP1A.200720.011)','Host: '.$this->getHost(),'Connection: Keep-Alive','Accept-Encoding: gzip')));
		$result = curl_exec($this->curl);
		$error = curl_error($this->curl);
		return is_bool($result) ? throw new Exception($error) : $result;
	}
	public function getStatus() : int {
		return intval(curl_getinfo($this->curl,CURLINFO_HTTP_CODE));
	}
	public function getHost() : string {
		$parsed = parse_url($this->url);
		return $parsed['host'];
	}
	public function setOption(int $option,mixed $value) : bool {
		return curl_setopt($this->curl,$option,$value);
	}
	private function setDefaults(CurlHandle $curl) : void {
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	}
	public function __destruct(){
		curl_close($this->curl);
	}
}

?>