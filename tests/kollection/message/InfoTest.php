<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Message helper class
 *
 */
class Kollection_Message_InfoTest extends Kohana_Unittest_TestCase {

	public function test_info()
	{
		$v = View::factory('kollection/message/default');
		$v->set('type', Kollection_Message::TYPE_INFO)
			->set('messages', 'You got mail!');

		$m = new Kollection_Message_Info(array(
			'messages' => 'You got mail!'
		));

		$this->assertEquals($v->render(), $m->render());
	}
}
