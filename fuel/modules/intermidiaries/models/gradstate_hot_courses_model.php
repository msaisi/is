<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_hot_courses_model extends Base_module_model {
	
	public $required = array('institution_id');
	public $CI=null;
	public $gradstate_config=array();
	public $max_hot=0;

	public function __construct()
	{
		parent::__construct('gradstate_hot_courses', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();

		$this->max_hot=$this->gradstate_config['institution_hot_courses_slots'];
	}

	public function list_items($limit = NULL, $offset = NULL, $col = 'institution_name', $order = 'asc', $just_count = FALSE)
	{
	    $a=$this->_tables['gradstate_hot_courses'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select("$a.id,institution_name",FALSE); 
		$this->db->join($b, "$b.institution_id = $a.institution_id", 'left');
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
			$this->db->join('tbl_institutions','tbl_institutions.institution_id=tbl_hot_courses.institution_id','left');
		}	
		$order=$val;
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
		
	public function _common_query($params = NULL)
	{
		parent::_common_query();
	   	$a=$this->_tables['gradstate_hot_courses'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select("$a.*,institution_name",FALSE); 
		$this->db->join($b, "$b.institution_id = $a.institution_id", 'left');
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);
		$fields['institution_id']['style'] = 'width: 300px;';	
		$courses=array();
		$opts=$this->gradstate_institutions_model->options_list('institution_id','institution_name',array('is_active'=>'yes'));

		if(!empty($values['id']))
		{
			$filter=array('institution_id'=>$values['institution_id']);
			$courses=create_array($this->gradstate_hot_courses_bindings_model->options_list('course_id','course_id',$filter));
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
		}
		else
		{
			$ex_opts=$this->options_list('institution_id','institution_id');
			foreach ($ex_opts as $key => $value) 
			{
				unset($opts[$key]);
			}
			$fields['institution_id']['order'] = 1;
			$fields['institution_id']['label'] = 'Institution Name';
			$fields['institution_id']['type']='select';
			$fields['institution_id']['options']=$opts;
			$fields['institution_id']['first_option']='Select one...';
		}


		$fields['inst_courses'] = array('type' => 'dependent', 'depends_on' => 'institution_id', 'url' => base_url().'ajax_load/inst_courses', 'multiple' => TRUE ,'value'=>$courses);

		$fields['inst_courses']['style'] = 'width: 300px;';
		
		$fields['inst_courses']['label'] = 'Courses';
		$fields['inst_courses']['order'] = 2;
		return $fields;	
	}
	public function on_before_validate($values)
	{
		$count=isset($this->normalized_save_data['inst_courses'])?count($this->normalized_save_data['inst_courses']):0;

		if($count>$this->max_hot)
		{
			$this->add_error('Sorry, you can allocate a maximum of '.$this->max_hot." courses"); 
		}	
		return $values;
	}
	public  function on_after_save($values)
	{
		return $this->save_rels($values);		 		
	}
	
	public function save_rels($values)
	{
		
		$this->gradstate_hot_courses_bindings_model->delete(array('institution_id' => $values['institution_id']));

		$courses = isset($_POST['inst_courses'])?$_POST['inst_courses']:array();

		if (!empty($courses))
		{
			foreach($courses as $key=>$val)
			{
				$data=array('institution_id' => $values['institution_id'],'course_id'=>$val);
				$this->gradstate_hot_courses_bindings_model->save($data);
			}
		}
		return $values;
	}

    function on_after_delete($where)
    {	
		$this->gradstate_hot_courses_bindings_model->delete($where);
		
		return;
    }
}