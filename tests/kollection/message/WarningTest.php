<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Message helper class
 *
 */
class Kollection_Message_WarningTest extends Kohana_Unittest_TestCase {

	public function test_error()
	{
		$v = View::factory('kollection/message/default');
		$v->set('type', Kollection_Message::TYPE_WARNING)
			->set('messages', 'You got disconnection notice!');

		$m = new Kollection_Message_Warning(array(
			'messages' => 'You got disconnection notice!'
		));

		$this->assertEquals($v->render(), $m->render());
	}
}
