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
}