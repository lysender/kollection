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
}