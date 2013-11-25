<?php

namespace li3_gateway\tests\cases\extensions\data\payment;

use li3_gateway\extensions\data\payment\Processor;

class ProcessorTest extends \lithium\test\Unit {
	
	public function testDefaultConfig() {
		$config = Processor::config();
		$this->assertTrue(isset($config['test']));
		$this->assertTrue(isset($config['default']));
	}
	
	public function testCharge() {
		$result = Processor::charge([
			'amount' => 1000,
			'currency' => 'usd',
			'card' => ['number' => '4242424242424242', 'exp_month' => '12', 'exp_year' => '2020']
		]);
		$this->assertEqual('success', $result['status']);
	}
}

?>