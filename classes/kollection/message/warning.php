<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Warning message - default display type
 *
 * @package  Kollection_Message
 * @author   Lysender
 */
class Kollection_Message_Warning extends Kollection_Message {
	
	protected $_display = Kollection_Message::DISPLAY_DEFAULT;
	protected $_type = Kollection_Message::TYPE_WARNING;
}