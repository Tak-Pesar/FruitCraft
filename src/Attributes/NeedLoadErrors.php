<?php

declare(strict_types = 1);

namespace Tak\FruitCraft\Attributes;

use Attribute;

use Exception;

#[Attribute]
final class NeedLoadErrors {
	public function check(object $client) : void {
		if(isset($client->errors) === false):
			$client->geterrors();
		endif;
	}
}

?>