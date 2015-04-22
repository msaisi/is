<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FUEL CMS
 * http://www.getfuelcms.com
 *
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @package		FUEL CMS
 * @author		David McReynolds @ Daylight Studio
 * @copyright	Copyright (c) 2013, Run for Daylight LLC.
 * @license		http://docs.getfuelcms.com/general/license
 * @link		http://www.getfuelcms.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Blog Helper
 *
 * @package		Blog
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David McReynolds @ Daylight Studio
 * @link		http://docs.getfuelcms.com/modules/gradstate/gradstate_helper
 */


// --------------------------------------------------------------------

/**
 * Returns a gradstate specific URI. Convience function that maps to fuel_gradstate->url()
 *
 * @access	public
 * @param	string
 * @return	string
 */
function gradstate_url($uri = '')
{
	$CI =& get_instance();
	return $CI->fuel->gradstate->url($uri);
}

// --------------------------------------------------------------------

/**
 * Returns an HTML block from the specified theme's _block
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	boolean
 * @return	string
 */
function gradstate_block($view, $vars = array(), $return = TRUE)
{
	$CI =& get_instance();
	$view_folder = $CI->fuel->gradstate->theme_path();
	$block = $CI->load->module_view(GRADSTATE_FOLDER, $view_folder.'_blocks/'.$view, $vars, TRUE);
	if ($return)
	{
		return $block;
	}
	echo $block;
}

/* End of file gradstate_helper.php */
/* Location: ./modules/gradstate/helpers/gradstate_helper.php */