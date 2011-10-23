<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Page script helper class
 *
 * @package  Kollection_Script
 * @author   lysender
 * @uses     Kohana_HTML
 */
class Kollection_Script {
	
	/**
	 * JavaScript adapter
	 *
	 * @var Kollection_Script_Adapter
	 */
	protected $_adapter;
	
	/**
	 * JavaScript files
	 *
	 * @var array
	 */
	protected $_files = array();
	
	/**
	 * String appended to file to reload cache
	 *
	 * @var string
	 */
	protected $_cache_buster;
	
	/**
	 * Global JS scripts
	 *
	 * @var array
	 */
	protected $_global = array();
	
	/**
	 * Scripts run on document ready
	 *
	 * @var array
	 */
	protected $_ready = array();
	
	/**
	 * Deferred scripts, run after page complete
	 *
	 * @var array
	 */
	protected $_deferred = array();
	
	/**
	 * Script that focuses on a certain element
	 * This is wrapped inside the ready script
	 *
	 * @var string
	 */
	protected $_focus;
	
	/**
	 * Initialize class with an adapter
	 *
	 */
	public function __construct(Kollection_Script_Adapter $adapter)
	{
		$this->set_adapter($adapter);
	}
	
	/**
	 * Sets script adapter
	 *
	 * @param Kollection_Script_Adapter $adapter
	 * @return Kollection_Script
	 */
	public function set_adapter(Kollection_Script_Adapter $adapter)
	{
		$this->_adapter = $adapter;
		
		return $this;
	}
	
	/**
	 * Returns the script adapter
	 *
	 * @return Kollection_Script_Adapter
	 */
	public function get_adapter()
	{
		return $this->_adapter;
	}
	
	/**
	 * Adds a js file
	 *
	 * @param  string	$file
	 * @return Kollection_Script
	 */
	public function add_file($file)
	{
		$this->_files[] = $file;
		
		return $this;
	}
	
	/**
	 * Sets js files overriding the existing
	 *
	 * @param  array $files
	 * @return Kollection_Script
	 */
	public function set_files(array $files)
	{
		$this->_files = $files;
		
		return $this;
	}
	
	/**
	 * Returns all files set
	 *
	 * @return array
	 */
	public function get_files()
	{
		return $this->_files;
	}
}