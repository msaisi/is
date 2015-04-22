<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/companies/config/companies_constants.php');
class Companies_users_model extends Base_module_model 
{
	public $required = array('user_name', 'email', 'first_name', 'last_name','company_code','contacts','identification_number','identification_type','super_admin'); 
	public $filters = array('first_name', 'last_name', 'user_name'); 
	public $unique_fields = array('user_name');
	
	/**
	 * Constructor.
	 *
	 * @access	public
	 * @return	void
	 */	
	public function __construct()
	{
		parent::__construct('companies_users', COMPANIES_FOLDER);
		$this->my_fields_map=array('profile_image'=>"-profile-image-is-staff");		
		$this->company_config= $this->fuel->companies->config();
	}

	/**
	 * Determines whether the passed user name and password are valid
	 *
	 * @access	public
	 * @param	string	The user name
	 * @param	string	The password
	 * @return	boolean 
	 */
	public function valid_user($email, $pwd)
	{
		$where = array('email' => $email, 'is_active' => 'yes');
		$user = $this->find_one_array($where);

		if (empty($user['salt'])) return FALSE;

		if ($user['password'] == salted_password_hash($pwd, $user['salt']))
		{
			$where = array('email' => $email, 'is_active' => 'yes');
			$user = $this->find_one_array($where);
			unset($user['password']);
			unset($user['salt']);
			unset($user['is_active']);
			unset($user['identification_type']);
			unset($user['identification_number']);
			unset($user['profile_image']);
			unset($user['reset_key']);
			unset($user['about']);
			unset($user['user_name']);
			unset($user['id']);
			return encrypt_data($user);
		}
		return FALSE;
	}
	public function unlock_account($email, $pwd)
	{
		$where = array('email' => $email, 'is_active' => 'yes');
		$user = $this->find_one_array($where);

		if (empty($user['salt'])) return FALSE;

		if ($user['password'] == salted_password_hash($pwd, $user['salt']))
		{
		    $this->CI->session->unset_userdata('is_locked');			
			return true;
		}
		return FALSE;
	}
	
	/**
	 * Determines whether the passed user name and password are valid for FUEL 0.93
	 *
	 * @access	public
	 * @param	string	The user name
	 * @param	string	The password
	 * @return	boolean 
	 */
	public function valid_old_user($user, $pwd)
	{
		$where = array('email' => $user, 'is_active' => 'yes');
		$user = $this->find_one_array($where);
		
		if (empty($user)) {
			return FALSE;
		}
		
		if (empty($user['salt']) AND ($user['password'] == md5($pwd))) {
			return $user;
		}
		
		return FALSE;
	}
	public function check_old_password($pwd,$uid)
	{
		$tbl=$this->_tables['companies_users'];
		$where = array($tbl.'.id ' => $uid);
		$user = $this->find_one_array($where);

		if (empty($user['salt'])) return FALSE;

		if ($user['password'] === salted_password_hash($pwd, $user['salt']))
		{
			return $user;
		}
		return FALSE;
	}
	
	public function list_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'desc', $just_count = FALSE)
	{
		$CI =& get_instance();

		$this->db->select('id, CONCAT(first_name, " ", last_name) as names, email,contacts,is_active',FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);

		return $data;
	}
	function access_levels($filter)
	{
		$accesses='user_access_level';
		$this->db->select('name,group_id', FALSE);
		$this->db->from("$accesses");
		$this->db->where($filter);
		$res=$this->db->get()->result();	
		return $res;
	}	
	function get_permissions($user_id)
	{
		$group_to_users='tbl_companies_usergroup_to_users';
		$group_to_permissions="tbl_companies_usergroup_to_permissions";
		$permissions='fuel_permissions';
		$this->db->select('c.id,c.description,c.name,c.active', FALSE);
		$rel_join = "a.group_id = b.group_id AND a.user_id = $user_id";

		$this->db->from("$group_to_users as a");
		$this->db->where('c.active','yes');
		$this->db->join("$group_to_permissions as b", $rel_join, 'left');
		$this->db->join("$permissions as c", 'b.permission_id = c.id', 'left');
		$res=$this->db->get()->result_array();

		$perms=array();

		if(!empty($res))
		{
			foreach ($res as $perm) 
			{
				$perms[]=$perm['name'];
			}
		}
		return $perms;
	}

	/**
	 * Resets the password with a random value
	 *
	 * @access	public
	 * @param	string The email address of the user to reset 
	 * @return	string The new password
	 */	
	public function reset_password($email)
	{
		// check first to see if they exist in the system
		$CI =& get_instance();
		$CI->load->helper('string');
		
		// make sure user exists when saving
		$this->add_validation('email', array(&$this, 'user_exists'), 'User does not exist', '{email}');
		
		$user = $this->find_one_array(array('email' => $email));

		if (!empty($user))
		{
			$reset_key = random_string('alnum', 8);
			//$user['password'] = $new_pwd;
			$user['reset_key'] = $reset_key;
			$where['email'] = $email;
			unset($user['password']);
			if ($this->save($user, $where))
			{
				return $reset_key;
			}
		}
		return FALSE;
	}
	
	/**
	 * Determines whether a user exists
	 *
	 * @access	public
	 * @param	string The email address of the user
	 * @return	boolean 
	 */	
	public function user_exists($email)
	{
		return $this->record_exists(array('email' => $email));
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * Overwritten options list method
	 *
	 * @access	public
	 * @param	string The key value for the options list (optional)
	 * @param	string The value (lable) value for the options list (optional)
	 * @param	string A where condition to apply to options list data
	 * @param	string The order to return the options list data
	 * @return	array 
	 */	
	public function options_list($key = 'id', $val = 'names', $where = array(), $order = 'names')
	{
		$CI =& get_instance();
		$val='names';
		if ($key == 'id')
		{
			$key = $this->table_name.'.id';
		}
		if ($val == 'names')
		{
			$val = 'CONCAT(first_name, " ", last_name) as names';
			$order = 'names';
		}
		else
		{
			$order = $val;
		}
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * User form fields
	 *
	 * @access	public
	 * @param	array Values of the form fields (optional)
	 * @param	array An array of related fields. This has been deprecated in favor of using has_many and belongs to relationships (deprecated)
	 * @return	array An array to be used with the Form_builder class
	 */	
	public function form_fields($values = array(), $related = array())
	{
		$CI =& get_instance();	
		$fields = parent::form_fields($values, $related);

		$access_levels = $CI->groups_model->options_list('id','name',array('is_active'=>'yes'));	
		
		$fields['profile_image']['folder'] = $CI->fuel->companies->config('asset_upload_path_company_user_images');	
		$fields['profile_image']['upload_path'] = $CI->fuel->companies->config('asset_upload_path_company_user_images');
		$fields['profile_image']['img_styles'] = 'float: left; width: 150px;height:150px; margin-left:5px;margin-top:3px';
		$fields['profile_image']['label']="Profile Image";
		$fields['profile_image']['file_name'] = '{user_name}'.$this->my_fields_map['profile_image'];
		$fields['profile_image']['readonly'] = true;
		$fields['profile_image']['style'] = 'width: 0%;';	
		
		// save reference it so we can reorder
		$pwd_field = $fields['password'];
		unset($fields['password']);

		if (!empty($values['id']))
		{
			$fields['new_password'] = array('label' => lang('form_label_new_password'), 'type' => 'password', 'size' => 20, 'order' => 13);
		}
		else
		{
			$pwd_field['type'] = 'password';
			$pwd_field['size'] = 20;
			$pwd_field['order'] = 13;
			$fields['password']= $pwd_field;
			unset($fields['backend_access'], $fields['active']);
		}

		$fields['user_name']['style'] = 'width: 300px;';
		$fields['email']['style'] = 'width: 300px;';
		$fields['first_name']['style'] = 'width: 300px;';
		$fields['last_name']['style'] = 'width: 300px;';
		$fields['company_code']['style'] = 'width: 300px;';
		$fields['identification_type']['style'] = 'width: 300px;';
		$fields['identification_number']['style'] = 'width: 300px;';		
		$fields['contacts']['style'] = 'width: 300px;';
		
		$fields['confirm_password'] = array('label' => lang('form_label_confirm_password'), 'type' => 'password', 'size' => 20, 'order' => 13.5);


		$fields['profile_image']['order']=1;
		$fields['first_name']['order'] = 2;
		$fields['last_name']['order'] = 3;	
		$fields['user_name']['order'] = 4;
		$fields['identification_type']['order'] = 5;	
		$fields['identification_number']['order'] = 6;
		$fields['email']['order'] = 7;
		$fields['contacts']['order'] = 8;
		$fields['about']['order'] = 9;
		$fields['company_code']['order'] = 10;
		$fields['super_admin']['order'] = 11;
		$fields['access_level']['order'] = 12.5;
		$fields['department_code']['order'] = 12;

		
		$fields['user_name']['type'] = "hidden";
		$fields['identification_type']['type']='select';
		$fields['identification_type']['options']=array('National ID'=>"National ID",'Passport No.'=>'Passport No.');
		$fields['identification_type']['first_option']='select one...';
		$fields['identification_type']['label']='Identification Type';


		$fields['identification_number']['label']='Identification Value';

		$fields['company_code']['label']='Affiliated Company';
		$fields['company_code']['type']='select';
		$fields['company_code']['first_option']='select one...';
		$fields['company_code']['options']=$this->companies_accounts_model->options_list('company_code','name');

		
		$fields['access_level']['label'] = 'Access Level';
		$fields['access_level']['type'] = 'select';
		$fields['access_level']['first_option']='select one...';
		$fields['access_level']['options']=$access_levels;

		$fields['department_code']['label']='Department';
		$fields['department_code']['type']='select';
		$fields['department_code']['first_option']='select one...';
		$fields['department_code']['options']=$this->companies_departments_model->options_list('department_code','name');

		unset($fields['reset_key'], $fields['salt'], $fields['last_login']);
		return $fields;
	
	}
	
		
	// --------------------------------------------------------------------
	
	/**
	 * Model hook executed right before the data is cleaned
	 *
	 * @access	public
	 * @param	array The values to be saved right the clean method is run
	 * @return	array Returns the values to be cleaned
	 */	
	public function on_before_clean($values)
	{
		$values['user_name'] = (empty($values['user_name']) && !empty($values['email'])) ? url_title($values['email'], 'dash', TRUE) : url_title($values['user_name'], 'dash');
		if (!empty($values['password']) OR !empty($values['new_password'])) 
		{
			if (empty($values['salt']))
			{
				$values['salt'] = salt();
			}
			// make sure the salt is only 32 characters long in case it was passed as a value
			$values['salt'] = substr($values['salt'], 0, 32);
			$pwd = (!empty($values['new_password'])) ? $values['new_password'] : $values['password'];
			$values['password'] = salted_password_hash($pwd, $values['salt']);
		}
		return $values;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Model hook executed right before validation is run
	 *
	 * @access	public
	 * @param	array The values to be saved right before validation
	 * @return	array Returns the values to be validated right before saving
	 */	
	public function on_before_validate($values)
	{

		$this->add_validation('email', 'valid_email', lang('error_invalid_email'));
		
		// for new 
		if (empty($values['id']))
		{
			$this->required[] = 'password';
			$this->add_validation('email', array(&$this, 'is_new_email'), lang('error_val_empty_or_already_exists', lang('form_label_email')));
			if (isset($this->normalized_save_data['confirm_password']))
			{
				$this->get_validation()->add_rule('password', 'is_equal_to', lang('error_invalid_password_match'), array($this->normalized_save_data['password'], $this->normalized_save_data['confirm_password']));
			}
		}
		
		// for editing
		else
		{
			$this->add_validation('email', array(&$this, 'is_editable_email'), lang('error_val_empty_or_already_exists', lang('form_label_email')), $values['id']);
			if (isset($this->normalized_save_data['new_password']) AND isset($this->normalized_save_data['confirm_password']))
			{
				$this->get_validation()->add_rule('password', 'is_equal_to', lang('error_invalid_password_match'), array($this->normalized_save_data['new_password'], $this->normalized_save_data['confirm_password']));
			}
		}
	//	unset($values['super_admin']); // can't save from UI as security precaution'
		return $values;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Model hook executed right before saving
	 *
	 * @access	public
	 * @param	array The values to be saved right before saving
	 * @return	array Returns the values to be saved
	 */	
	public function on_before_save($values)
	{
		$values=image_upload_rename('companies_users_model',$this->company_config['asset_upload_path_company_user_images'],$values,$this->my_fields_map,'user_name');  
		$values=upload_files($this->my_fields_map,$this->company_config['asset_upload_path_company_user_images'],$values);

		if( isset($values['super_admin']) && $values['super_admin']==='yes')
		{
			$values['access_level']=null;
			$values['department_code']=null;			
		}

		return $values;
	}
	

	// --------------------------------------------------------------------
	
	/**
	 * Model hook executed right after saving
	 *
	 * @access	public
	 * @param	array The values that were just saved
	 * @return	array Returns the values that were saved
	 */	

/*	public function on_after_insert($values)
	{
		on_after_insert($values)
	}*/

	
	public function on_after_save($values)
	{
		parent::on_after_save($values);	
		return $values;
	}
	public function on_after_update($values)
	{
		parent::on_after_update($values);	
		return $values;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Overwrites parent model so as you won't accidentally delete the super admin user
	 *
	 * @access	public
	 * @param	mixed The where condition to be applied to the delete (e.g. array('user_name' => 'darth'))
	 * @return	void
	 */	
	public function delete($where)
	{
		//prevent the deletion of the super admins
		$where['super_admin'] = 'no';
		return parent::delete($where);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Validation callback to check if a new user's email already exists
	 *
	 * @access	public
	 * @param	string The email address
	 * @return	boolean
	 */	
	public function is_new_email($email)
	{
		return $this->is_new($email, 'email');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Validation callback to check if an existing user's email address doen't already exist in the system
	 *
	 * @access	public
	 * @param	string The email address
	 * @param	string The email address
	 * @return	boolean
	 */	
	public function is_editable_email($email, $id)
	{
		return $this->is_editable($email, 'email', $id);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Overwritten: used to clear out parent base_module_model common query
	 *
	 * @access	public
	 * @param mixed parameter to pass to common query (optional)
	 * @return	void
	 */	
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*,CONCAT(first_name, " ", last_name) as names',FALSE); 
	}

}