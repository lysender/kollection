<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Message helper class
 *
 */
class Kollection_MessageTest extends Kohana_Unittest_TestCase {
	
	public function combo_provider()
	{
		return array(
			// Defaults
			array(
				array(),
				array(
					'type' => NULL,
					'title' => NULL,
					'display' => NULL,
					'messages' => NULL
				),
				NULL
			),
			// With few options
			array(
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_LIST
				),
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_LIST,
					'messages' => NULL
				),
				NULL
			),
			// With messages
			array(
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_LIST,
					'messages' => 'test message'
				),
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_LIST,
					'messages' => 'test message'
				),
				NULL
			),
			array(
				array(
					'type' => 'invalid type'
				),
				array(),
				'Kollection_Message_Exception'
			),
			array(
				array(
					'display' => 'invalid display'
				),
				array(),
				'Kollection_Message_Exception'
			),
			// Array messages
			array(
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_LIST,
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password is too short',
					)
				),
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_LIST,
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password is too short',
					)
				),
				NULL
			),
			// Success message
			array(
				array(
					'type' => Kollection_Message::TYPE_SUCCESS,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'Feels so good!'
				),
				array(
					'type' => Kollection_Message::TYPE_SUCCESS,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'Feels so good!'
				),
				NULL
			),
			// Warning message
			array(
				array(
					'type' => Kollection_Message::TYPE_WARNING,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'Due date is coming...'
				),
				array(
					'type' => Kollection_Message::TYPE_WARNING,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'Due date is coming...'
				),
				NULL
			),
			// Info message
			array(
				array(
					'type' => Kollection_Message::TYPE_INFO,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'You can try our new version in beta...'
				),
				array(
					'type' => Kollection_Message::TYPE_INFO,
					'title' => 'test title',
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'You can try our new version in beta...'
				),
				NULL
			),
			// Array messages with ORM external messages
			array(
				array(
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password is too short',
						'_external' => array(
							'password_confirm' => 'Passwords do not match'
						)
					)
				),
				array(
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password is too short',
						'password_confirm' => 'Passwords do not match'
					)
				),
				NULL
			),
			// Array with ORM external messages overriding the previous keys
			array(
				array(
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password is too short',
						'_external' => array(
							'password' => 'Password has been used before'
						)
					)
				),
				array(
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password has been used before',
					)
				),
				NULL
			)
		);
	}

	/** 
	 * @dataProvider	combo_provider
	 * @param   array	$input
	 * @param   array 	$expected
	 * @param   string	$exception
	 */
	public function test_combo(array $input, array $expected, $exception)
	{
		if ($exception !== NULL)
		{
			$this->setExpectedException($exception);
		}

		$m = new Kollection_Message;

		// Set all options
		foreach ($input as $opt => $value)
		{
			$method = 'set_'.$opt;
			call_user_func(array($m, $method), $value);
		}

		// Prove that options were set
		foreach ($expected as $opt => $value)
		{
			$method = 'get_'.$opt;
			$result = call_user_func(array($m, $method));

			$this->assertEquals($value, $result);
		}
	}

	/** 
	 * @dataProvider	combo_provider
	 * @param   array	$input
	 * @param   array	$expected
	 * @param   string	$exception
	 */
	public function test_combo_constructor(array $input, array $expected, $exception)
	{
		if ($exception !== NULL)
		{
			$this->setExpectedException($exception);
		}

		$m = new Kollection_Message($input);

		// Prove that options were set
		foreach ($expected as $opt => $value)
		{
			$method = 'get_'.$opt;
			$result = call_user_func(array($m, $method));

			$this->assertEquals($value, $result);
		}
	}

	public function render_provider()
	{
		$info = View::factory('kollection/message/default');
		$error = View::factory('kollection/message/list');

		return array(
			// Normal info message
			array(
				array(
					'type' => Kollection_Message::TYPE_INFO,
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'You got mail!'
				),
				$info->set('type', Kollection_Message::TYPE_INFO)
					->set('messages', 'You got mail!')
					->render(),
				NULL
			),
			// No type
			array(
				array(
					'display' => Kollection_Message::DISPLAY_DEFAULT,
					'messages' => 'Fail'
				),
				NULL,
				'Kollection_Message_Exception'
			),
			// No messages
			array(
				array(
					'type' => Kollection_Message::TYPE_INFO,
					'display' => Kollection_Message::DISPLAY_DEFAULT,
				),
				NULL,
				'Kollection_Message_Exception'
			),
			// Error message with title
			array(
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'display' => Kollection_Message::DISPLAY_LIST,
					'title' => 'this is a test',
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password not entered'
					)
				),
				$error->set('type', Kollection_Message::TYPE_ERROR)
					->set('display', Kollection_Message::DISPLAY_LIST)
					->set('title', 'this is a test')
					->set('messages', array(
						'username' => 'Username not entered',
						'password' => 'Password not entered'
					))
					->render(),
				NULL
			),
			// No title
			array(
				array(
					'type' => Kollection_Message::TYPE_ERROR,
					'display' => Kollection_Message::DISPLAY_LIST,
					'messages' => array(
						'username' => 'Username not entered',
						'password' => 'Password not entered'
					)
				),
				NULL,
				'Kollection_Message_Exception'
			),
		);
	}

	/** 
	 * @dataProvider	render_provider
	 * @param   array	$options
	 * @param   string	$input
	 * @param   string	$exception
	 */
	public function test_render(array $options, $output, $exception)
	{
		if ($exception !== NULL)
		{
			$this->setExpectedException($exception);
		}

		$m = new Kollection_Message($options);
		$this->assertEquals($output, $m->render());
		$this->assertEquals($output, (string) $m);
	}

	public function test_view()
	{
		$m = new Kollection_Message;
		$m->set_display('default');
		$v = View::factory('kollection/message/default');

		$this->assertType('View', $m->get_view());
		$this->assertEquals($v, $m->get_view());
		$this->assertNotSame($v, $m->get_view());

		// Override
		$vlist = View::factory('kollection/message/list');
		$m->set_display(Kollection_Message::DISPLAY_LIST)
			->set_view($vlist);

		$this->assertEquals($vlist, $m->get_view());
		$this->assertSame($vlist, $m->get_view());
		$this->assertNotEquals($v, $m->get_view());
		$this->assertNotSame($v, $m->get_view());
	}
}
