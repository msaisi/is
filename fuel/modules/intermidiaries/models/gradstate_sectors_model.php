<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_sectors_model extends Base_module_model 
{	
	public $required = array('name'); 
	public $filters = array('name','published');
	public $unique_fields = array('slug'); 
	public $hidden_fields= array('slug'); 
	public $gradstate_config=array();
	
	public function __construct()
	{
		parent::__construct('gradstate_sectors', GRADSTATE_FOLDER);
	}
	function filters()
	{
	   $filters['name'] = array('label'=>'Sector');	  
	   $filters['published'] = array('label' => 'Published', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'desc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$this->db->select('id,name,published',FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}

	public function form_fields($values = array(), $related = array())
	{
		$fields = parent::form_fields($values, $related);
		
		$fields['name']['style'] = 'width: 350px;';

		return $fields;	
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name')
	{
		$order = $val;
		$return = parent::options_list($key, $val, $where, $order);
		return $return;
	}
	function on_before_clean($values)
	{
		$values['slug'] = strtolower(url_title($values['name'], 'dash', TRUE));
		return $values;
	}
}