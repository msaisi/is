<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

class Icsp_customers_auth extends Fuel_base_library {
	
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
		$valid_user = $this->CI->icsp_customers_model->valid_user(trim($user), trim($pwd));

		if (!empty($valid_user)) 
		{
			// update the hashed password & add a salt
			$salt = salt();
			$updated_user_profile = array('password' => salted_password_hash($pwd, $salt), 'salt' => $salt, 'last_login' => datetime_now());
			$updated_where = array('partnernumber' => decrypt($valid_user['partnernumber']), 'is_active' => 'yes');
			$email=decrypt($valid_user['email']);
			// update salt on login
			if ($this->CI->icsp_customers_auth_model->update($updated_user_profile, $updated_where))
			{
				$this->set_valid_user($valid_user);
				$this->CI->fuel->logs->write(lang('auth_customer_log_login_success',$email, $this->CI->input->ip_address()), 'debug');
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
	 * Returns either an array of the logged in clients session data or a single value of the data if a $key parameter is passed
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
		$key = 'icsp_customer_'.md5(FCPATH); // unique to the site installation
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
	 * Returns whether the browsers clients remote address matches 
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
	 * Returns the currently logged in clients language preference
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
		$ui_cookie_name = 'icsp_customer_ui_'.str_replace('icsp_customer_', '', $this->get_fuel_trigger_cookie_name());
		$config = array(
			'name' => $ui_cookie_name,
			'path' => WEB_PATH
		);
		delete_cookie($config);

		
	}
	
}
/* End of file Fuel_auth.php */
/* Location: ./modules/fuel/libraries/fuel/Fuel_auth.php */