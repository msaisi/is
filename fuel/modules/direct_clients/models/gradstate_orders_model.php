<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_orders_model extends Base_module_model 
{	
	public $required = array('institution_id','order_id','order_date','description'); 
	
	public function __construct()
	{
		parent::__construct('gradstate_orders', GRADSTATE_FOLDER);	
	}	
	/*public function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'desc', $just_count = FALSE)
	{
		$this->db->select('id,order_id,institution,order_date',FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}*/

	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$a=$this->_tables['gradstate_orders'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select("$a.*,institution_name",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
	}
}