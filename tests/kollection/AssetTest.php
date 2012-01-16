<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Unit tests for Kollection_Asset helper class
 *
 */
class Kollection_AssetTest extends Kohana_Unittest_TestCase {
	
	/** 
	 * Provides test data
	 *
	 * @return  array
	 */
	public function assets_provider()
	{
		return array(
			// No config
			array(
				NULL,
				array(
					'reset.css' => 'reset.css',
					'css/reset.css' => 'css/reset.css',
					'/jquery.js' => '/jquery.js',
					'/js/jquery.js' => '/js/jquery.js'
				)
			),
			// No protocol, no domain, just prefix
			array(
				array(
					'protocol' => '',
					'domain' => '',
					'path_prefix' => '/asset1/media'
				),
				array(
					'/jquery.js' => '/asset1/media/jquery.js',
					'/js/jquery.js' => '/asset1/media/js/jquery.js'
				)
			),
			// No protocol, with domain and prefix
			array(
				array(
					'protocol' => '',
					'domain' => 's.lysender.com',
					'path_prefix' => '/asset1/media'
				),
				array(
					'/jquery.js' => '//s.lysender.com/asset1/media/jquery.js',
					'/js/jquery.js' => '//s.lysender.com/asset1/media/js/jquery.js'
				)
			),
			// With protocol, domain and prefix
			array(
				array(
					'protocol' => 'http',
					'domain' => 's.lysender.com',
					'path_prefix' => '/asset1/media'
				),
				array(
					'/jquery.js' => 'http://s.lysender.com/asset1/media/jquery.js',
					'/js/jquery.js' => 'http://s.lysender.com/asset1/media/js/jquery.js'
				)
			),
			// With https protocol, domain and prefix
			array(
				array(
					'protocol' => 'https',
					'domain' => 's.lysender.com',
					'path_prefix' => '/asset1/media'
				),
				array(
					'/jquery.js' => 'https://s.lysender.com/asset1/media/jquery.js',
					'/js/jquery.js' => 'https://s.lysender.com/asset1/media/js/jquery.js'
				)
			),
			// With protocol, domain and no prefix
			array(
				array(
					'protocol' => 'http',
					'domain' => 's.lysender.com',
					'path_prefix' => ''
				),
				array(
					'/jquery.js' => 'http://s.lysender.com/jquery.js',
					'/js/jquery.js' => 'http://s.lysender.com/js/jquery.js'
				)
			),
		);
	}


	/** 
	 * @dataProvider	assets_provider
	 * @param   mixed	$config
	 * @param   array 	$test_cases
	 */
	public function test_assets($config, array $test_cases)
	{
		$obj = NULL;

		if (is_array($config))
		{
			$obj = new Kollection_Asset($config);
		}
		else
		{
			$obj = new Kollection_Asset;
		}

		foreach ($test_cases as $file => $expected)
		{
			$this->assertEquals($expected, $obj->asset_url($file));
		}
	}
}
