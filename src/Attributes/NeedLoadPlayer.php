<?php

declare(strict_types = 1);

namespace Tak\FruitCraft\Attributes;

use Attribute;

use Exception;

#[Attribute]
final class NeedLoadPlayer {
	public function check(object $client) : void {
		if(isset($client->player) === false):
			throw new Exception('First, use the login method to load player information');
		endif;
	}
}

?>