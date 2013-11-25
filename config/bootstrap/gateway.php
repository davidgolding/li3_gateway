<?php
/**
 * Default li3_gateway configuration - should be superseded in the app-level
 * config/bootstrap folder in connections.php or a similar bootstrap file.
 *
 * @copyright	2013, David Golding
 * @license		http://opensource.org/licenses/bsd-license.php BSD License
 */

use li3_gateway\extensions\data\payment\Processor;

Processor::config([
	'test' => [
		'adapter'		=>	'Stripe',
		'mode'			=>	'test',
		'token'			=>	'sk_test_111111111111111111111111',
		'publishable'	=>	'pk_test_111111111111111111111111',
		'currency'		=>	'usd'
	],
	'default' => [
		'adapter'		=>	'Stripe',
		'mode'			=>	'live',
		'token'			=>	'sk_live_111111111111111111111111',
		'publishable'	=>	'pk_live_111111111111111111111111',
		'currency'		=>	'usd'
	]
]);

?>