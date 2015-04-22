<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_counties_model extends Base_module_model 
{	
	public $required = array('name'); 
	public $filters = array('name');
	public $unique_fields = array('slug'); 
	//public $linked_fields = array('slug' => array('name' => 'url_title'));	
	public $hidden_fields= array('slug'); 
	public $gradstate_config=array();
	
	public function __construct()
	{
		parent::__construct('gradstate_counties', GRADSTATE_FOLDER);
	}
	/*function create_slug()
	{
		$res=$this->find_all_array();
		foreach ($res as $row) 
		{
			$name=$row['name'];
			$slug=url_title($name, 'dash', TRUE) ;

			$save_data=array('slug'=>$slug);
			$where=array('id'=>$row['id']);
			$this->update($save_data,$where);
		}
	}*/
	
	function counties_ajax($where=array())
	{
		$options = $this->options_list('id','name',$where);
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
	
	public function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'desc', $just_count = FALSE)
	{
		$this->db->select('id,name',FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}

	public function form_fields($values = array(), $related = array())
	{
		$fields = parent::form_fields($values, $related);
		
		$fields['name']['style'] = 'width: 350px;';

		return $fields;	
	}
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name')
	{
		$order = $val;
		$return = parent::options_list($key, $val, $where, $order);
		return $return;
	}
	function on_before_clean($values)
	{
		//$values['slug'] = strtolower($values['slug']);
		$values['slug'] = strtolower(url_title($values['name'], 'dash', TRUE));
		
		return $values;
	}
}