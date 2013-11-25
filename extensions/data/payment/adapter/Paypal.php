<?php
/**
 * PayPal Gateway Adapter
 *
 * @copyright	2013, David Golding
 * @license 	http://opensource.org/licenses/bsd-license.php BSD License
 */

namespace li3_gateway\extensions\data\payment\adapter;

class Paypal extends \lithium\core\Object {
	
	public function __construct(array $config = []) {
		$defaults = [];
		parent::__construct($config + $defaults);
	}
	
}

?>