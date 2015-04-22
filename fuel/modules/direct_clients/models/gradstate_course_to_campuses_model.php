<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_course_to_campuses_model extends Base_module_model 
{	
	public function __construct()
	{
		parent::__construct('gradstate_course_campus', GRADSTATE_FOLDER);
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	public function options_list($key = 'id', $val = 'campus_id', $where = array(), $order = 'campus_id')
	{		
		if ($key === 'id')
		{
			$key = $this->table_name.'.id';
		}		
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}

}