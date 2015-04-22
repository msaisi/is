<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_form_downloads_model extends Base_module_model 
{	
	public $auto_date_add = array('download_date');
	
	public function __construct()
	{
		parent::__construct('gradstate_form_downloads', GRADSTATE_FOLDER);
	}
	function on_before_clean($values)
	{
		$values['form_serial'] = empty($values['form_serial'])? strtoupper(gen_unique_id(10)): $values['form_serial'];	
		return $values;
	}
	function filters()
	{
	   $filters['form_serial'] = array('label'=>'Form Serial');
	   $filters['tbl_course:course_title'] = array('label'=>'Course Title');
	   $filters['tbl_institutions:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');

	   $filters['first_name'] = array('label'=>'First Name');	   
	   $filters['last_name'] = array('label'=>'Last Name');	   
	   $filters['tbl_form_downloads:email'] = array('label'=>'Email');
	   $filters['locations'] = array('label' => 'Location', 'type'=>'select','options'=>$this->gradstate_counties_model->options_list('id','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');

	   $filters['country'] = array('label' => 'Country', 'type'=>'select','options'=>$this->gradstate_countries_model->options_list('id','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['gender'] = array('label' => 'Gender', 'type'=>'select','options'=>array('male'=>'male','female'=>'female'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 
	  // $filters['active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 

	    $filters['download_date_fromequal'] = array('type' => 'date','label'=>'From date');
	   $filters['download_date_toequal'] = array('type' => 'date','label'=>'To date');
	  // $filters['b:name'] = array('label'=>'Contacts');
	  return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'download_date', $order = 'desc', $just_count = FALSE)
	{
		//$filters = array('institution_name','first_name', 'last_name');
	
		$this->filter_join= 'and'; 
	    $b=$this->_tables['gradstate_courses'];
		$c=$this->_tables['gradstate_counties'];
		$d=$this->_tables['gradstate_countries'];
		$e=$this->_tables['gradstate_institutions'];	
		$f=$this->_tables['gradstate_qualifications'];	
		$g=$this->_tables['gradstate_faculties'];		
		$h=$this->_tables['gradstate_sectors'];	

		//$this->db->select("$a.id,course_id as reference_no,course_title,institution_name,post_date as date_added,pending as pending_approval,active",FALSE); 
		$this->db->select('form_serial,course_title,institution_name,concat(first_name," ",last_name) as names,gender,tbl_form_downloads.email,tbl_form_downloads.contacts,c.name as location, d.name as country,f.name as highest_education_qualification,current_job_title,g.name as faculty_of_interest,h.name as job_sector_of_interest,experience,download_date',FALSE); 

		$this->db->join($b.' as b','b.course_id=tbl_form_downloads.course_id','left');
		$this->db->join($c.' as c','c.id=tbl_form_downloads.locations','left');
		$this->db->join($d.' as d','d.id=tbl_form_downloads.country','left');
		$this->db->join($e.' as e', 'e.institution_id = tbl_form_downloads.institution_id', 'left');
		$this->db->join($f.' as f','f.id=tbl_form_downloads.qualification','left');
		$this->db->join($g.' as g','g.id=tbl_form_downloads.faculty_of_interest','left');
		$this->db->join($h.' as h','h.id=tbl_form_downloads.job_sector_of_interest','left');
		//$this->CI->datatables->edit_column('course_title', '$1', 'course_title(course_title)');
		//$q=$this->db->get($a);

		
		

		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
        if (empty($just_count))
        {
          foreach($data as $key => $val)
          {
            $data[$key]['course_title'] = course_title($val['course_title']);
            $data[$key]['download_date'] = format_full_date($val['download_date']);
          }
        }
		return $data;
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
	    $a=$this->_tables['gradstate_form_downloads'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select($a.'.*, concat(first_name," ",last_name) as names,b.institution_name',FALSE); 
		$this->db->join($b.' as b ', 'b.institution_id = '.$a.'.institution_id', 'left');
	}
}