<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_course_alerts_model extends Base_module_model 
{	
		
	public function __construct()
	{
		parent::__construct('gradstate_course_alerts', GRADSTATE_FOLDER);		
	}	
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}

	function migrate_alerts()
	{
		$res=$this->gradstate_course_alerts_model->find_all_array();
		
		foreach ($res as $row) 
		{
			$filter=array('name'=>$row['sector']);			
			$row['sector']=$this->find_item_id($filter,'gradstate_sectors_model');

			$filter=array('name'=>$row['class_hours']);			
			$row['class_hours']=$this->find_item_id($filter,'gradstate_class_types_model');

			$filter=array('name'=>$row['qualification_type']);			
			$row['qualification_type']=$this->find_item_id($filter,'gradstate_qualifications_model');

			$filter=array('name'=>$row['course_type']);			
			$row['course_type']=$this->find_item_id($filter,'gradstate_course_types_model');

			$filter=array('name'=>$row['course_level']);			
			$row['course_level']=$this->find_item_id($filter,'gradstate_course_levels_model');

			$filter=array('name'=>$row['country']);			
			$row['country']=$this->find_item_id($filter,'gradstate_countries_model');

			$filter=array('name'=>$row['location']);			
			$row['location']=$this->find_item_id($filter,'gradstate_counties_model');

			$filter=array('name'=>$row['faculty']);			
			$row['faculty']=$this->find_item_id($filter,'gradstate_faculties_model');


			$where=array('id'=>$row['id']);

			$this->update($row,$where);
		}
	}

	function find_item_id($filter,$model)
	{
		$q=$this->$model->find_one_array($filter);
		if(!empty($q))
		{
			return $q['id']; 
		}
		return 0;
	}
}