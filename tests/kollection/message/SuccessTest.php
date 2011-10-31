<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Message helper class
 *
 */
class Kollection_Message_SuccessTest extends Kohana_Unittest_TestCase {

	public function test_success()
	{
		$v = View::factory('kollection/message/default');
		$v->set('type', Kollection_Message::TYPE_SUCCESS)
			->set('messages', 'You got promotion!');

		$m = new Kollection_Message_Success(array(
			'messages' => 'You got promotion!'
		));

		$this->assertEquals($v->render(), $m->render());
	}
}
