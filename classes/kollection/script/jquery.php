<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * jQuery adapter for Kollection_Script
 *
 * @package  Kollection_Script
 * @author   lysender
 */
class Kollection_Script_Jquery extends Kollection_Script_Adapter {
	
	/**
	 * Returns a js script for focusing on a certain form element
	 *
	 * @param   string	$field
	 * @return  string
	 */
	public function focus($field)
	{
		$s = '$("#'.$field.'").focus();'."\n";
		return $s;
	}
	
	/**
	 * Returns the ready script with contents
	 *
	 * @param   string	$contents
	 * @return  string
	 */
	public function ready($contents)
	{
		$s = '';
		
		if ($contents)
		{
			$s = "$(function() {\n"
					.$contents."\n"
				."});\n";
		}
		
		return $s;
	}
	
	/**
	 * Returns the deferred script with contents
	 *
	 * @param   string	$contents
	 * @return  string
	 */
	public function deferred($contents)
	{
		$s = '';
		
		if ($contents)
		{
			$s = "$(window).load(function() {\n"
					.$contents."\n"
				."});\n";
		}
		
		return $s;
	}
	
	/**
	 * Sets the form element value using jQuery syntax
	 *
	 * @param   string	$element_id
	 * @param   string	$value
	 * @return  string
	 */
	public function field_value($element_id, $value)
	{
		// Only strings and numbers can be set to form fields
		// Numbers and floats will be converted to string
		if (is_object($value) || is_array($value) || is_bool($value))
		{
			throw new Kollection_Script_Exception('Values accepted are only strings and integers/floats.');
		}
		
		$s = '$("#%s").val("%v");'."\n";
		
		return str_replace(
			array('%s', '%v'),
			array($element_id, (string) $value),
			$s
		);
	}
}