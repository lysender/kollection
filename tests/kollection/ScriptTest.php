<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Script helper class
 *
 */
class Kollection_ScriptTest extends Kohana_Unittest_TestCase {
	
	/**
	 * @var  Kollection_Script_Adapter
	 */
	protected $_script_adapter;
	
	/**
	 * Sets up the script adapter
	 *
	 * @return  void
	 */
	public function setUp()
	{
		$stub = $this->getMock('Kollection_Script_Adapter');
		
		// Setup mock methods to simply return the passed argument
		$stub->expects($this->any())
			->method('focus')
			->will($this->returnArgument(0));
		
		$stub->expects($this->any())
			->method('ready')
			->will($this->returnArgument(0));
			
		$stub->expects($this->any())
			->method('deferred')
			->will($this->returnArgument(0));
			
		$stub->expects($this->any())
			->method('generate_tag')
			->will($this->returnArgument(0));
			
		$this->_script_adapter = $stub;
	}
	
	/**
	 * Cleans up the mocked adapter
	 *
	 * @return  void
	 */
	public function tearDown()
	{
		$this->_script_adapter = NULL;
	}
	
	public function test_object()
	{
		$obj = new Kollection_Script($this->_script_adapter);
		$this->assertType('Kollection_Script', $obj);
	}
	
	/**
	 * @expectedException  ErrorException
	 */
	public function test_adapter_invalid()
	{
		$s = new Kollection_Script($this->_script_adapter);
		$s->set_adapter(new stdClass);
	}
	
	public function test_adapter_valid()
	{
		$s = new Kollection_Script($this->_script_adapter);
		$s->set_adapter($this->getMock('Kollection_Script_Adapter'));
		
		$this->assertNotSame($this->_script_adapter, $s->get_adapter());
		$this->assertType('Kollection_Script_Adapter', $s->get_adapter());
		
		$s->set_adapter($this->_script_adapter);
		$this->assertSame($this->_script_adapter, $s->get_adapter());
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
	 * @param   array 	$input
	 * @param   int		$expected_count
	 * @return  void
	 */
	public function test_files(array $input, $expected_count)
	{
		$s = new Kollection_Script($this->_script_adapter);
		
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
		
		$s = new Kollection_Script($this->_script_adapter);
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
	
	public function cache_buster_provider()
	{
		return array(
			array('foo', 'foo'),
			array('bar', 'bar'),
			array('testtesttest', 'testtesttest')
		);
	}
	
	/**
	 * @dataProvider	cache_buster_provider
	 * @param   string	$input
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_cache_buster($input, $expected)
	{
		$s = new Kollection_Script($this->_script_adapter);
		
		// At first, no cache buster is set
		$this->assertEquals(NULL, $s->get_cache_buster());
		
		// Set cache buster
		$s->set_cache_buster($input);
		
		// Prove that it was set
		$this->assertEquals($expected, $s->get_cache_buster());
	}
	
	public function script_provider()
	{
		return array(
			array(
				array('global', 'ready', 'deferred'),
				array('var a = 0;'),
				1
			),
			array(
				array('global', 'ready', 'deferred'),
				array('var b = 1;', 'alert("test1");', 'funky();'),
				3
			),
			array(
				array('global', 'ready', 'deferred'),
				array('var x = null;', 'var y = null;', 'var x = [];', 'popupMe();'),
				4
			)
		);
	}
	
	/**
	 * @dataProvider	script_provider
	 *
	 * @param   array	$types
	 * @param   array 	$scripts
	 * @param   int		$expected_count
	 * @return  void
	 */
	public function test_scripts(array $types, array $scripts, $expected_count)
	{
		foreach ($types as $type)
		{
			$add_method = 'add_'.$type.'_script';
			$get_method = 'get_'.$type.'_scripts';
			$set_method = 'set_'.$type.'_scripts';
			
			$s = new Kollection_Script($this->_script_adapter);
			
			// Use the add method to add the script
			foreach ($scripts as $script)
			{
				call_user_func(array($s, $add_method), $script);
			}
			
			// Prove the count by using the get method
			$added_scripts = call_user_func(array($s, $get_method));
			$this->assertEquals($expected_count, count($added_scripts));
			
			// All scripts added must exist
			foreach ($scripts as $script)
			{
				$this->assertTrue(in_array($script, $added_scripts));
			}
			
			// Clear scripts
			call_user_func(array($s, $set_method), array());
			$new_count = count(call_user_func(array($s, $get_method)));
			$this->assertEquals(0, $new_count);
			
			// Set scripts at once
			call_user_func(array($s, $set_method), $scripts);
			
			$added_scripts = call_user_func(array($s, $get_method));
			$this->assertEquals($expected_count, count($added_scripts));
			
			// All scripts added must exist once again
			foreach ($scripts as $script)
			{
				$this->assertTrue(in_array($script, $added_scripts));
			}
		}
	}
	
	public function test_scripts_overriden()
	{
		$scripts = array('foo();', 'bar();', 'baz();');
		$override = array('test();');
		$types = array('global', 'ready', 'deferred');
		
		foreach ($types as $type)
		{
			$add_method = 'add_'.$type.'_script';
			$get_method = 'get_'.$type.'_scripts';
			$set_method = 'set_'.$type.'_scripts';
			
			$s = new Kollection_Script($this->_script_adapter);
			
			foreach ($scripts as $script)
			{
				call_user_func(array($s, $add_method), $script);
			}
			
			$script_count = count(call_user_func(array($s, $get_method)));
			$this->assertEquals(3, $script_count);
			
			// Override now
			call_user_func(array($s, $set_method), $override);
			$set_scripts = call_user_func(array($s, $get_method));
			$this->assertEquals(1, count($set_scripts));
			
			foreach ($override as $script)
			{
				$this->assertTrue(in_array($script, $set_scripts));
			}
		}
	}
	
	public function focus_script_provider()
	{
		return array(
			array('foo', 'foo'),
			array('bar', 'bar'),
			array('testtesttest', 'testtesttest')
		);
	}
	
	/**
	 * @dataProvider	focus_script_provider
	 * @param   string	$input
	 * @param   string	$expected
	 * @return  void
	 */
	public function test_focus_script($input, $expected)
	{
		$s = new Kollection_Script($this->_script_adapter);
		
		// At first, no focus script is set
		$this->assertEquals(NULL, $s->get_focus_script());
		
		// Set focus script
		$s->set_focus_script($input);
		
		// Prove that it was set
		$this->assertEquals($expected, $s->get_focus_script());
	}
	
	public function render_provider()
	{
		return array(
			// Complete with all script components
			array(
				array('file1', 'file2'),
				'?v=1.0.0',
				array('gFoo1();', 'gFoo2();', 'gFoo3();'),
				array('rFoo1();', 'rFoo2();'),
				array('dFoo1();'),
				'fooFocus1();',
				(
					HTML::script('file1?v=1.0.0')."\n"
					.HTML::script('file2?v=1.0.0')."\n"
					."gFoo1();\n"
					."gFoo2();\n"
					."gFoo3();\n"
					."rFoo1();\n"
					."rFoo2();\n"
					."fooFocus1();\n"
					."dFoo1();\n"
				)
			),
			// No cache buster
			array(
				array('file1', 'file2'),
				NULL,
				array('gFoo1();', 'gFoo2();', 'gFoo3();'),
				array('rFoo1();', 'rFoo2();'),
				array('dFoo1();'),
				'fooFocus1();',
				(
					HTML::script('file1')."\n"
					.HTML::script('file2')."\n"
					."gFoo1();\n"
					."gFoo2();\n"
					."gFoo3();\n"
					."rFoo1();\n"
					."rFoo2();\n"
					."fooFocus1();\n"
					."dFoo1();\n"
				)
			),
			// No deferred scripts
			array(
				array('file1', 'file2'),
				'?v=1.0.0',
				array('gFoo1();', 'gFoo2();', 'gFoo3();'),
				array('rFoo1();', 'rFoo2();'),
				array(),
				'fooFocus1();',
				(
					HTML::script('file1?v=1.0.0')."\n"
					.HTML::script('file2?v=1.0.0')."\n"
					."gFoo1();\n"
					."gFoo2();\n"
					."gFoo3();\n"
					."rFoo1();\n"
					."rFoo2();\n"
					."fooFocus1();\n"
				)
			),
			// No focus script
			array(
				array('file1', 'file2'),
				'?v=1.0.0',
				array('gFoo1();', 'gFoo2();', 'gFoo3();'),
				array('rFoo1();', 'rFoo2();'),
				array('dFoo1();'),
				NULL,
				(
					HTML::script('file1?v=1.0.0')."\n"
					.HTML::script('file2?v=1.0.0')."\n"
					."gFoo1();\n"
					."gFoo2();\n"
					."gFoo3();\n"
					."rFoo1();\n"
					."rFoo2();\n"
					."dFoo1();\n"
				)
			),
			// Only a single js file
			array(
				array('file1'),
				NULL,
				array(),
				array(),
				array(),
				NULL,
				(
					HTML::script('file1')."\n"
				)
			),
		);
	}
	
	/**
	 * This is a mocked test where an external dependency is required.
	 * 
	 * To prove that the tests pass, all inputs must exist on output
	 * using the behavior only seen on Kollection_Script class.
	 *
	 * @dataProvider	render_provider
	 * @param  array	$files
	 * @param  string	$cache_buster
	 * @param  array	$global
	 * @param  array	$ready
	 * @param  array	$deferred
	 * @param  string	$focus
	 * @param  string	$expected
	 */
	public function test_render(array $files, $cache_buster, array $global, array $ready, array $deferred, $focus, $expected)
	{
		$s = new Kollection_Script($this->_script_adapter);
		
		// Set files
		if ( ! empty($files))
		{
			$s->set_files($files);
		}
		
		// Set cache buster
		if ( ! empty($cache_buster))
		{
			$s->set_cache_buster($cache_buster);
		}
		
		// Set global scripts
		if ( ! empty($global))
		{
			$s->set_global_scripts($global);
		}
		
		// Set ready scripts
		if ( ! empty($ready))
		{
			$s->set_ready_scripts($ready);
		}
		
		// Set deferred
		if ( ! empty($deferred))
		{
			$s->set_deferred_scripts($deferred);
		}
		
		// Set focus
		if ( ! empty($focus))
		{
			$s->set_focus_script($focus);
		}
		
		$this->assertEquals($expected, $s->render());
		$this->assertEquals($expected, (string) $s);
	}
}
