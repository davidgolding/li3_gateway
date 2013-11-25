li3_gateway
===========

Payment gateway plugin for the Lithium framework

## How to Install

Place the `li3_gateway` folder into your Lithium application's `libraries` directory and bootstrap it using:

```php
Libraries::add('li3_gateway');
```

The default configurations have generic, non-workable token values. Depending on the payment service you're using,
you'll need to define the `'token'` and `'publishable'` values that match up to your test/live API accounts. To
do this, use the `Processor::config()` method in an app-level bootstrap file, or create a new bootstrap configuration
and include it in your app. Something like this ought to do the trick:

```php
//In app/config/bootstrap/connections.php

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
```

Now, wherever you need to perform payment actions, just load the main Processor class:

```php
<?php

namespace app\models;

use li3_gateway\extensions\data\payment\Processor;

class Members extends \lithium\data\Model {
	
	public function purchase($entity, $options = []) {
		if (!is_object($entity)) {
			return false;
		}
		$testPayment = [
			'card' => '4242424242424242',
			'month' => '12',
			'year' => '2020',
			'amount' => 100, //$1.00 USD in cents
			'description' => $entity->firstname . ' ' . $entity->lastname,
			'address' => [
				'street' => $entity->street,
				'city' => $entity->city,
				'state' => $entity->state,
				'zip' => $entity->zip,
				'country' => $entity->country
			]
		];
		return Processor::capture($testPayment);
	}
}

?>
```