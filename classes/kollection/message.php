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
	
	const DISPLAY_LIST = 'list';
	const DISPLAY_DEFAULT = 'default';
	
	/**
	 * Error type mapping
	 *
	 * @var  array
	 */
	protected $_types = array(
		self::TYPE_ERROR => 'error',
		self::TYPE_SUCCESS => 'success',
		self::TYPE_WARNING => 'warning',
		self::TYPE_INFO => 'info'
	);
	
	/**
	 * @var  string
	 */
	protected $_type;
	
	/**
	 * @var  array
	 */
	protected $_display_types = array(
		self::DISPLAY_DEFAULT => 'default',
		self::DISPLAY_LIST => 'list'
	);
	
	/**
	 * Determines how the message is dislayed
	 *
	 * @var  string
	 */
	protected $_display;
	
	/**
	 * Message title
	 *
	 * @var  string
	 */
	protected $_title;
	
	/**
	 * Messages
	 *
	 * @var  array
	 */
	protected $_messages = array();
	
	/**
	 * View helper that handles how the message is rendered
	 * 
	 * @var  View
	 */
	protected $_view;
	
	/**
	 * Initializes the instance
	 *
	 * @param   array	$options
	 * @return  void
	 */
	public function __construct(array $options = array())
	{
		foreach ($options as $key => $option)
		{
			$method = 'set_'.$key;
			
			if (method_exists($this, $method))
			{
				call_user_func(array($this, $method), $option);
			}
		}
	}
	
	/**
	 * Sets error type
	 *
	 * @param   string	$type
	 * @return  Kollection_Message
	 */
	public function set_type($type)
	{
		if ( ! isset($this->_types[$type]))
		{
			throw new Kollection_Message_Exception('Error type is invalid');
		}
		
		$this->_type = $type;
		
		return $this;
	}
	
	/**
	 * Returns the error type
	 *
	 * @return  string
	 */
	public function get_type()
	{
		return $this->_type;
	}
	
	/**
	 * Sets display type
	 *
	 * @param   string	$display
	 * @return  Kollection_Message
	 */
	public function set_display($display)
	{
		if ( ! isset($this->_display_types[$display]))
		{
			throw new Kollection_Message_Exception('Display type is invalid');
		}
		
		$this->_display = $display;
		
		return $this;
	}
	
	/**
	 * Returns the display type
	 *
	 * @return  string
	 */
	public function get_display()
	{
		return $this->_display;
	}
	
	/**
	 * Sets message title
	 *
	 * @param   strin	$title
	 * @return  Kollection_Message
	 */
	public function set_title($title)
	{
		$this->_title = $title;
		
		return $this;
	}
	
	/**
	 * Returns message title
	 *
	 * @return  string
	 */
	public function get_title()
	{
		return $this->_title;
	}
	
	/**
	 * Sets view
	 *
	 * @param   View	$view
	 * @return  Kollection_Message
	 */
	public function set_view(View $view)
	{
		$this->_view = $view;
		
		return $this;
	}
	
	/**
	 * Returns view
	 *
	 * @return  View
	 */
	public function get_view()
	{
		if ($this->_view === NULL)
		{
			// Set the default view
			$this->_view = View::factory('kollection/message/'.$this->get_display());
		}
		
		return $this->_view;
	}
	
	/**
	 * Sets messages
	 *
	 * @param   mixed	$messages
	 * @return  Kollection_Message
	 */
	public function set_messages($messages)
	{
		if (is_array($messages))
		{
			// Merge external errors from orm validation
			// to the main error array
			if ( ! empty($messages['_external']))
			{
				$ext = $messages['_external'];
				unset($messages['_external']);
				
				foreach ($ext as $key => $value)
				{
					$messages[$key] = $value;
				}
			}
		}
		
		$this->_messages = $messages;
		
		return $this;
	}
	
	/**
	 * Returns messages
	 *
	 * @return  array
	 */
	public function get_messages()
	{
		return $this->_messages;
	}
	
	/**
	 * Renders the message into html
	 *
	 * @return  string
	 */
	public function render()
	{
		$view = $this->get_view();
		
		$view->set('title', $this->get_title())
			->set('messages', $this->get_messages())
			->set('type', $this->get_type());
		
		return $view->render();
	}
	
	/**
	 * Alias to render
	 *
	 * @return  string
	 */
	public function __toString()
	{
		return $this->render();
	}
}