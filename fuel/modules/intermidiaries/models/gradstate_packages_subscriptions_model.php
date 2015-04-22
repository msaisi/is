<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_packages_subscriptions_model extends Base_module_model 
{	
	public $required = array('institution_id','package_id'); 
	public $filters = array('institution_id','institution_name','start_date','expiry_date');
	public $unique_fields = array('subscription_id','institution_id'); 
	public $hidden_fields= array('expiry_date','subscription_id'); 
	public $gradstate_config=array();
	
	public function __construct()
	{
		parent::__construct('gradstate_packages_subscriptions', GRADSTATE_FOLDER);
		//$this->fill_start_date();
		//die;
	}	

	/*public function fill_start_date()
	{
		$res=$this->find_all_array();
		foreach($res as $row):
			$end_date=$row['expiry_date'];
			$dur=6;
			$expdate = date('Y-m-d H:i:s', strtotime("-6 months", strtotime($end_date)));
			$values['start_date'] = $expdate;
			$where=array('id'=>$row['id']);

			$this->update($values,$where);
		endforeach;
	}*/


	function filters()
	{
	    $filters['c:name'] = array('label' => 'Package', 'type'=>'select','options'=>$this->gradstate_package_pricing_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');

	   $filters['b:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['start_date_equal'] = array('type' => 'date','label'=>'Start date');
	   $filters['expiry_date_equal'] = array('type' => 'date','label'=>'Expiry date');
	  return $filters;
	}

	public function list_items($limit = NULL, $offset = NULL, $col = 'institution_name', $order = 'desc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$a=$this->_tables['gradstate_packages_subscriptions'];
		$b=$this->_tables['gradstate_institutions'];
		$c=$this->_tables['gradstate_package_pricing'];
		$this->db->select("$a.id,b.institution_name,c.name,start_date,expiry_date",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$this->db->join($c.' as c', "c.id = $a.package_id", 'left');

		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}

	public function form_fields($values = array(), $related = array())
	{
		$fields = parent::form_fields($values, $related);

		$fields['institution_id']['type']='select';
		$fields['institution_id']['options']=$this->gradstate_institutions_model->options_list('institution_id','institution_name');
		$fields['institution_id']['first_option']='Select one...';
		$fields['institution_id']['label']='Institution Name';
		if(!empty($values['id']))
		{
			$fields['institution_id']['type']='hidden';
			$fields['institution_name']['value']=$values['institution_name'];
			$fields['institution_name']['order']=1;
			$fields['institution_name']['readonly']=TRUE;


		}
		$fields['package_id']['type']='select';
		$fields['package_id']['options']=$this->gradstate_package_pricing_model->options_list('id','name');
		$fields['package_id']['first_option']='Select one...';
		$fields['package_id']['label']='Package';

		return $fields;	
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$a=$this->_tables['gradstate_packages_subscriptions'];
		$b=$this->_tables['gradstate_institutions'];
		$c=$this->_tables['gradstate_package_pricing'];
		$this->db->select("$a.*,b.institution_name ,c.name,c.package_group",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$this->db->join($c.' as c', "c.id = $a.package_id", 'left');
	}
	function options_list($key = 'id', $val = 'institution_name', $where = array(), $order = 'institution_name')
	{
		if($val=='institution_name')
		{
			$a=$this->_tables['gradstate_packages_subscriptions'];
			$b=$this->_tables['gradstate_institutions'];
			$key = "$a.id";
			$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		}

		$order = $val;
		$return = parent::options_list($key, $val, $where, $order);
		return $return;
	}
	function on_before_clean($values)
	{
		$year="".format_disp_date(null,"Y-M");
		$values['subscription_id'] = empty($values['subscription_id'])? gen_unique_id(20,'',$year."-") : $values['subscription_id'];

		$now=datetime_now();

		$values['start_date'] = empty($values['start_date'])? $now: $values['start_date'];

		$where=array('id'=>$values['package_id']);

		$res=$this->gradstate_package_pricing_model->find_one_array($where);
		$dur=$res['validity'];
		$expdate = date('Y-m-d H:i:s', strtotime("+$dur months", strtotime($values['start_date'])));

		$values['expiry_date'] = $expdate;
		return $values;
	}
	public function on_before_save($values)
	{
		return $values;
	}
}