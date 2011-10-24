<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Page script helper class
 *
 * @package  Kollection_Script
 * @author   lysender
 */
class Kollection_Script {
	
	/**
	 * JavaScript adapter
	 *
	 * @var  Kollection_Script_Adapter
	 */
	protected $_adapter;
	
	/**
	 * JavaScript files
	 *
	 * @var  array
	 */
	protected $_files = array();
	
	/**
	 * String appended to file to reload cache
	 *
	 * @var  string
	 */
	protected $_cache_buster;
	
	/**
	 * Global JS scripts
	 *
	 * @var  array
	 */
	protected $_global_scripts = array();
	
	/**
	 * Scripts run on document ready
	 *
	 * @var  array
	 */
	protected $_ready_scripts = array();
	
	/**
	 * Deferred scripts, run after page complete
	 *
	 * @var  array
	 */
	protected $_deferred_scripts = array();
	
	/**
	 * Script that focuses on a certain element
	 * This is wrapped inside the ready script
	 *
	 * @var  string
	 */
	protected $_focus_script;
	
	/**
	 * Initialize class with an adapter
	 *
	 * @param   Kollection_Script_Adapter $adapter
	 * @return  void
	 */
	public function __construct(Kollection_Script_Adapter $adapter)
	{
		$this->set_adapter($adapter);
	}
	
	/**
	 * Sets script adapter
	 *
	 * @param   Kollection_Script_Adapter $adapter
	 * @return  Kollection_Script
	 */
	public function set_adapter(Kollection_Script_Adapter $adapter)
	{
		$this->_adapter = $adapter;
		
		return $this;
	}
	
	/**
	 * Returns the script adapter
	 *
	 * @return  Kollection_Script_Adapter
	 */
	public function get_adapter()
	{
		return $this->_adapter;
	}
	
	/**
	 * Adds a js file
	 *
	 * @param   string	$file
	 * @return  Kollection_Script
	 */
	public function add_file($file)
	{
		$this->_files[] = $file;
		
		return $this;
	}
	
	/**
	 * Sets js files overriding the existing
	 *
	 * @param   array $files
	 * @return  Kollection_Script
	 */
	public function set_files(array $files)
	{
		$this->_files = $files;
		
		return $this;
	}
	
	/**
	 * Returns all files set
	 *
	 * @return  array
	 */
	public function get_files()
	{
		return $this->_files;
	}
	
	/**
	 * Sets the cache buster suffix
	 *
	 * @param   string $str
	 * @return  Pagescript
	 */
	public function set_cache_buster($str)
	{
		$this->_cache_buster = $str;
		
		return $this;
	}
	
	/**
	 * Returns the cache buster suffix
	 *
	 * @return  string
	 */
	public function get_cache_buster()
	{
		return $this->_cache_buster;
	}
	
	/**
	 * Adds a global script code
	 *
	 * @param   string $script
	 * @return  Pagescript
	 */
	public function add_global_script($script)
	{
		$this->_global_scripts[] = $script;
		
		return $this;
	}
	
	/**
	 * Sets global scripts overriding the existing
	 *
	 * @param   array	$scripts
	 * @return  Kollection_Script
	 */
	public function set_global_scripts(array $scripts)
	{
		$this->_global_scripts = $scripts;
		
		return $this;
	}
	
	/**
	 * Returns all global scripts
	 *
	 * @return  array
	 */
	public function get_global_scripts()
	{
		return $this->_global_scripts;
	}
	
	/**
	 * Adds a js script on document ready
	 *
	 * @param   string 	$script
	 * @return  Pagescript
	 */
	public function add_ready_script($script)
	{
		$this->_ready_scripts[] = $script;
		
		return $this;
	}
	
	/**
	 * Sets ready scripts overriding the existing
	 *
	 * @param   array	$scripts
	 * @return  Kollection_Script
	 */
	public function set_ready_scripts(array $scripts)
	{
		$this->_ready_scripts = $scripts;
		
		return $this;
	}
	
	/**
	 * Returns ready scripts
	 *
	 * @return  array
	 */
	public function get_ready_scripts()
	{
		return $this->_ready_scripts;
	}
	
	/**
	 * Adds a deferred script
	 *
	 * @param   string	$script
	 * @return  Kollection_Script
	 */
	public function add_deferred_script($script)
	{
		$this->_deferred_scripts[] = $script;
		
		return $this;
	}
	
	/**
	 * Set deferred scripts overriding the existing
	 *
	 * @param   array	$scripts
	 * @return  Kollection_Script
	 */
	public function set_deferred_scripts(array $scripts)
	{
		$this->_deferred_scripts = $scripts;
		
		return $this;
	}
	
	/**
	 * Returns deferred scripts
	 *
	 * @return  array
	 */
	public function get_deferred_scripts()
	{
		return $this->_deferred_scripts;
	}
	
	/**
	 * Sets a script to focus on a form element
	 *
	 * @param   string		$field
	 * @return  Kollection_Script
	 */
	public function set_focus_script($field)
	{
		$this->_focus_script = $this->get_adapter()->focus($field);
		
		return $this;
	}
	
	/**
	 * Returns the focus script
	 *
	 * @return  string
	 */
	public function get_focus_script()
	{
		return $this->_focus_script;
	}
	
	/**
	 * Returns all scripts including the global scripts,
	 * ready scripts and deferred scripts all wrapped in a
	 * script tag
	 *
	 * @uses    HTML::script
	 * @return  string
	 */
	public function get_all_scripts()
	{
		$contents = '';
		$ret = '';
		
		$js = $this->get_adapter();
		
		// Generate tags for the js files
		$c = $this->get_cache_buster();
		$files = $this->get_files();
		
		foreach ($files as $file)
		{
			$ret .= HTML::script($file.$c)."\n";
		}
		
		// Add focus script to ready scripts
		$focus = $this->get_focus_script();
		
		if ($focus)
		{
			$this->add_ready_script($focus);
		}
		
		// Generate global scripts
		$global_scripts = $this->get_global_scripts();
		
		if ( ! empty($global_scripts)) {
			$contents .= implode("\n", $global_scripts)."\n";
		}
		
		// Generate ready scripts
		$ready_scripts = $this->get_ready_scripts();
		
		if ( ! empty($ready_scripts))
		{
			$contents .= $js->ready(implode("\n", $ready_scripts))."\n";
		}
		
		// Generate deferred scripts
		$deferred_scripts = $this->get_deferred_scripts();
		
		if ( ! empty($deferred_scripts))
		{
			$contents .= $js->deferred(implode("\n", $deferred_scripts))."\n";
		}
		
		// Generate tag for containing all the scripts
		$ret .= $js->generate_tag($contents);
		
		return $ret;
	}
}
