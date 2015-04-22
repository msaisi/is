<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_quick_downloads_model extends Base_module_model {
	
	public $required = array('file_name','institution_id');
	public $hidden_fields = array('item_id','slug'); // User name is a unique field
	public $auto_date_add = array('date_added');
	public $CI=null;
	public $gradstate_config=array();
	public $max_slots=0;
	public $file_path=null;

	public function __construct()
	{
		parent::__construct('gradstate_quick_downloads', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();

		$this->max_slots=$this->gradstate_config['institution_quick_downloads_slots'];
		$this->file_path=$this->gradstate_config['quick_downloads_path'];
	}
	function filters()
	{
	   $filters['file_name'] = array('label'=>'File Name');
	  // $filters['file_name'] = array('label' => 'File Name', 'type'=>'select','options'=>$this->gradstate_clicks_model->options_list('file_name','file_name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');	
	   $filters['b:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	  return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'file_name', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
	    $a=$this->_tables['gradstate_quick_downloads'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select("$a.id,file_name,institution_name",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}
	
	public function options_list($key = 'id', $val = 'institution_name', $where = array(), $order = 'institution_name')
	{
		if ($key === 'id')
		{
			$key = $this->table_name.'.id';
		}	
		if ($val === 'institution_name')
		{
			$key = $this->table_name.'.id';
			$val = 'tbl_institutions.institution_name';
			$this->db->join('tbl_institutions','tbl_institutions.institution_id=gradstate_quick_downloads.institution_id','left');
		}	
		$order=$val;
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
		
	public function _common_query($params = NULL)
	{
		parent::_common_query();
	   	$a=$this->_tables['gradstate_quick_downloads'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select("$a.*,institution_name",FALSE); 
		$this->db->join($b, "$b.institution_id = $a.institution_id", 'left');
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);
		$fields['institution_id']['style'] = 'width: 300px;';	
		//$courses=array();
		$opts=$this->gradstate_institutions_model->options_list('institution_id','institution_name',array('is_active'=>'yes'));
		$path=$this->file_path;
		if(!empty($values['id']))
		{
			$filter=array('institution_id'=>$values['institution_id']);
			//$courses=create_array($this->gradstate_hot_courses_bindings_model->options_list('item_id','course_id',$filter));
			$inst=$this->gradstate_institutions_model->find_one_array($filter);

			$fields['inst_name']['order'] = 1;
			$fields['inst_name']['displayonly'] = true;
			$fields['inst_name']['value']=$inst['institution_name'];			
			$fields['inst_name']['label'] = 'Institution Name';
			//$fields['institution_id']['type']='hidden';

			$fields['institution_id']['label'] = ' ';
			$fields['institution_id']['type']='select';
			$fields['institution_id']['options']=$opts;
			$fields['institution_id']['required']=false;
			$fields['institution_id']['style']='display:none';
			$fields['institution_id']['first_option']='Select one...';
			$path=$path.$values['institution_id']."/";
		}
		else
		{
			/*$ex_opts=$this->options_list('institution_id','institution_id');
			foreach ($ex_opts as $key => $value) 
			{
				unset($opts[$key]);
			}*/
			$fields['institution_id']['order'] = 1;
			$fields['institution_id']['label'] = 'Institution Name';
			$fields['institution_id']['type']='select';
			$fields['institution_id']['options']=$opts;
			$fields['institution_id']['first_option']='Select one...';
		}

		$fields['file']['type']='file';
		$fields['file']['folder'] = $path;
		$fields['file']['upload_path'] = $path;
		return $fields;	
	}
	public function on_before_validate($values)
	{
		$a=$this->_tables['gradstate_quick_downloads'];
		
		$count=count($this->gradstate_quick_downloads_model->find_all_array(array("$a.institution_id"=>$values['institution_id'])));

		if($count>$this->max_slots)
		{
			$this->add_error('Sorry, you can upload a maximum of '.$this->max_slots." files per institution. No free slots available!"); 
		}	
		return $values;
	}

	public function on_before_clean($values)
	{
		$values['item_id'] = empty($values['item_id'])? strtoupper(gen_unique_id(10,"","")): $values['item_id'];		
		$values['slug'] = strtolower(url_title($values['file_name'], 'dash', TRUE));
		return $values;
	}

    public function on_before_save($values)
	{
		$path= assets_server_path($this->file_path.$values['institution_id']."/");		
	  	$the_fld='file';
		$rename=$values['slug'];
		$values['file']=trim(upload_files($the_fld,$path,$rename,'form'));	
		
	    return $values;
	}
}