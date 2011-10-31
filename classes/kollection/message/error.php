<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Error message - default display type
 *
 * @package  Kollection_Message
 * @author   Lysender
 */
class Kollection_Message_Error extends Kollection_Message {
	
	protected $_display = Kollection_Message::DISPLAY_DEFAULT;
	protected $_type = Kollection_Message::TYPE_ERROR;
}