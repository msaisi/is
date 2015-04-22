<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_features_subscriptions_model extends Base_module_model 
{	
	public $required = array('institution_id','feature_id'); 
	public $filters = array('institution_id','institution_name','start_date','expiry_date');
	public $unique_fields = array('subscription_id','slug'); 
	public $hidden_fields= array('expiry_date','subscription_id'); 
	public $gradstate_config=array();
	public $currency;
	
	public $CI=null;
	
	public function __construct()
	{
		parent::__construct('gradstate_features_subscriptions', GRADSTATE_FOLDER);
		$this->CI =& get_instance();							
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->pack_dur=$this->gradstate_config['package_validity'];
		$this->currency=$this->gradstate_config['currency'];
		//$this->fill_start_date();
		//die;
	}	

	/*public function fill_start_date()
	{
		$res=$this->find_all_array();
		foreach($res as $row):
			$end_date=$row['expiry_date'];
			$expdate = date('Y-m-d H:i:s', strtotime("-1 months", strtotime($end_date)));
			$values['start_date'] = $expdate;
			$where=array('id'=>$row['id']);

			$this->update($values,$where);
		endforeach;
	}*/

	function filters()
	{
	    $filters['c:name'] = array('label' => 'Feature', 'type'=>'select','options'=>$this->gradstate_features_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');

	   $filters['b:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['start_date_equal'] = array('type' => 'date','label'=>'Start date');
	   $filters['expiry_date_equal'] = array('type' => 'date','label'=>'Expiry date');
	  return $filters;
	}


	public function list_items($limit = NULL, $offset = NULL, $col = 'institution_name', $order = 'desc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$a=$this->_tables['gradstate_features_subscriptions'];
		$b=$this->_tables['gradstate_institutions'];
		$c=$this->_tables['gradstate_features'];
		$this->db->select("$a.id,c.name as feature,b.institution_name as institution,start_date,expiry_date",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$this->db->join($c.' as c', "c.id = $a.feature_id", 'left');

		/*$this->db->from($a);
		$q=$this->db->get()->result_array();

		print($q);
		die;*/
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

		$fields['feature_id']['type']='select';
		$fields['feature_id']['options']=$this->gradstate_features_model->options_list('id','name');
		$fields['feature_id']['first_option']='Select one...';
		$fields['feature_id']['label']='Feature';

		$fields['feature_id']['class']='sub_feat';

		$fields['slug']['readonly']=TRUE;
		$fields['slug']['default']='n/a';
		$fields['slug']['style']='width: 400px;';
		$fields['slug']['order']=1;

		if(!empty($values['id']))
		{
			$fields['institution_id']['type']='hidden';
			$fields['institution_name']['value']=$values['institution_name'];
			$fields['institution_name']['order']=1;
			$fields['institution_name']['readonly']=TRUE;

			$fields['feature_id']['type']='hidden';
			$fields['feature']['value']=$values['name'];
			$fields['feature']['order']=1;
			$fields['feature']['readonly']=TRUE;	

			$fields['slug']['type']='hidden';		

		$fields['feature']['style']='width: 400px;';
		$fields['institution_name']['style']='width: 400px;';

		}

		$fields['institution_id']['class']='sub_inst';

		

		return $fields;	
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$a=$this->_tables['gradstate_features_subscriptions'];
		$b=$this->_tables['gradstate_institutions'];
		$c=$this->_tables['gradstate_features'];
		$this->db->select("$a.*,b.institution_name ,c.name",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$this->db->join($c.' as c', "c.id = $a.feature_id", 'left');
	}
	function options_list($key = 'id', $val = 'institution_name', $where = array(), $order = 'institution_name')
	{
		if($val=='institution_name')
		{
			$a=$this->_tables['gradstate_features_subscriptions'];
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
		/*$where=array('id'=>$values['package_group']);
		$res=$this->gradstate_packages_model->find_one_array($where);
		$package=isset($res['name'])?$res['name']:"";
		$values['name'] = $package." ".pluralize_time($values['validity'],'month');
		$values['slug'] = strtolower(url_title($values['name'], 'dash', TRUE));
*/

		$year="".format_disp_date(null,"Y-M");

		$values['subscription_id'] = empty($values['subscription_id'])? gen_unique_id(20,'',$year."-") : $values['subscription_id'];
		$now=datetime_now();

		$values['start_date'] = empty($values['start_date'])? $now: $values['start_date'];

		$where=array('id'=>$values['feature_id']);

		$res=$this->gradstate_features_model->find_one_array($where);

		//print_r($res);
		//die;

		$dur=1;
		$expdate = date('Y-m-d H:i:s', strtotime("+$dur months", strtotime($values['start_date'])));

		$values['expiry_date'] = $expdate;
		return $values;
	}
	public function on_before_save($values)
	{
		return $values;
	}
}