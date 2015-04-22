<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_courses_model extends Base_module_model {
	
	public $required = array('course_title', 'institution_id','faculty','qualification_type','country','course_duration_fig','course_duration_per','intake_dates','fees_amount','currency','payment_period','description','eligibility','how_to_apply');
	public $filters = array('course_id','course_title', 'institution_id','faculty','qualification_type','country','course_duration_fig','course_duration_per','intake_dates','fees_amount','currency','payment_period','description','eligibility','how_to_apply');
	public $unique_fields = array('course_id');
	public $hidden_fields = array('course_id','slug','post_date','registration_deadline');	
	public $auto_date_add = array('post_date');
	public $file_path = null;
	public $CI=null;
	public $gradstate_config=array();
	public $duration_periods=array();
	public $currency_list=array();
	public $payment_period=array();


	public $ins_ids=array();


	public function __construct()
	{
		parent::__construct('gradstate_courses', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->file_path=$this->gradstate_config['asset_upload_path_application_forms'];
		$this->duration_periods=$this->gradstate_config['duration_periods'];
		$this->currency_list=$this->gradstate_config['currency_list'];
		$this->payment_period=$this->gradstate_config['payment_period'];



		$this->ins_ids=array('1'=>'3c3df04416c83a9d8d75','3'=>'79194b3b9ffb5da15ecb','4'=>'1b735e08b99a854ad605','5'=>'b0bc58a4ea746c78db64','6'=>'4bc0e9bb543b940f50e6','7'=>'24505bf7074b326eed24','8'=>'933e0c9027e8992bb91e','9'=>'f599fb0dbf6b369b1f18','10'=>'177fe7463dd4bb8eeb78','11'=>'622975576e055d970f1a','12'=>'21cb9723c6995b8842c1','23'=>'3887c788a6c9df41f737'
		);

		//$this->fill_insts();
	}

	function filters()
	{
	   $filters['course_id'] = array('label'=>'Reference No.');
	   $filters['course_title'] = array('label'=>'Course Title');
	   $filters['tbl_institutions:institution_name'] = array('label' => 'Institution Name', 'type'=>'select','options'=>$this->gradstate_institutions_model->options_list('institution_name','institution_name',array('slug != ' =>'uniserv')),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['pending'] = array('label' => 'Pending', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 
	   $filters['active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 

	    $filters['post_date_fromequal'] = array('type' => 'date','label'=>'From date');
	   $filters['post_date_toequal'] = array('type' => 'date','label'=>'To date');
	  // $filters['b:name'] = array('label'=>'Contacts');
	  return $filters;
	}

	public function list_items($limit = NULL, $offset = NULL, $col = 'course_title', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
	    $a=$this->_tables['gradstate_courses'];
		$b=$this->_tables['gradstate_institutions'];
		$c=$this->_tables['gradstate_course_location'];		

		$this->db->select("$a.id,course_id as reference_no,course_title,institution_name,post_date as date_added,pending as pending_approval,active",FALSE); 

		$this->db->join($b, "$b.institution_id = $a.institution_id", 'left');

		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		//die;
		return $data;
	}
	
	public function options_list($key = 'id', $val = 'course_title', $where = array(), $order = 'course_title')
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
		$values['course_id'] = empty($values['course_id'])? strtoupper(gen_unique_id(8,"","JZ")): $values['course_id'];		
		$values['slug'] = strtolower(url_title($values['course_title'], 'dash', TRUE));
		//$values['post_date'] = strtolower(url_title($values['course_title'], 'dash', TRUE));
		return $values;
	}
	
	public function _common_query($params = NULL)
	{
		parent::_common_query();
	    $a=$this->_tables['gradstate_courses'];
		$b=$this->_tables['gradstate_institutions'];
		$this->db->select($a.'.*,b.logo_picture,b.slug as inst_slug,institution_name',FALSE); 
		$this->db->join($b.' as b ', 'b.institution_id = '.$a.'.institution_id', 'left');
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);
		$campuses=array();
		$locations=array();
		$class_hours=array();
		$course_types=array();
		$course_levels=array();
		$course_sectors=array();
		
		if(!empty($values['id']))
		{
			$filter=array('course_id'=>$values['course_id']);
			$campuses=create_array($this->gradstate_course_to_campuses_model->options_list('campus_id','campus_id',$filter));
			$locations=create_array($this->gradstate_course_to_locations_model->options_list('location_id','location_id',$filter));

			$course_sectors=create_array($this->gradstate_course_to_sectors_model->options_list('sector_id','sector_id',$filter));

			$class_hours=create_array($this->gradstate_course_to_class_types_model->options_list('class_type_id','class_type_id',$filter));

			$course_types=create_array($this->gradstate_course_to_course_types_model->options_list('course_type_id','course_type_id',$filter));

			$course_levels=create_array($this->gradstate_course_to_levels_model->options_list('course_level_id','course_level_id',$filter));

			$app_form=$values['application_form'];		   
		}
		else
		{
			$app_form="";
		}


		$fields['app_form'] = array('type' => 'hidden', 'value' =>$app_form);
				
		$fields['application_form']['type']='file';
		$fields['application_form']['folder'] = $this->file_path;
		$fields['application_form']['upload_path'] = $this->file_path;
		//$fields['application_form']['img_styles'] = 'float: left; width: 150px;height:150px';

		$fields['course_title']['style'] = 'width: 200px;';
		$fields['application_form']['style'] = 'width: 300px;';	
		$fields['course_duration_fig']['style'] = 'width: 100px;';	
		$fields['fees_amount']['style'] = 'width: 100px;';
		$fields['course_title']['style'] = 'width: 400px;';
		$fields['fees_amount']['type'] = 'currency';
		$fields['fees_amount']['currency'] = ' ';

		$fields['campuses'] = array('type' => 'dependent', 'depends_on' => 'institution_id', 'url' => base_url().'ajax_load/campuses', 'multiple' => TRUE ,'value'=>$campuses);

		$fields['locations'] = array('type' => 'dependent', 'depends_on' => 'country', 'url' => base_url().'ajax_load/counties', 'multiple' => TRUE, 'value'=>$locations);

		$opts=$this->gradstate_sectors_model->options_list('id','name');
		$fields['course_sectors'] = array('type' => 'multi', 'value'=>$course_sectors,'options'=>$opts);

		$opts=$this->gradstate_class_types_model->options_list('id','name');
		$fields['class_hours'] = array('type' => 'multi','value'=>$class_hours,'options'=>$opts);

		$opts=$this->gradstate_course_types_model->options_list('id','name');
		$fields['course_types'] = array('type' => 'multi','value'=>$course_types,'options'=>$opts);

		$opts=$this->gradstate_course_levels_model->options_list('id','name');
		$fields['course_levels'] = array('type' => 'multi','value'=>$course_levels,'options'=>$opts);

		$fields['course_sectors']['required'] = true;
		$fields['class_hours']['required'] = true;
		$fields['course_types']['required'] = true;
		$fields['course_levels']['required'] = true;
		$fields['locations']['required'] = true;
		$fields['campuses']['required'] = true;
		$fields['course_duration_fig']['min'] = '0';	
		$fields['course_duration_fig']['max'] = '100';	
		$fields['institution_id']['label'] = 'Institution Name';

		
		$fields['course_title']['order'] = 1;
		$fields['institution_id']['order'] = 2;
		$fields['campuses']['order'] = 3;
		$fields['faculty']['order'] = 4;
		$fields['qualification_type']['order'] = 5;
		$fields['country']['order'] = 6;
		$fields['locations']['order'] = 7;



		$fields['course_sectors']['order'] = 8;
		$fields['class_hours']['order'] = 9;
		$fields['course_types']['order'] = 10;
		$fields['course_levels']['order'] = 11;

		$fields['registration_deadline']['order']=12;
		$fields['course_duration_fig']['order']=13;
		$fields['course_duration_per']['order']=14;

		$fields['fees_amount']['order']=15;
		$fields['currency']['order']=16;
		$fields['payment_period']['order']=17;
		$fields['description']['order']=18;
		$fields['eligibility']['order']=19;
		$fields['intake_dates']['order']=20;
		$fields['how_to_apply']['order']=21;



		$fields['application_form']['order'] = 99;
		$fields['pending']['order'] = 100;

		$fields['institution_id']['type']='select';
		$fields['institution_id']['options']=$this->gradstate_institutions_model->options_list('institution_id','institution_name',array('is_active'=>'yes'));
		$fields['institution_id']['first_option']='Select one...';

		$fields['faculty']['type']='select';
		$fields['faculty']['options']=$this->gradstate_faculties_model->options_list('id','name',array('published'=>'yes'));
		$fields['faculty']['first_option']='Select one...';

		$fields['qualification_type']['type']='select';
		$fields['qualification_type']['options']=$this->gradstate_qualifications_model->options_list('id','name',array('published'=>'yes'));
		$fields['qualification_type']['first_option']='Select one...';

		$fields['country']['type']='select';
		$fields['country']['options']=$this->gradstate_countries_model->options_list('id','name');
		$fields['country']['first_option']='Select one...';

		$fields['course_duration_fig']['label']='Course Duration';

		$fields['payment_period']['type']='select';
		$fields['payment_period']['options']=$this->payment_period;
		$fields['payment_period']['first_option']='Select one...';

		$fields['course_duration_per']['type']='select';
		$fields['course_duration_per']['options']=$this->duration_periods;
		$fields['course_duration_per']['first_option']='Select one...';
		$fields['course_duration_per']['label']=' ';

		$fields['currency']['type']='select';
		$fields['currency']['options']=$this->currency_list;
		$fields['currency']['first_option']='Select one...';		

		//print_r($fields);

		//die;
		return $fields;	
	}
	public function on_before_save($values)
	{
		$path= assets_server_path($this->file_path);		
	 	$the_fld='application_form';
		$rename=$values['course_id'];


	    $ret=trim(upload_files($the_fld,$path,$rename,'form'));			
	    if($ret!=="")	
	    {
			$application_form=$ret;
		}
		else
		{
			$application_form=$_POST['app_form'];
		}
		$values['application_form']=$application_form;
		if(isset($values['registration_deadline']))
		{
		unset($values['registration_deadline']);
		}
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

		$this->gradstate_course_to_campuses_model->delete(array('course_id' => $values['course_id']));
		$this->gradstate_course_to_locations_model->delete(array('course_id' => $values['course_id']));
		$this->gradstate_course_to_class_types_model->delete(array('course_id' => $values['course_id']));
		$this->gradstate_course_to_course_types_model->delete(array('course_id' => $values['course_id']));
		$this->gradstate_course_to_levels_model->delete(array('course_id' => $values['course_id']));
		$this->gradstate_course_to_sectors_model->delete(array('course_id' => $values['course_id']));

		$campuses = isset($_POST['campuses'])?$_POST['campuses']:array();
		$locations = isset($_POST['locations'])?$_POST['locations']:array();
		
		if (!empty($campuses))
		{
			foreach($campuses as $key=>$val)
			{
				if(strlen(trim($val))>0)
				{
					$data=array('course_id' => $values['course_id'],'campus_id'=>$val);
					$this->gradstate_course_to_campuses_model->save($data);
				}
			}
		}

		if (!empty($locations))
		{
			foreach($locations as $key=>$val)
			{
				if(strlen(trim($val))>0 && $values['course_id']!=="")
				{
				$data=array('course_id' => $values['course_id'],'location_id'=>$val);
				$this->gradstate_course_to_locations_model->save($data);
				}
			}
		}
		
		$course_sectors = isset($_POST['course_sectors'])?$_POST['course_sectors']:array();
		$class_hours = isset($_POST['class_hours'])?$_POST['class_hours']:array();
		$course_types = isset($_POST['course_types'])?$_POST['course_types']:array();
		$course_levels = isset($_POST['course_levels'])?$_POST['course_levels']:array();
		if (!empty($course_sectors))
		{
			foreach($course_sectors as $key=>$val)
			{
				if(strlen(trim($val))>0)
				{
				$data=array('course_id' => $values['course_id'],'sector_id'=>$val);
				$this->gradstate_course_to_sectors_model->save($data);
				}
			}
		}
		
		if (!empty($class_hours))
		{
			foreach($class_hours as $key=>$val)
			{
				if(strlen(trim($val))>0)
				{
				$data=array('course_id' => $values['course_id'],'class_type_id'=>$val);
				$this->gradstate_course_to_class_types_model->save($data);
				}
			}
		}
		
		if (!empty($course_types))
		{
			foreach($course_types as $key=>$val)
			{
				if(strlen(trim($val))>0)
				{
				$data=array('course_id' => $values['course_id'],'course_type_id'=>$val);
				$this->gradstate_course_to_course_types_model->save($data);
				}
			}
		}
		
		if (!empty($course_levels))
		{
			foreach($course_levels as $key=>$val)
			{
				if(strlen(trim($val))>0)
				{
				$data=array('course_id' => $values['course_id'],'course_level_id'=>$val);
				$this->gradstate_course_to_levels_model->save($data);
				}
			}
		}
		return $values;
	}

    function on_after_delete($where)
    {	
		$this->gradstate_course_to_campuses_model->delete($where);
		$this->gradstate_course_to_locations_model->delete($where);

		$this->gradstate_course_to_sectors_model->delete($where);
		$this->gradstate_course_to_class_types_model->delete($where);
		$this->gradstate_course_to_course_types_model->delete($where);
		$this->gradstate_course_to_levels_model->delete($where);
		return;
    }
    function get_search_data($term,$my_array,$order_by = 'course_title asc',$limit = NULL, $offset = NULL)
	{
		$a=$this->_tables['gradstate_courses'];
		$b=$this->_tables['gradstate_countries'];
		$c=$this->_tables['gradstate_qualifications'];
		$d=$this->_tables['gradstate_course_to_sector'];	
		$e=$this->_tables['gradstate_course_to_type'];	
		$f=$this->_tables['gradstate_course_to_level'];		
		$g=$this->_tables['gradstate_course_location'];		
		$h=$this->_tables['gradstate_course_campus'];	

		//tbl_course_to_sectors

		$this->db->from($a);
		$this->db->select("$a.*,$b.name as country_name,$c.name as qualification_name", FALSE);
		$this->db->join($b,"$a.country=$b.id", 'left');
		$this->db->join($c,"$a.qualification_type=$c.id", 'left');
		$this->db->join($d, "$d.course_id=$a.course_id", 'left');	
		$this->db->join($e, "$e.course_id=$a.course_id", 'left');	
		$this->db->join($f, "$f.course_id=$a.course_id", 'left');	
		$this->db->join($g, "$g.course_id=$a.course_id", 'left');	 
		$this->db->join($h, "$h.course_id=$a.course_id", 'left');	

		$this->db->group_by($a.'.course_id');

		$this->db->where($my_array);
		if($term!=="")
		{
			$this->db->where("MATCH (course_title) AGAINST ('*$term*' IN BOOLEAN MODE)", NULL, FALSE);
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
	function courses_by_institution($where)
	{
		$options = $this->options_list('course_id','course_title',$where);
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
	function migrate_courses()
	{
		$a="view_courses";
		$b="tbl_courses";

		$this->db->from($a);
		$this->db->select("$a.*", FALSE);
		$this->db->where(array('institution_id != '=>0));
		$q=$this->db->get();
		$res=$q->result_array();

		$i=0;

		foreach ($res as $row) 
		{
			$i++;
			echo "Row: $i  Rec: ".$row['course_id']."<br/>";
			
		 	$app=$row['application_form'];
			$row['application_form']=str_replace("http://www.gradstate.com/application_forms/","",$app);
			$old_id=trim($row['institution_id']);

			foreach ($this->ins_ids as $key => $value) 
			{
				if((int)$key==(int)$old_id)
				{
					$row['institution_id']=$value;
				}
			}

			$str=$row['sectors'];
			$sectors=array();
			$my_arr=explode(';',$str);
			foreach ($my_arr as $key => $val) 
			{
				$filter=array('name'=>$val);
				$q=$this->gradstate_sectors_model->find_one_array($filter);
				if(!empty($q))
				{
			  		array_push($sectors, $q['id']); 
			  	}

			}
			$_POST['course_sectors']=$sectors;


			$str=$row['class_hours'];
			$class_hours=array();
			$my_arr=explode(';',$str);
			foreach ($my_arr as $key => $val) 
			{
				$filter=array('name'=>$val);
				$q=$this->gradstate_class_types_model->find_one_array($filter);
				if(!empty($q))
				{
			  		array_push($class_hours, $q['id']); 
			  	}

			}
			$_POST['class_hours']=$class_hours;
			

			$str=$row['course_types'];
			$course_types=array();
			$my_arr=explode(';',$str);
			foreach ($my_arr as $key => $val) 
			{
				$filter=array('name'=>$val);
				$q=$this->gradstate_course_types_model->find_one_array($filter);
				if(!empty($q))
				{
			  		array_push($course_types, $q['id']); 
			  	}

			}
			$_POST['course_types']=$course_types;


			$str=$row['course_levels'];
			$course_levels=array();
			$my_arr=explode(';',$str);
			foreach ($my_arr as $key => $val) 
			{
				$filter=array('name'=>$val);
				$q=$this->gradstate_course_levels_model->find_one_array($filter);
				if(!empty($q))
				{
			  		array_push($course_levels, $q['id']); 
			  	}

			}
			$_POST['course_levels']=$course_levels;


			$_POST['campuses']=array();
			$_POST['locations']=array();


			$filter=array('name'=>$row['country']);
			$q=$this->gradstate_countries_model->find_one_array($filter);
			$row['country']=isset($q['id'])?$q['id']:"";


			$row['pending']=$row['pending']==="2"?'no':'yes';
			$row['active']=$row['active']==="1"?'yes':'no';

			$filter=array('name'=>trim($row['qualification_type']));
			$q=$this->gradstate_qualifications_model->find_one_array($filter);

			$row['qualification_type']=isset($q['id'])?$q['id']:"";

			$filter=array('name'=>$row['faculty']);
			$q=$this->gradstate_faculties_model->find_one_array($filter);
			$row['faculty']=isset($q['id'])?$q['id']:"";

			$data=$this->on_before_clean($row);
			$data=$this->clean($data);

			$this->insert($data);
			$this->on_after_insert($data);	
		}
	}

	/*function fill_insts()
	{
		$res=$this->find_all_array();

		foreach ($res as $row) 
		{
			$data=array('institution_id'=>'79194b3b9ffb5da15ecb','course_id'=>$row['course_id']);
			$this->update($data,array('institution_id'=>'2'));

		}
		echo "finished";
		die;
	}*/
}