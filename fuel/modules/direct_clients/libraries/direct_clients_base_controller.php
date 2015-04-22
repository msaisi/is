<?php
class Gradstate_base_controller extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function _common_vars()
	{
		$vars['gradstate'] =& $this->fuel->gradstate;
		$vars['is_gradstate'] = TRUE;
		$vars['page_title'] = '';
		return $vars;
	}	
	function _render($view, $vars = array(), $return = FALSE, $layout = '')
	{

		if (empty($layout)) $layout = $this->fuel->gradstate->layout();

		// get any global variables for the headers and footers 
		$uri_path = trim($this->fuel->gradstate->config('uri'), '/');
		$_vars = $this->fuel->pagevars->retrieve($uri_path);
		
		if (is_array($_vars))
		{
			$vars = array_merge($_vars, $vars);
		}
		$view_folder = $this->fuel->gradstate->theme_path();
		$vars['CI'] =& get_instance();

		$page = $this->fuel->pages->create();
		
		if (!empty($layout))
		{
			$vars['body'] = $this->load->module_view($this->fuel->gradstate->config('theme_module'), $view_folder.$view, $vars, TRUE);
			$view = $this->fuel->gradstate->theme_path().$layout;
		}
		else
		{
			$view = $view_folder.$view;
		}

		$vars = array_merge($vars, $this->load->get_vars());
		$output = $this->load->module_view($this->fuel->gradstate->config('theme_module'), $view, $vars, TRUE);
		$output = $page->fuelify($output);

		if ($return)
		{
			return $output;
		}
		else
		{
			$this->output->set_output($output);
		}
	}
}