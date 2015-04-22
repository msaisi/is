<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_home_sliders_model extends Base_module_model 
{	
	public $required = array('header','text'); 
	public $filters = array('header','text', 'background_photo');
	public $unique_fields = array('header','slider_id'); 
	public $img_path = null;
	public $gradstate_config=array();
	public $hidden_fields = array('slider_id','slug'); // User name is a unique field
	
	public function __construct()
	{
		parent::__construct('gradstate_home_sliders', GRADSTATE_FOLDER);
		$this->gradstate_config = $this->fuel->gradstate->config();
		$this->img_path=$this->gradstate_config['home_slider_upload_path'];
	}
	
	function filters()
	{
	   $filters['header'] = array('label'=>'Header');
	  // $filters['text'] = array('label'=>'Text');	  
	   $filters['active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   return $filters;
	}
	public function list_items($limit = NULL, $offset = NULL, $col = 'header', $order = 'desc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$this->db->select('id,header, active',FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}
	public function on_before_clean($values)
	{
		$values['slider_id'] = empty($values['slider_id'])? gen_unique_id(20) : $values['slider_id'];		
		$values['slug'] = strtolower(url_title($values['header'], 'dash', TRUE));
		$_POST['pic']=$values['background_photo'];
		return $values;
	}

	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);
		$fields['background_photo']['type']='file';

		$fields['background_photo']['folder'] = $this->img_path;
		$fields['background_photo']['upload_path'] = $this->img_path;
		if (!empty($values['id']))
		{
			$pic=$values['background_photo'];
		}
		else
		{
			$pic="";
		}
		$fields['pic'] = array('type' => 'hidden', 'value' =>$pic);

		$fields['background_photo']['img_styles'] = 'float: left; width: 150px;height:150px';
		$fields['background_photo']['label']="Background Image";		
		$fields['background_photo']['style'] = 'width: 350px;';	

		$fields['header']['style'] = 'width: 500px;';	
		$fields['text']['style'] = 'width: 500px;';		

		
		return $fields;	
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	public function on_before_save($values)
	{		
	    $path= assets_server_path($this->img_path);		
	 	$the_fld='background_photo';
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
		$values['background_photo']=$pic;
	    return $values;
	}
}