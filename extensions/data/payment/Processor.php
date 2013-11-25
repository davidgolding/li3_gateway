<?php
/**
 * Processor
 *
 * @copyright	2013, David Golding
 * @license		http://opensource.org/licenses/bsd-license.php BSD License
 */

namespace li3_gateway\extensions\data\payment;

class Processor extends \lithium\core\Adaptable {
	
	/**
	 * Configs
	 */
	protected static $_configurations = [];
	
	/**
	 * Path to adapters
	 */
	protected static $_adapters = 'data.payment.adapter';
	
	/**
	 * Initializes plugin configs
	 */
	protected static function _initConfig($name, $config) {
		$defaults = ['adapter' => 'Stripe', 'currency' => 'usd'];
		return parent::_initConfig($name, $config) + $defaults;
	}
	
	/**
	 * Peforms a charge on the gateway
	 *
	 * The adapter classes must follow the standardized output:
	 * 	- `id`:			Gateway-issued charge ID
	 * 	- `created`:	Y-m-d H:i:s time of charge
	 * 	- `mode`:		'live' | 'test'
	 * 	- `amount`:		Total in cents or lowest coin denomination
	 * 	- `currency`:	Currency ('usd')
	 * 	- `refunded`:	True if a refund
	 * 	- `last4`:		Last 4 digits of credit card number
	 * 	- `type`:		Type of credit card, e.g., 'Visa'
	 * 	- `exp_month`:	Expiration month
	 * 	- `exp_year`:	Expiration year
	 * 	- `country`:	Country
	 * 	- `captured`:	True if money has been captured
	 * 	- `invoice`:	Gateway-issued invoice ID
	 */
	public static function charge($params = [], $options = []) {
		$options += ['mode' => 'default'];
		return self::adapter($options['mode'])->charge($params);
	}
}

?>