<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_quick_downloads_log_model extends Base_module_model 
{	
	public $auto_date_add = array('download_date');
	
	public $filters = array('file_name','institution_name','first_name','last_name','age','gender','nationality','location','country','email','contacts','download_date');
	
	
	public function __construct()
	{
		parent::__construct('gradstate_quick_downloads_log', GRADSTATE_FOLDER);
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	function filters()
	{
	   $filters['file_name'] = array('label'=>'File Name');
	   $filters['institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['first_name'] = array('label'=>'First Name');
	   $filters['last_name'] = array('label'=>'Last Name');
	   $filters['age'] = array('label'=>'Age');
	   $filters['nationality'] = array('label' => 'Nationality', 'type'=>'select','options'=>$this->gradstate_countries_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	    $filters['location'] = array('label' => 'Location', 'type'=>'select','options'=>$this->gradstate_counties_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');

	   $filters['gender'] = array('label' => 'Gender', 'type'=>'select','options'=>array('male'=>'male','female'=>'felame'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	    $filters['country'] = array('label' => 'Country', 'type'=>'select','options'=>$this->gradstate_countries_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	    $filters['email'] = array('label'=>'Email');
	    $filters['contacts'] = array('label'=>'Contacts');

	   
	   $filters['download_date_fromequal'] = array('type' => 'date','label'=>'From date');
	   $filters['download_date_toequal'] = array('type' => 'date','label'=>'To date');
	   //$filters['end_date_toequal'] = array('type' => 'date');
	   return $filters;
	}
	function on_before_clean($values)
	{
		$values['download_id'] = empty($values['download_id'])? strtoupper(gen_unique_id(10)): $values['download_id'];	
		$values['slug'] = strtolower(url_title($values['file_name'], 'dash', TRUE));
		return $values;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'file_name', $order = 'asc', $just_count = FALSE)
	{
		//$filters = array('file_name','institution_name','first_name','last_name','age','gender','nationality','location','country','email','contacts','download_date');

  		$this->filter_join= 'and'; 

	    $a=$this->_tables['gradstate_quick_downloads_log'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select("$a.id,file_name,institution_name,first_name,last_name,age,gender,nationality,location,$a.country,$a.email,$a.contacts,download_date",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}
}