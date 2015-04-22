<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_university_inquiries_model extends Base_module_model 
{	
	public $auto_date_add = array('inquiry_date');
	
	public function __construct()
	{
		parent::__construct('gradstate_university_inquiries', GRADSTATE_FOLDER);
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	function on_before_clean($values)
	{
		$values['inquiry_id'] = empty($values['inquiry_id'])? strtoupper(gen_unique_id(10)): $values['inquiry_id'];	
		return $values;
	}
}