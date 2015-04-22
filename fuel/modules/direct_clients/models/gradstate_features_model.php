<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_features_model extends Base_module_model 
{	
	public $required = array('name','price','description'); 
	public $filters = array('name','price');
	public $unique_fields = array('slug'); 
	//public $linked_fields = array('slug' => array('name' => 'url_title'));	
	public $hidden_fields= array('slug'); 
	public $gradstate_config=array();
	public $currency;
	
	public $CI=null;
	public function __construct()
	{
		parent::__construct('gradstate_features', GRADSTATE_FOLDER);
		$this->CI =& get_instance();							
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->currency=$this->gradstate_config['currency'];
	}
	function filters()
	{
	   $filters['name'] = array('label'=>'Name');
	   $filters['price'] = array('label'=>'Price','currency'=>'kes. ');	  
	   $filters['published'] = array('label' => 'published', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   return $filters;
	}
	
	public function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'desc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$this->db->select('id,name,price,published',FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}

	public function form_fields($values = array(), $related = array())
	{
		$fields = parent::form_fields($values, $related);
		
		$fields['name']['style'] = 'width: 350px;';

		$fields['price']['currency']=$this->currency;
		$fields['price']['style'] = 'width: 150px;';
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
		//$values['slug'] = strtolower($values['slug']);
		$values['slug'] = strtolower(url_title($values['name'], 'dash', TRUE));
		
		return $values;
	}
}