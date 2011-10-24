<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Page script adapter class
 *
 * @package  Kollection_Script
 * @author   lysender
 */
class Kollection_Script_Adapter {
	
	/**
	 * Returns a js script for focusing on a certain form element
	 *
	 * @param   string	$field
	 * @return  string
	 */
	public function focus($field)
	{	
		$s = 'var field_%s = document.getElementById("%s");'."\n"
			."if (field_%s) {\n"
				."field_%s.setFocus();\n"
			."}\n";
			
		return str_replace('%s', $field, $s);
	}
	
	/**
	 * Returns the ready script with contents
	 *
	 * @param   string	$contents
	 * @return  string
	 */
	public function ready($contents)
	{
		// Adapter does not have this ability yet
		return $contents;
	}
	
	/**
	 * Returns the deferred script with contents
	 *
	 * @param   string	$contents
	 * @return  string
	 */
	public function deferred($contents)
	{
		return "window.onload = function() {\n$contents\n};\n";
	}
	
	/**
	 * Returns the script tag with contents
	 *
	 * @param   string	$contents
	 * @return  string
	 */
	public function generate_tag($contents)
	{
		$s = '';
		
		if ($contents)
		{
			$s = '<script type="text/javascript">'
					.$contents
				.'</script>';
		}
		
		return $s;
	}
	
	/**
	 * Generates a javascript variable script
	 *
	 * @param   string	$variable
	 * @param   mixed	$value
	 * @return  string
	 */
	public function js_var($variable, $value)
	{
		$v = "var $variable = ";
		
		if (is_bool($value))
		{
			$v .= ($value ? 'true' : 'false').';';
		}
		elseif (is_int($value) || is_float($value) || is_double($value))
		{
			$v .= $value.';';
		}
		elseif (is_array($value) || is_object($value))
		{
			$v .= json_encode($value).';';
		}
		else
		{
			$v .= '"'.$value.'";';
		}
		
		return $v;
	}
	
	/**
	 * Highlights the form field for errors
	 *
	 * @param   string	$field
	 * @return  string
	 */
	public function highlight_error($field)
	{
		// Adapter doesn't have this ability yet
		return '';
	}
}