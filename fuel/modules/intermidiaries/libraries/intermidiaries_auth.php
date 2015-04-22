<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

class Icsp_agents_brokers_auth extends Fuel_base_library {
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor
	 *
	 * Accepts an associative array as input, containing preferences (optional)
	 *
	 * @access	public
	 * @param	array	config preferences
	 * @return	void
	 */	
	public function __construct($params = array())
	{
		parent::__construct($params);

		$this->CI->load->helper('cookie');
		
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Logs a user into the CMS
	 *
	 * @access	public
	 * @param	string	User name
	 * @param	string	Password
	 * @return	boolean
	 */	
	public function login($user, $pwd)
	{
		$valid_user = $this->CI->icsp_agents_brokers_model->valid_user(trim($user), trim($pwd));
		
		if (!empty($valid_user)) 
		{
			// update the hashed password & add a salt
			$salt = salt();
			$updated_user_profile = array('password' => salted_password_hash($pwd, $salt), 'salt' => $salt, 'last_login' => datetime_now());
			$updated_where = array('partnernumber' => decrypt($valid_user['partnernumber']), 'is_active' => 'yes');
			$email=decrypt($valid_user['email']);
			// update salt on login
			if ($this->CI->icsp_agents_brokers_auth_model->update($updated_user_profile, $updated_where))
			{
				$this->set_valid_user($valid_user);
				$this->CI->fuel->logs->write(lang('auth_agent_broker_log_login_success',$email, $this->CI->input->ip_address()), 'debug');
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}

		return FALSE;	
	}

	
	// --------------------------------------------------------------------
	
	/**
	 * Sets the valid user to the session (used by login method as well)
	 *
	 * @access	public
	 * @param	array	User data to save to the session
	 * @return	void
	 */	
	public function set_valid_user($valid_user)
	{
		$this->CI->load->library('session');
		$this->CI->session->set_userdata($this->get_session_namespace(), $valid_user);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Returns an array of user information for the current logged in user
	 *
	 * @access	public
	 * @return	array
	 */	
	public function valid_user()
	{
		if (!isset($this->CI->session))
		{
			$this->CI->load->library('session');
		}
		return ($this->CI->session->userdata($this->get_session_namespace())) ? $this->CI->session->userdata($this->get_session_namespace()) : NULL;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Sets session data for the currently logged in user
	 *
	 * @access	public
	 * @access	string	The array key to associate the session data
	 * @access	mixed	The session data to save
	 * @return	void
	 */	
	public function set_user_data($key, $value)
	{
		$session_key = $this->get_session_namespace();
		$user_data = $this->user_data();
		$user_data[$key] = $value;
	
		if (!isset($this->CI->session))
		{
			$this->CI->load->library('session');
		}
		$this->CI->session->set_userdata($session_key, $user_data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns either an array of the logged in users session data or a single value of the data if a $key parameter is passed
	 *
	 * @access	public
	 * @param	string	The session key value you want access to (optional)
	 * @return	mixed
	 */	
	public function user_data($key = NULL)
	{
		$valid_user = $this->valid_user();
		
		if (!empty($valid_user))
		{
			if (!empty($key))
			{
				if (isset($valid_user[$key]))
				{
					return $valid_user[$key];	
				}
				else
				{
					return FALSE;
				}				
			}
			return $valid_user;
		}
		return FALSE;
	}
	// --------------------------------------------------------------------
	
	/**
	 * Returns the sessions namespace which helps distinguish it from other FUEL installs (it's based on the site_name config parameter)
	 *
	 * @access	public
	 * @return	string
	 */	
	public function get_session_namespace()
	{
		$key = 'icsp_agent_broker_'.md5(FCPATH); // unique to the site installation
		if (isset($this->CI->session))
		{
			if (!$this->CI->session->userdata($key))
			{
				// initialize it
				$this->CI->session->set_userdata($key, array('id' => 0));
			}
		}
		return $key;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns the cookie name used on the front end to trigger the inline editing toolbar
	 *
	 * @access	public
	 * @return	string
	 */	
	public function get_fuel_trigger_cookie_name()
	{
		return $this->get_session_namespace();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Checks the FUEL configuration for any IP restrictions
	 *
	 * @access	public
	 * @return	boolean
	 */	
	public function can_access()
	{
		$restrict_ip = $this->fuel->config('restrict_to_remote_ip');
		return ($this->fuel->config('admin_enabled') AND 
					(empty($restrict_ip) OR (!empty($restrict_ip) AND $this->check_valid_ip($restrict_ip)))
				);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Returns whether the browsers users remote address matches 
	 *
	 * @access	public
	 * @param	mixed a single IP address, an array of IP addresses or the starting IP address range
	 * @return	boolean
	 */
	public function check_valid_ip($ips)
	{
		if (empty($ips))
		{
			return FALSE;
		}
		
		$check_address = $_SERVER['REMOTE_ADDR'];

		// check if IP address is range
		if (is_string($ips))
		{
			$ips = preg_split('#\s*,\s*#', $ips);
		}

		foreach($ips as $ip)
		{
			$range_arr = preg_split('#\s*-\s*#', trim($ip));
			$range_start = $range_arr[0];
			$range_end = (isset($range_arr[1])) ? $range_arr[1] : '';

			if (!empty($range_end))
			{
				$range_start = ip2long($range_start);
				$range_end   = ip2long($range_end);
				$ip = ip2long($check_address);
				if ($ip >= $range_start && $ip <= $range_end)
				{
					return TRUE;
				}
			}
			// do a regex match
			else if (preg_match('#'.$range_start.'#', $check_address))
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Checks if the current user is logged in
	 *
	 * @access	public
	 * @return	boolean
	 */	
	public function is_logged_in()
	{
		
		$user = $this->valid_user();
		return (!empty($user) AND !empty($user['email']));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Checks the users permissions for a particular permission
	 *
	 * @access	public
	 * @param	string	The name of the permission (usually the module's name)
	 * @param	string	The type of permission (e.g. 'edit', 'delete'). A user that just has the permission (e.g. my_module) without the type (e.g. my_module_edit) will be given access (optional)
	 * @return	boolean
	 */	
	public function has_permission($permission, $type = '')
	{


		/*print_r($permission);
		echo "<br>";*/

	//	if ($this->is_super_admin()) return TRUE; // super admin's control anything

		$this->CI->load->library('session');
		if (($permission == 'users') AND ($this->CI->uri->segment(3) == 'login_as')
			AND $this->CI->session->userdata('original_admin_user_id') AND $this->CI->session->userdata('original_admin_user_hash')
			AND ($this->CI->session->userdata('original_admin_user_hash') == $this->CI->uri->segment(5))
			) {
			return TRUE;
		}
		// get the users permissions
		$user_perms = $this->get_permissions();
		//print_r($user_perms); die;

		if (!empty($user_perms))
		{
			if (is_array($permission))
			{
				$foreign_module = NULL;
				if (($permission[0] != $this->CI->module) AND in_array($permission[0], array_keys($this->CI->fuel->modules->get()))) {
					$foreign_module = $permission[0];
				}
				foreach($permission as $key => $val)
				{
					if (is_int($key) && !empty($this->CI->module))
					{
						if ($foreign_module)
						{
							// set the correct permission for foreign modules
							$permission[$val] = ($foreign_module == $val) ? $val : $foreign_module.'/'.$val;
						}
						else if ($val != $this->CI->module)
						{
							$permission[$val] = $this->CI->module.'/'.$val;
						}
						else
						{
							$permission[$val] = $val;
							if (empty($type))
							{
								$type = $val;
							}
						}
						unset($permission[$key]);
					}
				}
				
				if (!empty($permission[$type]))
				{
					$permission = $permission[$type];
				}
				else if (empty($type))
				{
					$permission = reset($permission);
				}
				else
				{
					$permission = NULL;
				}
			}

			return (!empty($permission) AND !empty($user_perms[$permission]));
		}
		return FALSE;
	}
	

	// --------------------------------------------------------------------
	
	/**
	 * Determines if a user can access a certain module
	 *
	 * @access	public
	 * @param	string	The name of the module
	 * @return	boolean
	 */	
	public function accessible_module($module)
	{
		$this->CI->load->module_config('fuel', 'fuel', TRUE);
		$allowed = (array) $this->CI->config->item('modules_allowed', 'fuel');
		return in_array($module, $allowed);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Returns an array of permissions values for the currently logged in user
	 *
	 * @access	public
	 * @return	array
	 */	
	public function get_permissions()
	{
		$valid_user = $this->valid_user();

		if (empty($valid_user['id'])) return FALSE;
		
		// get the users permissions
		if (!empty($this->_user_perms))
		{
			return $this->_user_perms;
		}
		$CI =& get_instance();
		$where = array('id' => $valid_user['id'], 'active' => 'yes');
		$user = $CI->waltike_users_model->find_one($where);

		if (!isset($user->id))
		{
			return NULL;
		}		

		$this->_user_perms  = $CI->waltike_users_model->get_permissions($user->id);		

		if (!empty($this->_user_perms))
		{
			return $this->_user_perms;
		}
		return NULL;
	}
	

	// --------------------------------------------------------------------
	
	/**
	 * Checks that a module has a specific type of action (e.g. edit, delete)
	 *
	 * @access	public
	 * @param	string	The name of the action
	 * @return	boolean
	 */	
	public function module_has_action($action)
	{
		if (empty($this->CI->item_actions)) return FALSE;
		return (isset($this->CI->item_actions[$action]) OR in_array($action, $this->CI->item_actions));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Determines if a user is logged in and can make inline editing changes
	 *
	 * @access	public
	 * @return	boolean
	 */	
	public function is_fuelified()
	{
		// cache it in a static variable so we don't make multiple cookie requests
		static $is_fuelified;
		if (is_null($is_fuelified))
		{
			$is_fuelified = get_cookie($this->get_fuel_trigger_cookie_name());
		}
		return $is_fuelified;
	}
	

	// --------------------------------------------------------------------
	
	/**
	 * Returns the currently logged in users language preference
	 *
	 * @access	public
	 * @return	string
	 */	
	public function user_lang()
	{
		static $user_lang;
		if (is_null($user_lang))
		{
			$default_lang = $this->CI->config->item('language');
			$cookie_val = get_cookie($this->get_fuel_trigger_cookie_name());
			if (is_string($cookie_val))
			{
				$cookie_val = unserialize($cookie_val);
				if (empty($cookie_val['language']) OR !is_string($cookie_val['language']))
				{
					$cookie_val['language'] = $default_lang;
				}
				$user_lang = $cookie_val['language'];
			}
			else
			{
				$user_lang = $default_lang;
			}
		}
		return $user_lang;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Logs a user out of the CMS
	 *
	 * @access	public
	 * @return	void
	 */	
	public function logout()
	{
		$this->CI->load->library('session');
		$this->CI->session->unset_userdata($this->get_session_namespace());
		//$this->CI->session->sess_destroy();
		
		$config = array(
			'name' => $this->get_fuel_trigger_cookie_name(),
			'path' => WEB_PATH
		);
		delete_cookie($config);

		// remove UI cookie
		$ui_cookie_name = 'icsp_agent_broker_ui_'.str_replace('icsp_agent_broker_', '', $this->get_fuel_trigger_cookie_name());
		$config = array(
			'name' => $ui_cookie_name,
			'path' => WEB_PATH
		);
		delete_cookie($config);

		
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * The left menu navigation array
	 *
	 * @access	public
	 * @return	array
	 */	
	public function nav()
	{
		$nav = $this->fuel->config('nav');
		

		$nav_orig = $nav;
		
		$modules = array('fuel');
		$modules = array_merge($modules, $this->fuel->config('modules_allowed'));

		@include(APPPATH.'config/MY_fuel_modules.php');
		
		foreach($modules as $module)
		{
			$nav_path = MODULES_PATH.$module.'/config/'.$module.'.php';
			if (file_exists($nav_path))
			{
				include($nav_path);
				
				if (array_key_exists('module_overwrites', $config) AND ! empty($config['module_overwrites']))
				{
					foreach ($config['nav'] as $section => $fuel_modules)
					{
						if (is_array($fuel_modules) AND ! empty($fuel_modules))
						{
							foreach ($fuel_modules as $fuel_module => $fuel_module_title)
							{
								if (array_key_exists($fuel_module, $config['module_overwrites'])
											AND 
											((array_key_exists('hidden', $config['module_overwrites'][$fuel_module]) AND 
												($config['module_overwrites'][$fuel_module]['hidden']))
											OR 
											(array_key_exists('disabled', $config['module_overwrites'][$fuel_module]) AND 
												($config['module_overwrites'][$fuel_module]['disabled']))

											))
								{
									unset($config['nav'][$section][$fuel_module]);
								}
							}
						}
					}
				}

				$nav = array_merge($nav, $config['nav']);
			}
		}

		
		// automatically include modules if set to blank array
		if (isset($nav_orig['modules']) AND $nav_orig['modules'] === array())
		{
			if (!empty($config['modules']))
			{
				foreach($config['modules'] as $key => $module)
				{
					if ((isset($module['hidden']) AND $module['hidden'] === TRUE) OR (isset($module['disabled']) AND $module['disabled'] === TRUE))
					{
						continue;
					}
					
					if (!empty($module['module_name']))
					{
						$nav['modules'][$key] = $module['module_name'];
					}
					else
					{
						$nav['modules'][$key] = humanize($key);
					}
				}
			}
		}

		if ($this->fuel->config('nav_auto_arrange'))
		{
			// rearrange
			$orig_nav = $nav;
			unset($nav['site'], $nav['tools'], $nav['manage'], $nav['modules']);

			$arranged_nav = array();
			$arranged_nav['site'] = $orig_nav['site'];
			foreach($nav as $key => $val)
			{
				$arranged_nav[$key] = $val;
			}
			$arranged_nav['modules'] = $orig_nav['modules'];
			$arranged_nav['tools'] = $orig_nav['tools'];
			$arranged_nav['manage'] = $orig_nav['manage'];

			unset($arranged_nav['site']);
			return $arranged_nav;
		}
		else
		{
			return $nav;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Returns the selected navigation
	 *
	 * @access	public
	 * @return	string
	 */	
	public function nav_selected()
	{
		if (empty($this->CI->nav_selected))
		{
			if (fuel_uri_segment(1) == '')
			{
				$nav_selected = 'dashboard';
			}
			else
			{
				$nav_selected = fuel_uri_segment(1);
			}
		}
		else
		{
			$nav_selected = $this->CI->nav_selected;
		}
		
		// Convert wild-cards to RegEx
		$nav_selected = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $nav_selected));
		
		$this->CI->load->vars(array('nav_selected' => $nav_selected));
		return $nav_selected;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Sets the selected navigation
	 *
	 * @access	public
	 * @param	string	The name of the selected nav item
	 * @return	void
	 */	
	public function set_nav_selected($selected)
	{
		$this->CI->nav_selected = $selected;
	}
}
/* End of file Fuel_auth.php */
/* Location: ./modules/fuel/libraries/fuel/Fuel_auth.php */