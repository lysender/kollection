<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Bootstrap css framework specific js script helper
 * An adapter to Kollection_Script
 *
 * @package  Kollection_Script
 * @author   lysender
 */
class Kollection_Script_Bootstrap extends Kollection_Script_Jquery {
	
	/**
	 * Highlights the form element that has error
	 * This element should conform to the twitter bootstrap form convention
	 *
	 * @param   string	$field
	 * @return  string
	 */
	public function highlight_error($field)
	{
		// In bootstrap framework, each form element is wrapped in a div
		// with class "clearfix" which represents the whole block for that
		// form element
		$s = '$("#'.$field.'").addClass("error").parents("div.clearfix").addClass("error");'."\n";
		
		return $s;
	}
}