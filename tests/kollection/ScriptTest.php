<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Script helper class
 *
 */
class Kollection_ScriptTest extends Kohana_Unittest_TestCase {
	
	public function get_mocked_adapter()
	{
		return $this->getMock('Kollection_Script_Adapter');
	}
	
	public function test_object()
	{
		$obj = new Kollection_Script($this->get_mocked_adapter());
		$this->assertType('Kollection_Script', $obj);
	}
	
	/**
	 * @expectedException ErrorException
	 */
	public function test_adapter_invalid()
	{
		$s = new Kollection_Script($this->get_mocked_adapter());
		$s->set_adapter(new stdClass);
	}
	
	public function test_adapter_valid()
	{
		$s = new Kollection_Script($this->get_mocked_adapter());
		$s->set_adapter($this->getMock('Kollection_Script_Adapter'));
		$this->assertType('Kollection_Script_Adapter', $s->get_adapter());
	}
	
	public function files_provider()
	{
		return array(
			array(array('foo'), 1),
			array(array('foo', 'bar', 'baz'), 3),
			array(array('js/jquery.js', 'js/jquery-ui.js', 'js/common.js', 'http://jquery.com/jquery.js'), 4)
		);
	}
	
	/**
	 * @dataProvider	files_provider
	 * 
	 * @param  array 	$input
	 * @param  int		$expected_count
	 * @return void
	 */
	public function test_files(array $input, $expected_count)
	{
		$s = new Kollection_Script($this->get_mocked_adapter());
		
		foreach ($input as $file)
		{
			$s->add_file($file);
		}
		
		$files = $s->get_files();
		$this->assertEquals($expected_count, count($files));
		
		// All files added must exist
		foreach ($input as $file)
		{
			$this->assertTrue(in_array($file, $files));
		}
		
		// Clear files
		$s->set_files(array());
		$this->assertEquals(0, count($s->get_files()));
		
		// Set files at once
		$s->set_files($input);
		
		$files = $s->get_files();
		$this->assertEquals($expected_count, count($files));
		
		// All files added must exist once again
		foreach ($input as $file)
		{
			$this->assertTrue(in_array($file, $files));
		}
	}
	
	public function test_files_overriden()
	{
		$files = array('foo', 'bar', 'baz');
		$override = array('test');
		
		$s = new Kollection_Script($this->get_mocked_adapter());
		foreach ($files as $file)
		{
			$s->add_file($file);
		}
		
		$this->assertEquals(3, count($s->get_files()));
		
		// Override now
		$s->set_files($override);
		$set_files = $s->get_files();
		$this->assertEquals(1, count($set_files));
		
		foreach ($override as $file)
		{
			$this->assertTrue(in_array($file, $set_files));
		}
	}
}