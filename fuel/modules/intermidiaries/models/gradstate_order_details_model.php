<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_order_details_model extends Base_module_model 
{	
	public $required = array('order_id','item_id','slug','name','type','item_tot_price','description','order_date','duration','expiry_date'); 
	
	public function __construct()
	{
		parent::__construct('gradstate_order_details', GRADSTATE_FOLDER);	
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
		$this->db->select("*",FALSE); 
	}
}