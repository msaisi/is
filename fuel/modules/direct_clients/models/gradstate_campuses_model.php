<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_campuses_model extends Base_module_model {
	
	public $required = array('campus_name', 'institution_id','location'); // ,'website','facebook','twitter'
	public $filters = array('campus_email','institution_name', 'campus_name','postal_address','contacts','location','postal_address'); // Additional fields that will be searched
	public $unique_fields = array('campus_id','slug'); // User name is a unique field
	public $hidden_fields = array('campus_id','slug'); // User name is a unique field

	//    public $record_class = 'gradstate_campus_model';
	

	public $image_path = null;
	public $CI=null;
	public $gradstate_config=array();

	function filters()
	{
	   $filters['campus_name'] = array('label'=>'Campus Name');
	   $filters['b:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['campus_email'] = array('label'=>'Campus Email');
	   $filters['contacts'] = array('label'=>'Contacts');
	   $filters['postal_address'] = array('label' => 'Postal Address');
	   $filters['c:name'] = array('label' => 'Location', 'type'=>'select','options'=>$this->gradstate_counties_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	    $filters['is_active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   return $filters;
	}

	public function __construct()
	{
		parent::__construct('gradstate_campuses', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->image_path=$this->gradstate_config['asset_upload_path_institution_campus_profile_images'];
	}

	public function list_items($limit = NULL, $offset = NULL, $col = 'campus_name', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$b=$this->_tables['gradstate_institutions'];
		$a=$this->_tables['gradstate_campuses'];
		$c=$this->_tables['gradstate_counties'];
		$this->db->select("$a.id,campus_name,b.institution_name,$a.campus_email,$a.contacts,$a.postal_address,c.name as location,$a.is_active",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$this->db->join($c.' as c', "c.id = $a.location", 'left');
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}	
	
	public function options_list($key = 'id', $val = 'campus_id', $where = array(), $order = 'campus_id')
	{		
		if ($key === 'id')
		{
			$key = $this->table_name.'.id';
		}	
		if($val==="campus_location")	
		{
			$a=$this->_tables['gradstate_campuses'];
			$c=$this->_tables['gradstate_counties'];
			$key = "c.name";
			$val="c.name";
			$this->db->join($c.' as c', "c.id = $a.location", 'left');
		}
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}

	function campuses_by_institution($where)
	{
		$options = $this->options_list('campus_id','campus_name',$where);
		$str = '';
		//$i=0;
		foreach($options as $key => $val)
		{
			$str .= "<option value=\"".$key."\" label=\"".$val."\">".$val."</option>\n";
			//$str .="<li id=\"campuses_$i\" data-label=\"$val\">$val</li>\n";
			//$i++;
		}
		return $str;
	}
	
	
	public function on_before_clean($values)
	{
		$values['campus_id'] = empty($values['campus_id'])? gen_unique_id(20) : $values['campus_id'];
		$slug=$values['campus_name'].'-'.$values['campus_id'];
		$values['slug'] = strtolower(url_title($slug, 'dash', TRUE));
		$values['campus_email'] = empty($values['campus_email'])? "n/a": $values['campus_email'];
		$values['postal_address'] = empty($values['postal_address'])? "n/a": $values['postal_address'];
		$_POST['pic']=$values['pic'];
		return $values;		
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$b=$this->_tables['gradstate_institutions'];
		$a=$this->_tables['gradstate_campuses'];
		$c=$this->_tables['gradstate_counties'];
		$this->db->select("$a.*,institution_name,c.name as campus_location",FALSE); 
		$this->db->join($b.' as b', "b.institution_id = $a.institution_id", 'left');
		$this->db->join($c.' as c', "c.id = $a.location", 'left');
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);

		if (!empty($values['id']))
		{
			$pic=$values['profile_picture'];		   
		}
		else
		{
			$pic="";
		}

		$fields['pic'] = array('type' => 'hidden', 'value' =>$pic);

		$fields['profile_picture']['type']='file';
		$fields['profile_picture']['folder'] = $this->image_path;
		$fields['profile_picture']['upload_path'] = $this->image_path;
		$fields['profile_picture']['img_styles'] = 'float: left; width: 150px;height:150px';
		$fields['profile_picture']['label'] = 'Campus Photo';

		$fields['profile_picture']['style'] = 'width: 350px;';
		$fields['campus_email']['style'] = 'width: 300px;';
		$fields['campus_name']['style'] = 'width: 300px;';
		$fields['postal_address']['style'] = 'width: 300px;';
		$fields['contacts']['style'] = 'width: 300px;';

		$fields['institution_id']['order'] = 1;	
		$fields['campus_name']['order'] = 2;
		$fields['location']['order'] = 3;
		$fields['campus_email']['order'] = 4;
		$fields['contacts']['order'] = 5;



		$fields['campus_email']['type'] = 'string';
		$fields['profile_picture']['order']=6;
		$fields['postal_address']['order']=7;

		$fields['institution_id']['type']='select';
		$fields['institution_id']['options']=$this->gradstate_institutions_model->options_list('institution_id','institution_name');
		$fields['institution_id']['first_option']='Select one...';
		$fields['institution_id']['label']='Institution Name';

		$fields['location']['type']='select';
		$fields['location']['options']=$this->gradstate_counties_model->options_list('id','name');
		$fields['location']['first_option']='Select one...';

		return $fields;	
	}
	public function on_before_save($values)
	{
		$path= assets_server_path($this->image_path);		
	 	$the_fld='profile_picture';
		$rename=$values['campus_id'];
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
}