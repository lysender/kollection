<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Script helper class
 *
 */
class Kollection_Script_BootstrapTest extends Kohana_Unittest_TestCase {
	
	public function highlight_error_provider()
	{
		return array(
			array(
				'foo',
				'$("#foo").addClass("error").parents("div.clearfix").addClass("error");'."\n"
			),
			array(
				'email_address',
				'$("#email_address").addClass("error").parents("div.clearfix").addClass("error");'."\n"
			),
			array(
				'e',
				'$("#e").addClass("error").parents("div.clearfix").addClass("error");'."\n"
			),	
		);
	}
	
	/**
	 * @dataProvider	highlight_error_provider
	 * @param   string	$field
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_highlight_error($field, $expected)
	{
		$a = new Kollection_Script_Bootstrap;
		$this->assertEquals($expected, $a->highlight_error($field));
	}
}