<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_international_universities_model extends Base_module_model {
	
	public $required = array('institution_name','official_address','account_type','country'); // ,'website','facebook','twitter'
	public $filters = array('institution_name','official_address','account_type','website','facebook','twitter'); // Additional fields that will be searched
	public $unique_fields = array('institution_id'); // User name is a unique field
	public $hidden_fields = array('institution_id','slug'); // User name is a unique field
	

	public $image_path = null;
	public $logo_image_path = null;	
	public $CI=null;
	public $gradstate_config=array();

	public function __construct()
	{
		parent::__construct('gradstate_international_universities', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->image_path=$this->gradstate_config['asset_upload_path_institution_profile_images'];
		$this->logo_image_path=$this->gradstate_config['asset_upload_path_institution_logo_images'];		
	}
	function filters()
	{
	   $filters['institution_name'] = array('label'=>'Institution Name');
	   $filters['b:name'] = array('label' => 'Institution Type', 'type'=>'select','options'=>$this->gradstate_institution_types_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['official_address'] = array('label'=>'Official Address');
	   $filters['website'] = array('label'=>'Website');
	   $filters['is_active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 
	  return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'institution_name', $order = 'asc', $just_count = FALSE)
	{
		$b=$this->_tables['gradstate_institution_types'];
		$a=$this->_tables['gradstate_international_universities'];

		$this->db->select("$a.id,institution_name,official_address, website, b.name as institution_type,is_active",FALSE); 

		$this->db->join($b.' as b', "b.id = $a.account_type", 'left');

		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}
	
	
	public function options_list($key = 'id', $val = 'institution_id', $where = array(), $order = 'institution_id')
	{
		if ($key === 'id')
		{
			$key = $this->table_name.'.id';
		}	
		
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
	public function on_before_clean($values)
	{
		$values['institution_id'] = empty($values['institution_id'])? gen_unique_id(20) : $values['institution_id'];
		if(isset($values['institution_name']))
		{
		   $values['slug'] = strtolower(url_title($values['institution_name'], 'dash', TRUE));
		}
		if(isset($values['pic']))
		{
			$_POST['pic']=$values['pic'];
			$_POST['pic1']=$values['pic1'];
		}
		return $values;		
	}
	
	
	public function _common_query($params = NULL)
	{
		parent::_common_query();

		$b=$this->_tables['gradstate_countries'];
		$a=$this->_tables['gradstate_international_universities'];
		$this->db->select("$a.*, b.name as country_name",FALSE); 
		$this->db->join($b.' as b', "b.id = $a.country", 'left');

	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);


		$faculties=array();
		$qualifications=array();

		$fields['profile_picture']['type']='file';
		$fields['profile_picture']['folder'] = $this->image_path;
		$fields['profile_picture']['upload_path'] = $this->image_path;
		$fields['profile_picture']['img_styles'] = 'float: left; width: 150px;height:150px';

		$fields['logo_picture']['type']='file';
		$fields['logo_picture']['folder'] = $this->logo_image_path;
		$fields['logo_picture']['upload_path'] = $this->logo_image_path;
		$fields['logo_picture']['img_styles'] = 'float: left; width: 100px;height:100px';

		
		if (!empty($values['id']))
		{
			$fields['is_active']['order'] = 20;
		    $pic=$values['profile_picture'];
		    $pic1=$values['logo_picture'];	
		    $filter=array('institution_id'=>$values['institution_id']);
			$faculties=create_array($this->gradstate_international_universities_to_faculty_model->options_list('faculty_id','faculty_id',$filter));	 
			$qualifications=create_array($this->gradstate_international_universities_to_qualifications_model->options_list('qualification_id','qualification_id',$filter));
		}
		else
		{
			$pic="";
			$pic1="";
		}

		$opts=$this->gradstate_faculties_model->options_list('id','name');
		$fields['faculties'] = array('type' => 'multi', 'value'=>$faculties,'options'=>$opts);

		$opts=$this->gradstate_qualifications_model->options_list('id','name');
		$fields['qualifications'] = array('type' => 'multi', 'value'=>$qualifications,'options'=>$opts);

		$fields['pic'] = array('type' => 'hidden', 'value' =>$pic);
		$fields['pic1'] = array('type' => 'hidden', 'value' =>$pic1);

		$fields['profile_picture']['style'] = 'width: 350px;';
		$fields['logo_picture']['style'] = 'width: 350px;';
		$fields['institution_name']['style'] = 'width: 300px;';
		$fields['official_address']['style'] = 'width: 300px;';
		$fields['youtube_video']['style'] = 'width: 500px;';
		
		$fields['website']['style'] = 'width: 300px;';
		$fields['twitter']['style'] = 'width: 300px;';
		$fields['facebook']['style'] = 'width: 300px;';



		$fields['profile_picture']['order']=2;	
		$fields['logo_picture']['order']=1;	
		$fields['institution_name']['order'] = 3;
		
		$fields['official_address']['order'] = 4;
		$fields['account_type']['order'] = 5;

		$fields['country']['order'] = 6;
		$fields['about']['order'] = 7;
		
		$fields['youtube_video']['order'] = 8;

		$fields['website']['order'] = 9;
		$fields['twitter']['order'] = 10;
		$fields['facebook']['order'] = 11;
		$fields['qualifications']['order'] = 13;
		$fields['faculties']['order'] = 12;
		
		$fields['account_type']['type']='select';
		$fields['account_type']['options']=$this->gradstate_institution_types_model->options_list('id','name');
		$fields['account_type']['first_option']='Select one...';

		$fields['country']['type']='select';
		$fields['country']['options']=$this->gradstate_countries_model->options_list('id','name');
		$fields['country']['first_option']='Select one...';

		unset($fields['registration_date']);

//		die;
		return $fields;
	
	}

	public function on_before_save($values)
	{
	    $path= assets_server_path($this->logo_image_path);	
	    $the_fld='logo_picture';
		$rename=$values['institution_id'];
		$ret=trim(upload_files($the_fld,$path,$rename));
	
	    if($ret!=="")	
	    {
			$pic=$ret;
		}
		else
		{
			$pic=$_POST['pic1'];
		}
		$values['logo_picture']=$pic;

		$path= assets_server_path($this->image_path);	

	 	$the_fld='profile_picture';
		$rename=$values['institution_id'];
		$ret=trim(upload_files($the_fld,$path,$rename));
	
	    if($ret!=="")	
	    {
			$pic=$ret;
		}
		else
		{
			$pic=$_POST['pic'];
		}
		$values['profile_picture']=$pic;

	    return $values;
	}

	public  function on_after_save($values)
	{
		return $this->save_rels($values);		 		
	}
	public  function on_after_insert($values)
	{
		return $this->save_rels($values);		 		
	}
	public  function on_after_update($values)
	{
		return $this->save_rels($values);		 		
	}
	public function save_rels($values)
	{

		$where=array('institution_id' => $values['institution_id']);
		$this->gradstate_international_universities_to_faculty_model->delete($where);
		$this->gradstate_international_universities_to_qualifications_model->delete($where);
	
		$faculties = $_POST['faculties'];
		$qualifications = $_POST['qualifications'];

		if (!empty($faculties))
		{
			foreach($faculties as $key=>$val)
			{
				$data=array('institution_id' => $values['institution_id'],'faculty_id'=>$val);

				$this->gradstate_international_universities_to_faculty_model->save($data);
			}
		}

		if (!empty($qualifications))
		{
			foreach($qualifications as $key=>$val)
			{
				$data=array('institution_id' => $values['institution_id'],'qualification_id'=>$val);

				$this->gradstate_international_universities_to_qualifications_model->save($data);
			}
		}
		return $values;
	}

    function on_after_delete($where)
    {	
		$this->gradstate_international_universities_to_faculty_model->delete($where);
		$this->gradstate_international_universities_to_qualifications_model->delete($where);
		return;
    }

	function get_search_data($term,$my_array,$order_by = 'institution_name asc',$limit = NULL, $offset = NULL)
	{
		$a=$this->_tables['gradstate_international_universities'];
		$b=$this->_tables['gradstate_countries'];
		$c=$this->_tables['gradstate_institution_types'];		
		$d=$this->_tables['gradstate_international_universities_to_faculty'];		
		$e=$this->_tables['gradstate_international_universities_to_qualifications'];		
		$this->db->from($a);
		$this->db->select("$a.*, $b. name as country_name", FALSE);
		$this->db->join($b,"$a.country=$b.id", 'left');
		$this->db->join($c,"$c.id=$a.account_type", 'left');	

		$this->db->join($d, "$d.institution_id=$a.institution_id", 'left');	
		$this->db->join($e, "$e.institution_id=$a.institution_id", 'left');	

		$this->db->group_by($a.'.id');


		$this->db->where($my_array);
		if($term!=="")
		{
			$this->db->where("MATCH (institution_name) AGAINST ('*$term*' IN BOOLEAN MODE)", NULL, FALSE);
		}
		$this->db->order_by($order_by); 
		if($limit)
		{
		$this->db->limit($limit, $offset);
		}
		//,$c.name,$d.name,campus_name
		$data=$this->db->get()->result_array();
		return $data;
	}
	
}