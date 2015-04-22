<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_clicks_model extends Base_module_model 
{	
	public $required = array('log_id','type','institution'); 
	public $auto_date_add = array('log_time');
	
	public function __construct()
	{
		parent::__construct('gradstate_clicks', GRADSTATE_FOLDER);	
	}	
	
	public function on_before_clean($values)
	{
		$values['log_id'] = empty($values['log_id'])? gen_unique_id(20) : $values['log_id'];
		return $values;		
	}
	function filters()
	{
	   $filters['item'] = array('label'=>'Item');
	   $filters['type'] = array('label' => 'Type', 'type'=>'select','options'=>$this->gradstate_clicks_model->options_list('type','type'),'first_option'=>'select one', 'style'=>'max-width: 217px;');	
	   $filters['b:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['log_time_fromequal'] = array('type' => 'date','label'=>'From date');
	   $filters['log_time_toequal'] = array('type' => 'date','label'=>'To date');
	  return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'item', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$b=$this->_tables['gradstate_institutions'];
		$a=$this->_tables['gradstate_clicks'];
		$this->db->select("$a.id,item,type, institution_name,log_time",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution", 'left');
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}	
}