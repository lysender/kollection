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
		$v = "var $variable = ".$this->_get_js_value($value).';';
		
		return $v;
	}
	
	/**
	 * Returns the js representation for a value
	 * Adds quotes when necessary for strings
	 *
	 * @param   mixed	$value
	 * @return  string
	 */
	protected function _get_js_value($value)
	{
		$v = '';
		if (is_bool($value))
		{
			$v = ($value ? 'true' : 'false');
		}
		elseif (is_int($value) || is_float($value) || is_double($value))
		{
			$v = $value;
		}
		elseif (is_array($value) || is_object($value))
		{
			$v = json_encode($value);
		}
		else
		{
			$v = '"'.$value.'"';
		}
		
		return $v;
	}
	
	/**
	 * Sets the field / element value
	 *
	 * @param   string	$element_id
	 * @param   string  $value
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
		
		$s = 'var field_%s = document.getElementById("%s");'."\n"
			."if (field_%s) {\n"
				.'field_%s.value = "%v";'."\n"
			."}\n";
			
		return str_replace(
			array('%s', '%v'),
			array($element_id, (string) $value),
			$s
		);
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