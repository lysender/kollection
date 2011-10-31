<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Message helper class
 *
 */
class Kollection_Message_ErrorTest extends Kohana_Unittest_TestCase {

	public function test_error()
	{
		$v = View::factory('kollection/message/default');
		$v->set('type', Kollection_Message::TYPE_ERROR)
			->set('messages', 'You got error!');

		$m = new Kollection_Message_Error(array(
			'messages' => 'You got error!'
		));

		$this->assertEquals($v->render(), $m->render());
	}
}
