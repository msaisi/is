<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/companies/config/companies_constants.php');

class Companies_countries_model extends Base_module_model
{
	function __construct()
	{
		parent::__construct('companies_countries', COMPANIES_FOLDER); // table name
	}
	
	function _common_query()
	{
		parent::_common_query();
		$this->db->select("*", FALSE);
	}
	function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name')
	{
		$order = $val;
		$return = parent::options_list($key, $val, $where, $order);
		return $return;
	}	
}