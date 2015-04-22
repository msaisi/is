<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/companies/config/companies_constants.php');

class Companies_departments_model extends Base_module_model
{
	public $auto_date_add = array('date_added');
	public $auto_date_update = array('last_modified');
	public $hidden_fields = array('department_code','last_modified','date_added');


	public $required = array('name', 'company_code');
	public $filters = array('name', 'company_code'); // Additional fields that will be searched
	public $unique_fields = array('department_code'); // User name is a unique field
	
		
	function __construct()
	{
		parent::__construct('companies_departments', COMPANIES_FOLDER); // table name
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
    function on_before_clean($values)
	{				
		$values['department_code'] = empty($values['department_code'])? gen_unique_id("",20) : $values['department_code'];
		return $values;		
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);
		$fields['company_code']['label']='Affiliated Insurer';
		$fields['company_code']['type']='select';
		$fields['company_code']['first_option']='select one...';
		$fields['company_code']['options']=$this->companies_accounts_model->options_list('system_id','name');

		unset($fields['reset_key'], $fields['salt']);
		return $fields;
	
	}
}