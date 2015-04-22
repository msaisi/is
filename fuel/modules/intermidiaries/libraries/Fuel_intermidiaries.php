<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuel_gradstate extends Fuel_advanced_module {
	
	protected $_settings = NULL;
	public $from_email=null;

	/**
	 * Constructor
	 *
	 * The constructor can be passed an array of config values
	 */
	function __construct($params = array())
	{
		parent::__construct();
		
		if (empty($params))
		{
			$params['name'] = 'gradstate';
		}
		$this->initialize($params);

		$this->from_email="no-reply@gradstate.com";
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */	
	function initialize($params = array())
	{
		parent::initialize($params);
		
		if (!empty($params))
		{
			foreach ($params as $key => $val)
			{
				$sans_gradstate_key = substr($key, count('gradstate_'));
				if (isset($this->$key))
				{
					$this->$sans_gradstate_key = $val;
				}
			}
		}		
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the title of the gradstate specified in the settings
	 *
	 * @access	public
	 * @return	string
	 */
	function title()
	{
		return $this->config('title');
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the descripton of the gradstate specified in the settings
	 *
	 * @access	public
	 * @return	string
	 */
	function description()
	{
		return $this->config('description');
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the language abbreviation currently used in CodeIgniter
	 *
	 * @access	public
	 * @param	boolean
	 * @return	string
	 */
	function language($code = FALSE)
	{
		$language = $this->CI->config->item('language');
		if ($code)
		{
			$this->CI->config->module_load(WALTIKE_FOLDER, 'language_codes');
			$codes = $this->CI->config->item('lang_codes');
			$flipped_codes = array_flip($codes);
			if (isset($flipped_codes[$language]))
			{
				return $flipped_codes[$language];
			}
			return FALSE;
		}
		else
		{
			return $language;
		}
	}
	

	/**
	 * Returns the domain to be used for the gradstate based on the FUEL configuration. 
	 * If empty it will return whatever $_SERVER['SERVER_NAME']. Needed for Atom feeds
	 *
	 * @access	public
	 * @param	boolean
	 * @return	string
	 */
	function domain()
	{
		if ($this->CI->config->item('domain', 'fuel'))
		{
			return $this->CI->config->item('domain', 'fuel');
		}
		else
		{
			return $_SERVER['SERVER_NAME'];
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns the path to the theme view files
	 *
	 * @access	public
	 * @return	string
	 */
	function theme_path()
	{
		$theme_path = trim($this->config('theme_path'), '/').'/';
		return $theme_path;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns name of the theme layout file to use
	 *
	 * @access	public
	 * @return	string
	 */
	function layout()
	{
		return '_layouts/'.$this->config('theme_layout');
	}
		
	// --------------------------------------------------------------------

	/**
	 * Returns header of the gradstate
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function header($vars = array(), $return = TRUE)
	{
		return $this->view('_blocks/header', $vars, $return);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns a view for the gradstate
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	boolean
	 * @return	string
	 */
	function view($view, $vars = array(), $return = TRUE)
	{
		$view_folder = $this->theme_path();
		$block = $this->CI->load->module_view($this->config('theme_module'), $view_folder.$view, $vars, TRUE);
		if ($return)
		{
			return $block;
		}
		echo $block;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns a block view file for the gradstate
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	boolean
	 * @return	string
	 */
	function block($block, $vars = array(), $return = TRUE)
	{
		$view = '_blocks/'.$block;
		return $this->view($view, $vars, $return);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Returns a the specified gradstate model object. Options are posts, categories, comments, settings and links
	 *
	 * @access	public
	 * @param	string
	 * @return	object
	 */
	function model($model)
	{
		$model_name = 'gradstate_'.strtolower($model).'_model';
		if (!isset($this->CI->$model))
		{
			$this->load_model($model_name);
		}
		return $this->CI->$model_name;
	}
	// --------------------------------------------------------------------

	/**
	 * Returns the page title
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function page_title($title = '', $sep = NULL, $order = 'right')
	{
		$title_arr = array();
		if (!isset($sep))
		{
			$sep = $this->config('page_title_separator');
		}
		if ($order == 'left') $title_arr[] = $this->config('title');
		if (is_array($title))
		{
			foreach($title as $val)
			{
				$title_arr[] = $val;
			}
		}
		else if (!empty($title))
		{
			array_push($title_arr, $title);
		}

		if ($order == 'right') $title_arr[] = $this->config('title');
		return implode($sep, $title_arr);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Convenience magic method if you want to drop the "get" from the method
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @return	string
	 */
	function __call($name, $args)
	{
		$method = 'get_'.$name;
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $args);
		}
	}

	function get_logo_list()
	{
		$ci=& get_instance();
		$now=datetime_now();
		$ret_array=array();
		$where=array('expiry_date >= '=>$now,'package_group'=>3);
		$list_a=$ci->gradstate_packages_subscriptions_model->find_all_array($where);
		if(!empty($list_a))
		{
			foreach ($list_a as $row) 
			{
				$ret_array[$row['institution_id']]=$row['institution_id'];
			}
		}
		$where=array('expiry_date >= '=>$now,'feature_id'=>2);
		$list_b=$this->CI->gradstate_features_subscriptions_model->find_all_array($where);
		if(!empty($list_b))
		{
			foreach ($list_b as $row) 
			{
				$ret_array[$row['institution_id']]=$row['institution_id'];
			}
		}
		if(empty($ret_array))
		{
			return array();
		}		
		return $ret_array;
	}
	
	function items_list($term, $my_array, $order_by = 'tbl_institutions.institution_name asc', $limit = NULL, $offset = NULL)
	{
		$my_array['tbl_institutions.slug <> ']="uniserv";
		$res=$this->CI->gradstate_institutions_model->get_search_data($term, $my_array, $order_by, $limit, $offset);
		return $res; 
	}
	
	function course_items_list($term, $my_array, $order_by = 'tbl_courses.course_title asc', $limit = NULL, $offset = NULL)
	{
		$res=$this->CI->gradstate_courses_model->get_search_data($term, $my_array, $order_by, $limit, $offset);
		return $res; 
	}

	function university_items_list($term, $my_array, $order_by = 'tbl_international_universities.institution_name asc', $limit = NULL, $offset = NULL)
	{
		$res=$this->CI->gradstate_international_universities_model->get_search_data($term, $my_array, $order_by, $limit, $offset);
		return $res; 
	}
	function campuses_by_institution($where)
	{
		return $this->CI->gradstate_campuses_model->campuses_by_institution($where);
	}
	function courses_by_institution($where)
	{
		return $this->CI->gradstate_courses_model->courses_by_institution($where);
	}
	function get_counties($where)
	{
		$val=(int)$where['id'];
		if($val>0)
		{
			$res=$this->CI->gradstate_countries_model->find_one_array($where);
			$ctry=$res['slug'];
			$county="";
			if($ctry==="kenya")
			{
				$filter=array('slug != '=>'international');
				$county=$this->CI->gradstate_counties_model->counties_ajax($filter);
			}
			else
			{
				$filter=array('slug'=>'international');
				$county=$this->CI->gradstate_counties_model->counties_ajax($filter);
			}
		}
		else
		{
			$county=$this->CI->gradstate_counties_model->counties_ajax(array());
		}

		echo $county;
		return ;
	}
	function get_counties_opts($where)
	{
		$res=$this->CI->gradstate_countries_model->find_one_array($where);
		$ctry=$res['slug'];
		$county="";
		if($ctry==="kenya")
		{
			$filter=array('slug != '=>'international');
			$county=$this->CI->gradstate_counties_model->options_list('id','name',$filter);
		}
		else
		{
			$filter=array('slug'=>'international');
			$county=$this->CI->gradstate_counties_model->options_list('id','name',$filter);
		}
		return $county;
	}
	function get_institution($filter)
	{
		return $this->CI->gradstate_institutions_model->find_one_array($filter);
	}
	function get_campuses($filter=array())
	{
		return $this->CI->gradstate_campuses_model->find_all_array($filter);
	}
	function get_courses($filter)
	{
		return $this->CI->gradstate_courses_model->find_all_array($filter);
	}

	function update_inst_profile($post,$where)
	{
		$model='gradstate_institutions_model';
		$data=$this->CI->$model->on_before_clean($post);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$this->CI->$model->update($data, $where);
		return;
	}
	function deactivate($post,$where)
	{
			$res=$this->CI->gradstate_institutions_model->find_one_array(array("institution_id"=>$where['institution_id']));
			$inst_names = ucwords($res['institution_name']);
			$names = ucwords($res['contact_person']);
			$email=$res['email'];

			$params['to'] = $email;
			$params['subject'] = lang('account_deactivation_sub');		
			$params['use_dev_mode'] = FALSE;
			$params['from_name']=$this->fuel->gradstate->config('email_nice_name');
			$params['from']=$this->from_email;
			$msg= "Dear $names,<br/>".lang('deactivate_institution_email', $inst_names);

			$dets['not_view']='deactivate';
			$dets['not_ttl']='Account deactivation';
			$dets['msg']=$msg;
			ob_start();
			$this->CI->load->view('_blocks/not_temp',$dets);
	        $params['message'] =ob_get_clean();
			$this->fuel->notification->send($params);			
			$model='gradstate_institutions_model';
			$data=$this->CI->$model->clean($post);
			$this->CI->$model->update($data, $where);
			return;
	}
    
    public function update_account_password($data,$where)
	{
		$where['is_active'] = 'yes';
		$model="gradstate_institutions_model";
		$lib='gradstate_institutions_auth';
		
		$user_exist=$this->CI->$model->check_old_password($data['old_password'],$where['institution_id']);

		if(empty($user_exist))
		{
			return array('type'=>'danger', 'msg'=>'Sorry, could not update your account password. Incorrect old password entered.','icon'=>'fa fa-frown-o');
		}
		else
		{
			$res=$this->CI->$model->find_one_array(array("institution_id"=>$where['institution_id']));
			$institution_id = $res['institution_id'];
			$inst_names = ucwords($res['institution_name']);
			$names = ucwords($res['contact_person']);
			$email=$res['email'];

		    $pwd=$data['new_password'];

			$params['to'] = $email;
			$params['subject'] = lang('edit_institution_email_subject');		
			$params['use_dev_mode'] = FALSE;
			$params['from_name']=$this->fuel->gradstate->config('email_nice_name');
			$params['from']=$this->from_email;
			$msg= "Dear $names,<br/>".lang('edit_institution_email', $inst_names,site_url(),site_url(), $email, $pwd);

			 $dets['not_view']='reset_pass';
			 $dets['not_ttl']='New login credentials';
			 $dets['msg']=$msg;
			 ob_start();
			 $this->CI->load->view('_blocks/not_temp',$dets);
	         $params['message'] =ob_get_clean();
			if (!$this->fuel->notification->send($params))
			{
				$this->CI->fuel->logs->write($this->fuel->notification->last_error(), 'debug');
				//add_error(lang('edit_client_pass', $email));
				$msg="Sorry, we could not complete the requested action at the moment. Our email server is not responding. Please try again later!";
				return array('type'=>'danger','msg'=>$msg,'icon'=>'fa fa-frown-o'); 
			}
			else
			{
				$u_data=array('password'=>$data['new_password'],'institution_id'=>$where['institution_id']);
				$vals=$this->CI->$model->on_before_clean($u_data);

				if ($this->CI->$model->update($vals, $where))
				{
					//$this->CI->fuel->logs->write(lang('auth_client_log_reset_success',$email, $this->CI->input->ip_address()), 'debug');
					return array('type'=>'success', 'msg'=>'Account password changed. Details sent to your email address : <strong>'. $email.'</strong>.','icon'=>'fa fa-smile-o');	
				}

				return array('type'=>'danger', 'msg'=>'Sorry, could not update your account password. A database error occured. Pleas etry again later.','icon'=>'fa fa-frown-o');
			}			
		}

	}
	public function get_features()
	{
		$filter=array('published'=>'yes');
		return $this->CI->gradstate_features_model->find_all_array($filter);
	}

	
	public function get_packages()
	{
		$filter=array('published'=>'yes');
		return $this->CI->gradstate_packages_model->find_all_array($filter);		
	}

	public function get_my_features($where)
	{
		$now=datetime_now();
		$where['expiry_date >= ']=$now;
		return $this->CI->gradstate_features_subscriptions_model->find_all_array($where);
	}
	
	public function get_my_packages($where)
	{
		$now=datetime_now();
		$where['expiry_date >= ']=$now;
		return $this->CI->gradstate_packages_subscriptions_model->find_all_array($where);		
	}
	public function get_my_packages_list($where)
	{
		$this->CI->datatables->select("name,start_date,expiry_date");
		$this->CI->datatables->from('tbl_packages_subscriptions');
		$this->CI->datatables->join('tbl_package_pricing','tbl_package_pricing.id=tbl_packages_subscriptions.package_id');
		$this->CI->datatables->edit_column('start_date', '$1', 'format_full_date(start_date)');
		$this->CI->datatables->edit_column('expiry_date', '$1', 'format_full_date(expiry_date)');
	 	$this->CI->datatables->where($where);
		echo $this->CI->datatables->generate();
	}
	public function get_my_features_list($where)
	{
		$this->CI->datatables->select("name,start_date,expiry_date");
		$this->CI->datatables->from('tbl_features_subscriptions');
		$this->CI->datatables->join('tbl_features','tbl_features.id=tbl_features_subscriptions.feature_id');
		$this->CI->datatables->edit_column('start_date', '$1', 'format_full_date(start_date)');
		$this->CI->datatables->edit_column('expiry_date', '$1', 'format_full_date(expiry_date)');
	 	$this->CI->datatables->where($where);	 	
		echo $this->CI->datatables->generate();
	}
	public function get_my_courses($filter)
	{
		return $this->CI->gradstate_courses_model->find_all_array($filter);
	}
	public function get_my_universities($filter)
	{
		return $this->CI->gradstate_international_universities_model->find_all_array();
	}
	public function get_my_courses_list($where)
	{
		$this->CI->datatables->select("course_id,course_title,post_date,pending,active");
		$this->CI->datatables->from('tbl_courses');
		$this->CI->datatables->edit_column('post_date', '$1', 'format_full_date(post_date)');
		//$this->CI->datatables->edit_column('registration_deadline', '$1', 'format_full_date(registration_deadline)');

		$this->CI->datatables->add_column('actions', '
	<a href="courses/$1" title="view" target="_blank"><i class="fa fa-eye"> View</i></a> &nbsp;
	<a href="account/course_details/$1" title="Details"><i class="fa fa-folder-open-o"> Details</i></a>', 'course_id');

		$this->CI->datatables->where($where);	 	
		echo $this->CI->datatables->generate();
	}
	public function get_my_universities_list($where)
	{
		$a='tbl_international_universities';
		$b='tbl_countries';
		$c='tbl_institution_types';	

		$this->CI->datatables->select("institution_id,institution_name,official_address,b.name as country_name,c.name as institution_type,is_active");
		$this->CI->datatables->from($a);

		$this->CI->datatables->join($b.' as b', "b.id = $a.country", 'left');
		$this->CI->datatables->join($c.' as c', "c.id = $a.account_type", 'left');

		$this->CI->datatables->add_column('actions', '
	<a href="international_institutions/$1" title="view" target="_blank"><i class="fa fa-eye"> View</i></a> &nbsp;
	<a href="account/university_details/$1" title="Details"><i class="fa fa-folder-open-o"> Details</i></a>&nbsp;
	<a onClick="javascript:delete_item(\'university\',\'$1\')" title="Detete University"><i class="fa fa-trash-o"> Delete</i></a>', 'institution_id');

		$this->CI->datatables->unset_column('institution_id');
	//	$this->CI->datatables->where($where);	 	
		echo $this->CI->datatables->generate();
	}
	public function get_my_campuses_list($where)
	{
		$res=$this->CI->gradstate_institutions_model->find_one_array($where);
		$slug=$res['slug'];		
		$this->CI->datatables->select("campus_id,campus_name,campus_email,contacts,tbl_counties.name as location_name,is_active");
		$this->CI->datatables->from('tbl_institution_campuses');
		$this->CI->datatables->join('tbl_counties','tbl_counties.id=tbl_institution_campuses.location','left');

		$this->CI->datatables->add_column('actions', '
	<a href="courses?parent='.$slug.'&campus=$1" title="view" target="_blank"><i class="fa fa-eye"> View</i></a> &nbsp;
	<a href="account/campus_details/$1" title="Details"><i class="fa fa-folder-open-o"> Details</i></a>', 'campus_id');

		$this->CI->datatables->unset_column('campus_id');
		$this->CI->datatables->where($where);	 	
		echo $this->CI->datatables->generate();
	}
	public function add_course($data)
	{
		$model='gradstate_courses_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$data=$this->CI->$model->insert($data);
		$data=$this->CI->$model->on_after_insert($data);		
		return;
	}
	public function update_course($data, $where)
	{
		$model='gradstate_courses_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$data=$this->CI->$model->update($data,$where);
		$data=$this->CI->$model->on_after_update($data);		
		return;
	}
	public function add_university($data)
	{
		$model='gradstate_international_universities_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$data=$this->CI->$model->insert($data);
		$data=$this->CI->$model->on_after_insert($data);		
		return;
	}
	public function update_university($data, $where)
	{
		$model='gradstate_international_universities_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$data=$this->CI->$model->update($data,$where);
		$data=$this->CI->$model->on_after_update($data);		
		return;
	}


	public function get_course_details($filter)
	{
		$course_dets=$this->CI->gradstate_courses_model->get_search_data("",array('tbl_courses.course_id'=>$filter['course_id']));
		$course=$course_dets[0];

		$campuses=create_array($this->CI->gradstate_course_to_campuses_model->options_list('campus_id','campus_id',$filter));
		$locations=create_array($this->CI->gradstate_course_to_locations_model->options_list('location_id','location_id',$filter));
		$course_sectors=create_array($this->CI->gradstate_course_to_sectors_model->options_list('sector_id','sector_id',$filter));
		$class_hours=create_array($this->CI->gradstate_course_to_class_types_model->options_list('class_type_id','class_type_id',$filter));
		$course_types=create_array($this->CI->gradstate_course_to_course_types_model->options_list('course_type_id','course_type_id',$filter));
		$course_levels=create_array($this->CI->gradstate_course_to_levels_model->options_list('course_level_id','course_level_id',$filter));
		return array('course'=>$course,'campuses'=>$campuses,'locations'=>$locations,'course_sectors'=>$course_sectors,'class_hours'=>$class_hours,'course_types'=>$course_types,'course_levels'=>$course_levels);

	}

	public function get_university_details($filter)
	{
		$university_dets=$this->CI->gradstate_international_universities_model->get_search_data("",array('tbl_international_universities.institution_id'=>$filter['institution_id']));
		$university=$university_dets[0];

		$faculties=create_array($this->CI->gradstate_international_universities_to_faculty_model->options_list('faculty_id','faculty_id',$filter));
		
		$qualifications=create_array($this->CI->gradstate_international_universities_to_qualifications_model->options_list('qualification_id','qualification_id',$filter));
		return array('university'=>$university,'faculties'=>$faculties,'qualifications'=>$qualifications);

	}

	public function get_my_subscription($where)
	{
		return count($this->get_my_packages($where));
	}
	public function get_my_free_slots($where)
	{
		$saved=count($this->get_my_courses($where));
		$pack=$this->get_my_packages($where);

		if(!empty($pack))
		{
			$filter=array('id'=>$pack[0]['package_group']);
			$res=$this->CI->gradstate_packages_model->find_one_array($filter);

			$slots=$res['courses'];
			if($slots==0)
			{
				return 1;
			}
			return $slots-$saved;
		}
		return 0;
	}

	public function save_download($data)
	{
		$model='gradstate_form_downloads_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$this->CI->$model->insert($data);
		return $data;
	}
	public function save_q_download($data)
	{
		$model='gradstate_quick_downloads_log_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$this->CI->$model->insert($data);
		return $data;
	}
	public function add_newletter_user($data)
	{
		$model='newsletter_subscribers_model';
		$data=$this->CI->$model->clean($data);
		$this->CI->$model->insert($data);
		return $data;
	}

	public function get_my_applications_list($where)
	{
		$this->CI->datatables->select("form_serial,course_title,first_name,last_name,gender,email,contacts,download_date");
		$this->CI->datatables->from('tbl_form_downloads');
		$this->CI->datatables->join('tbl_courses','tbl_courses.course_id=tbl_form_downloads.course_id','left');
		$this->CI->datatables->edit_column('course_title', '$1', 'course_title(course_title)');
		
		
		$this->CI->datatables->edit_column('download_date', '$1', 'format_disp_date(download_date)');
		$this->CI->datatables->add_column('actions', '
	<a href="account/application_details/$1" title="Details"><i class="fa fa-folder-open-o"> Details</i></a>', 'form_serial');

	 	$this->CI->datatables->where($where);	 	
		echo $this->CI->datatables->generate();
	}
	public function get_my_quick_downloads_list($where)
	{
		$this->CI->datatables->select("download_id,file_name,first_name,last_name,gender,email,contacts,download_date");
		$this->CI->datatables->from('tbl_quick_downloads_log');

		$this->CI->datatables->add_column('actions', '
	<a href="account/quick_download_details/$1" title="Details"><i class="fa fa-folder-open-o"> Details</i></a>', 'download_id');


		$this->CI->datatables->unset_column('download_id');
	 	$this->CI->datatables->where($where);	 	
		echo $this->CI->datatables->generate();
	}

	public function get_my_inquiries_list($where)
	{
		$a="tbl_university_inquiries";

		//contacts

		$this->CI->datatables->select("inquiry_id,first_name,last_name,gender,email,contacts,institution_name,ctry1.name as coi,tbl_faculties.name as faculty_name,ctry.name as user_nationality, tbl_counties.name as county_name,tbl_countries.name as country_name,inquiry_date");
		$this->CI->datatables->from($a);
		$this->CI->datatables->join("tbl_countries as ctry","ctry.id=$a.nationality",'left');
		$this->CI->datatables->join("tbl_countries as ctry1","ctry1.id=$a.country",'left');
		$this->CI->datatables->join("tbl_countries","tbl_countries.id=$a.country",'left');

		$this->CI->datatables->join("tbl_counties","tbl_counties.id=$a.location",'left');
		$this->CI->datatables->join("tbl_faculties","tbl_faculties.id=$a.faculty",'left');
		$this->CI->datatables->join("tbl_international_universities","tbl_international_universities.id=$a.institution_id",'left');

		$this->CI->datatables->edit_column('inquiry_date', '$1', 'format_disp_date(inquiry_date)');

		$this->CI->datatables->add_column('actions', '
	<a href="account/inquiry_details/$1" title="Details"><i class="fa fa-folder-open-o"> Details</i></a> &nbsp;
	<a onClick="javascript:delete_item(\'inquiry\',\'$1\')" title="Detete Inquiry"><i class="fa fa-trash-o"> Delete</i></a>', 'inquiry_id');
		$this->CI->datatables->unset_column('inquiry_id');
		echo $this->CI->datatables->generate();
	}
	function get_application_details($where)
	{
		return $this->CI->gradstate_form_downloads_model->find_one_array($where);
	}
	function get_inquiry_details($where)
	{
		return $this->CI->gradstate_university_inquiries_model->find_one_array($where);
	}
	function get_quick_downloads($where)
	{
		return $this->CI->gradstate_quick_downloads_model->find_all_array($where);
	}
	function get_parent_inst($where)
	{	
		$res= $this->CI->gradstate_campuses_model->find_one_array($where); 
		return $res['institution_id'];
	}

	function get_hot_courses()
	{	
		$opts=$this->CI->gradstate_hot_courses_bindings_model->options_list('course_id','course_id'); 

		$res=array();
		foreach ($opts as $key => $value) 
		{
			$filter=array('course_id'=>$value);
			$res[]= $this->CI->gradstate_courses_model->find_one_array($filter); 	
		}
		shuffle($res);
		return $res;
	}
	function migrate_courses()
	{
		//$this->CI->gradstate_courses_model->migrate_courses();
		//return;
	}
	function inst_types()
	{
		return $this->CI->gradstate_institution_types_model->options_list();
	}
	function migrate_alerts()
	{
		//$this->CI->gradstate_course_alerts_model->migrate_alerts();
		//return;
	}
	public function add_campus($data)
	{
		$model='gradstate_campuses_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$data=$this->CI->$model->insert($data);		
		return;
	}
	public function update_campus($data, $where)
	{
		$model='gradstate_campuses_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->on_before_save($data);
		$data=$this->CI->$model->update($data,$where);	
		return;
	}
	public function log_item($data)
	{
		$model='gradstate_clicks_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->insert($data);	
		return;
	}
	public function add_inquiry($data)
	{
		$model='gradstate_university_inquiries_model';
		$data=$this->CI->$model->on_before_clean($data);
		$data=$this->CI->$model->clean($data);
		$data=$this->CI->$model->insert($data);		
		return;
	}

	

	public function get_my_clicks_list($where)
	{
		$this->CI->datatables->select("item,type,log_time");
		$this->CI->datatables->from('tbl_site_clicks');
		$this->CI->datatables->edit_column('log_time', '$1', 'format_full_date(log_time)');
		$this->CI->datatables->where($where);	
		echo $this->CI->datatables->generate();		
	}
}
/* End of file Fuel_student.php */
/* Location: ./modules/student/libraries/Fuel_student.php */