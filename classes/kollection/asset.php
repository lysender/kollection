<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Site messaging class
 *
 * @package  Kollection_Message
 * @author   Lysender
 */
class Kollection_Asset {
	
	/** 
	 * Protocol to use
	 *
	 * @var  string
	 */
	protected $_protocol;

	/** 
	 * Domain name to use, must no include protocol and trailing slash
	 *
	 * @var  string
	 */
	protected $_domain;

	/** 
	 * Prefix to prepend to asset URL paths
	 *
	 * @var  string
	 */
	protected $_path_prefix;

	/** 
	 * Prefix to prepend to asset cannonical URLs
	 * This is pre-calculated upon initialization
	 *
	 * @var  string
	 */
	protected $_asset_prefix;

	/** 
	 * Initializes the asset object's configuration
	 *
	 * Config keys:
	 * 		protocol
	 *		domain
	 * 		path_prefix
	 *
	 * @param   array	$config
	 * @return  void
	 */
	public function __construct(array $config = array())
	{
		$this->_protocol = Arr::get($config, 'protocol');
		$this->_domain = Arr::get($config, 'domain');
		$this->_path_prefix = Arr::get($config, 'path_prefix');

		// Generate asset prefix
		$prefix = '';

		if ($this->_domain)
		{
			if ($this->_protocol)
			{
				$prefix = $this->_protocol.'://'.$this->_domain;
			}
			else
			{
				$prefix = '//'.$this->_domain;
			}
		}

		$this->_asset_prefix = $prefix.$this->_path_prefix;
	}

	/** 
	 * Returns the asset url based on config
	 * When using path prefix, trailing slash and leading slash must be
	 * handled by the developer
	 *
	 * @param   string	$file
	 * @return  string
	 */
	public function asset_url($file)
	{
		return $this->_asset_prefix.$file;
	}
}