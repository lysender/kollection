<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Site messaging class
 *
 * @package  Kollection_Message
 * @author   Lysender
 */
class Kollection_Message {
	
	const TYPE_ERROR = 'error';
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_INFO = 'info';
	
	const DISPLAY_BLOCK = 'block';
	const DISPLAY_PLAIN = 'plain';
	
	/**
	 * Error type mapping
	 *
	 * @var  array
	 */
	protected $_error_types = array(
		self::TYPE_ERROR => 'error',
		self::TYPE_SUCCESS => 'success',
		self::TYPE_WARNING => 'warning',
		self::TYPE_INFO => 'info'
	);
	
	/**
	 * @var  string
	 */
	protected $_error_type;
	
	/**
	 * Reference to Kollection_Script instance
	 * 
	 * @var  Kollection_Script
	 */
	protected $_script;
	
	/**
	 * View helper that handles how the message is rendered
	 * 
	 * @var  Kollection_Message_View
	 */
	protected $_view;
	
	
}