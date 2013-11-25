<?php
/**
 * Stripe Gateway Adapter
 *
 * @copyright	2013, David Golding
 * @license 	http://opensource.org/licenses/bsd-license.php BSD License
 */

namespace li3_gateway\extensions\data\payment\adapter;

class Stripe extends \lithium\core\Object {
	
	/**
	 * Class dependencies
	 */
	protected $_classes = [
		'service' => 'lithium\net\http\Service'
	];
	
	/**
	 * Constructor - sets standard API connection settings
	 */
	public function __construct(array $config = []) {
		$defaults = [
			'scheme' => 'https',
			'host' => 'api.stripe.com',
			'port' => 443,
			'auth' => 'Basic',
			'version' => '1.1',
			'basePath' => '/v1',
			'login' => null,
			'password' => null,
			'token' => null
		];
		parent::__construct($config + $defaults);
	}
	
	/**
	 * Performs charges on Stripe gateway
	 *
	 * @param $params array	Basic charge settings to capture a payment:
	 * 	- `amount`: integer	The amount in cents
	 * 	- `currency`: 'usd'	Currency
	 * 	- `card`: array	Uses the `number`, `exp_month`, and `exp_year` keys to pass card info
	 * 	@return array Standard `status` = 'error' | 'success' / `message` / `data` array
	 */
	public function charge($params, $options = []) {
		$config = $options + $this->_config;
		$config['username'] = $config['token'];
		$response = ['status' => 'error', 'message' => 'Unable to connect to gateway.'];
		$service = $this->_instance('service', $config);
		$params['currency'] = $config['currency'];
		$result = $service->post($config['basePath'] . '/charges', $params);
		if (!is_array($result) || isset($result['error'])) {
			$response['message'] = $result['error']['message'];
			return $response;
		}
		$data = $this->_format($result);
		$response = ['status' => 'success', 'message' => 'OK', 'data' => $data];
		return $response;
	}
	
	/**
	 * Standardizes the output to conform to the Processor keys
	 */
	protected function _format($result) {
		if (!is_array($result)) {
			return false;
		}
		$formatted = [
			'id'		=> $result['id'],
			'created'	=> date('Y-m-d H:i:s', $result['created']),
			'mode'		=> $result['livemode'] ? 'live' : 'test',
			'amount'	=> $result['amount'],
			'currency'	=> $result['currency'],
			'refunded'	=> $result['refunded'],
			'last4'		=> $result['card']['last4'],
			'type'		=> $result['card']['type'],
			'exp_month'	=> $result['card']['exp_month'],
			'exp_year'	=> $result['card']['exp_year'],
			'country'	=> $result['card']['country'],
			'captured'	=> $result['captured'],
			'invoice'	=> $result['invoice']
		];
		return $formatted;
	}
}

?>