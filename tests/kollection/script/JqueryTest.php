<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Script helper class
 *
 */
class Kollection_Script_JqueryTest extends Kohana_Unittest_TestCase {
	
	public function focus_provider()
	{
		return array(
			array(
				'foo',
				'$("#foo").focus();'."\n"
			),
			array(
				'email_address',
				'$("#email_address").focus();'."\n"
			),
			array(
				'e',
				'$("#e").focus();'."\n"
			),	
		);
	}
	
	/**
	 * @dataProvider	focus_provider
	 * @param   string	$field
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_focus($field, $expected)
	{
		$a = new Kollection_Script_Jquery;
		$this->assertEquals($expected, $a->focus($field));
	}
	
	public function ready_provider()
	{
		return array(
			array(
				"foo1();",
				"$(function() {\n"
					."foo1();\n"
					."});\n"
			),
			array(
				"var a = true;\n"
					."foo(a);",
				"$(function() {\n"
					."var a = true;\n"
					."foo(a);\n"
					."});\n"
			),
		);
	}
	
	/**
	 * @dataProvider	ready_provider
	 * @param   string	$input
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_ready($input, $expected)
	{
		$a = new Kollection_Script_Jquery;
		$this->assertEquals($expected, $a->ready($input));
	}
	
	public function deferred_provider()
	{
		return array(
			array(
				"foo1();",
				"$(window).load(function() {\n"
					."foo1();\n"
					."});\n"
			),
			array(
				"var a = true;\n"
					."foo(a);",
				"$(window).load(function() {\n"
					."var a = true;\n"
					."foo(a);\n"
					."});\n"
			),
		);
	}
	
	/**
	 * @dataProvider	deferred_provider
	 * @param   string	$input
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_deferred($input, $expected)
	{
		$a = new Kollection_Script_Jquery;
		$this->assertEquals($expected, $a->deferred($input));
	}
	
	public function field_value_provider()
	{
		$some_list = array('foo', 'bar', 'baz');
		
		$o = new stdClass;
		$o->name = 'Lysender';
		$o->email = 'lolcat@zend.com';
		
		return array(
			array(
				'a',
				true,
				NULL,
				'Kollection_Script_Exception'
			),
			array(
				'name',
				'Lysender',
				'$("#name").val("Lysender");'."\n",
				NULL
			),
			array(
				'total',
				0,
				'$("#total").val("0");'."\n",
				NULL
			),
			array(
				'total',
				98,
				'$("#total").val("98");'."\n",
				NULL
			),
			array(
				'discount',
				20.50,
				'$("#discount").val("20.5");'."\n",
				NULL
			), // Zero stripped off
			array(
				'someList',
				$some_list,
				NULL,
				'Kollection_Script_Exception'
			),
			array(
				'someObj',
				$o,
				NULL,
				'Kollection_Script_Exception'
			),
		);
	}
	
	/**
	 * @dataProvider	field_value_provider
	 * @param   string	$field
	 * @param   mixed	$value
	 * @param   string	$expected
	 * @param   string	$exception
	 * @return  void
	 */
	public function test_field_value($field, $value, $expected, $exception)
	{
		if ($exception !== NULL)
		{
			$this->setExpectedException($exception);
		}
		
		$a = new Kollection_Script_Jquery;
		$this->assertEquals($expected, $a->field_value($field, $value));
	}
}