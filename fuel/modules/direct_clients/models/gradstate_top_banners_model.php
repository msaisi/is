<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_top_banners_model extends Base_module_model {
	
	public $required = array('title', 'link'); // ,'website','facebook','twitter'
	public $filters = array('title', 'link', 'banner'); // Additional fields that will be searched
	public $unique_fields = array('slug','title'); // User name is a unique field
	public $hidden_fields = array('slug'); // User name is a unique field
	
	public $image_path = null;
	public $CI=null;
	public $gradstate_config=array();

	public function __construct()
	{
		parent::__construct('gradstate_top_banners', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->image_path=$this->gradstate_config['asset_upload_path_top_banners'];
	}

	function filters()
	{
	   $filters['title'] = array('label'=>'Title');
	   $filters['link'] = array('label'=>'Link','style'=>'max-width: 173px;');	  
	   $filters['active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   return $filters;
	}

	public function list_items($limit = NULL, $offset = NULL, $col = 'title', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$this->db->select("id,title,link,active",FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}
		
	public function options_list($key = 'id', $val = 'title', $where = array(), $order = 'title')
	{
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
	
	public function on_before_clean($values)
	{
		$values['slug'] = strtolower(url_title($values['title'], 'dash', TRUE));
		$_POST['pic']=$values['pic'];
		return $values;		
	}
	
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);

		$fields['banner']['type']='file';
		$fields['banner']['folder'] = $this->image_path;
		$fields['banner']['upload_path'] = $this->image_path;
		$fields['banner']['img_styles'] = 'float: left; width: 70%;height:100px';		
				
		if (!empty($values['id']))
		{
		    $pic=$values['banner'];
		}
		else
		{
			$pic="";
		}

		$fields['pic'] = array('type' => 'hidden', 'value' =>$pic);

		$fields['banner']['style'] = 'width: 350px;';
		$fields['title']['style'] = 'width: 300px;';
		$fields['link']['style'] = 'width: 300px;';

		$fields['banner']['order']=1;	
		$fields['title']['order'] = 2;
		$fields['link']['order'] = 3;
		return $fields;
	
	}
	public function on_before_save($values)
	{
		$path= assets_server_path($this->image_path);		
	 	$the_fld='banner';
		$rename=$values['slug'];
		$ret=trim(upload_files($the_fld,$path,$rename));		
	    if($ret!=="")	
	    {
			$pic=$ret;
		}
		else
		{
			$pic=$_POST['pic'];
		}
		$values['banner']=$pic;
	    return $values;
	}
	public function on_after_save($values)
	{
	    return $values;
	}	
}