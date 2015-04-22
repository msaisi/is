<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_package_pricing_model extends Base_module_model 
{	
	public $required = array('package_group','validity','price'); 
	public $filters = array('name','package_group','validity','price');
	public $unique_fields = array('slug'); 
	public $hidden_fields= array('name'); 
	public $gradstate_config=array();
	public $currency;
	
	public $CI=null;
	public function __construct()
	{
		parent::__construct('gradstate_package_pricing', GRADSTATE_FOLDER);	
		$this->CI =& get_instance();							
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->currency=$this->gradstate_config['currency'];
	}	

	function filters()
	{
	   $filters['name'] = array('label'=>'Package Name');
	   $filters['b:name'] = array('label' => 'Package Group', 'type'=>'select','options'=>$this->gradstate_packages_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['validity'] = array('label'=>'Validity');
	   $filters['price'] = array('label'=>'Price', 'currency'=>'kes.');
	  return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'desc', $just_count = FALSE)
	{
		//$this->db->select('id,name,package_group,validity,price',FALSE); 
		//$this->db->join('')

	$this->filter_join= 'and'; 

		$b=$this->_tables['gradstate_packages'];
		$a=$this->_tables['gradstate_package_pricing'];

		$this->db->select("$a.id,$a.name,b.name as package_group,validity as validity_in_months,price",FALSE); 

		$this->db->join($b.' as b', "b.id = $a.package_group", 'left');



		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}

	public function form_fields($values = array(), $related = array())
	{
		$fields = parent::form_fields($values, $related);
		

		$fields['package_group']['type']='select';
		$fields['package_group']['options']=$this->gradstate_packages_model->options_list('id','name');
		$fields['package_group']['first_option']='Select one...';


		$fields['validity']['type']='select';
		$fields['validity']['options']=create_validity();
		$fields['validity']['first_option']='Select one...';		
		$fields['name']['style'] = 'width: 350px;';	

		$fields['slug']['readonly']=TRUE;
		$fields['slug']['default']='n/a';
		$fields['price']['currency']=$this->currency;
		return $fields;	
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$b=$this->_tables['gradstate_packages'];
		$a=$this->_tables['gradstate_package_pricing'];
		$this->db->select("$a.*,b.name as package_name,b.description, b.courses",FALSE); 
		$this->db->join($b.' as b', "b.id = $a.package_group", 'left');

	}
	function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name')
	{
		$order = $val;
		$return = parent::options_list($key, $val, $where, $order);
		return $return;
	}
	function on_before_clean($values)
	{
		$where=array('id'=>$values['package_group']);
		$res=$this->gradstate_packages_model->find_one_array($where);
		$package=isset($res['name'])?$res['name']:"";
		$values['name'] = $package." ".pluralize_time($values['validity'],'month');
		$values['slug'] = strtolower(url_title($values['name'], 'dash', TRUE));
		return $values;
	}
}