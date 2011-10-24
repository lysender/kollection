<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Script helper class
 *
 */
class Kollection_Script_AdapterTest extends Kohana_Unittest_TestCase {
	
	public function focus_provider()
	{
		return array(
			array(
				'foo',
				'var field_foo = document.getElementById("foo");'."\n"
					."if (field_foo) {\n"
					."field_foo.setFocus();\n"
					."}\n"
			),
			array(
				'email_address',
				'var field_email_address = document.getElementById("email_address");'."\n"
					."if (field_email_address) {\n"
					."field_email_address.setFocus();\n"
					."}\n"
			),
			array(
				'e',
				'var field_e = document.getElementById("e");'."\n"
					."if (field_e) {\n"
					."field_e.setFocus();\n"
					."}\n"
			)		
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
		$a = new Kollection_Script_Adapter;
		$this->assertEquals($expected, $a->focus($field));
	}
	
	/**
	 * Ready method on adapter doesn't do anything yet
	 * and simply returns back the content
	 */
	public function test_ready()
	{
		$a = new Kollection_Script_Adapter;
		$this->assertEquals('foo', $a->ready('foo'));
	}
	
	public function deferred_provider()
	{
		return array(
			array(
				"foo1();",
				"window.onload = function() {\n"
					."foo1();\n"
					."};\n"
			),
			array(
				"var a = true;\n"
					."foo(a);",
				"window.onload = function() {\n"
					."var a = true;\n"
					."foo(a);\n"
					."};\n"
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
		$a = new Kollection_Script_Adapter;
		$this->assertEquals($expected, $a->deferred($input));
	}
	
	public function generate_tag_provider()
	{
		return array(
			array(
				'alert("hi");',
				'<script type="text/javascript">alert("hi");</script>'
			)
		);
	}
	
	/**
	 * @dataProvider	generate_tag_provider
	 * @param   string	$input
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_generate_tag($input, $expected)
	{
		$a = new Kollection_Script_Adapter;
		$this->assertEquals($expected, $a->generate_tag($input));
	}
	
	public function js_var_provider()
	{
		$some_list = array('foo', 'bar', 'baz');
		
		$o = new stdClass;
		$o->name = 'Lysender';
		$o->email = 'lolcat@zend.com';
		
		return array(
			array('a', true, 'var a = true;'),
			array('name', 'Lysender', 'var name = "Lysender";'),
			array('total', 0, 'var total = 0;'),
			array('total', 98, 'var total = 98;'),
			array('discount', 20.50, 'var discount = 20.5;'), // Zero stripped off
			array(
				'someList',
				$some_list,
				'var someList = '.json_encode($some_list).';'
			),
			array(
				'someObj',
				$o,
				'var someObj = '.json_encode($o).';'
			),
		);
	}
	
	/**
	 * @dataProvider	js_var_provider
	 * @param   string	$name
	 * @param   mixed	$value
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_js_var($name, $value, $expected)
	{
		$a = new Kollection_Script_Adapter;
		$this->assertEquals($expected, $a->js_var($name, $value));
	}
	
	public function test_highlight_error()
	{
		$a = new Kollection_Script_Adapter;
		
		// Method does not do anything in this basic adapter
		$this->assertEquals('', $a->highlight_error('foo'));
	}
}