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
				'var field_name = document.getElementById("name");'."\n"
					."if (field_name) {\n"
						.'field_name.value = "Lysender";'."\n"
					."}\n",
				NULL
			),
			array(
				'total',
				0,
				'var field_total = document.getElementById("total");'."\n"
					."if (field_total) {\n"
						.'field_total.value = "0";'."\n"
					."}\n",
				NULL
			),
			array(
				'total',
				98,
				'var field_total = document.getElementById("total");'."\n"
					."if (field_total) {\n"
						.'field_total.value = "98";'."\n"
					."}\n",
				NULL
			),
			array(
				'discount',
				20.50,
				'var field_discount = document.getElementById("discount");'."\n"
					."if (field_discount) {\n"
						.'field_discount.value = "20.5";'."\n"
					."}\n",
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
		
		$a = new Kollection_Script_Adapter;
		$this->assertEquals($expected, $a->field_value($field, $value));
	}
	
	public function test_highlight_error()
	{
		$a = new Kollection_Script_Adapter;
		
		// Method does not do anything in this basic adapter
		$this->assertEquals('', $a->highlight_error('foo'));
	}
}