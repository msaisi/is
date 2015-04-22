<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */
class  MY_Controller  extends  CI_Controller 
{
	public $CI;
	public $company_config=array();
	function __construct() 
	{
		parent::__construct();	
		$this->CI =& get_instance();	
		$this->company_config = $this->CI->fuel->companies->config();
	}

	function get_logged_in_user() 
	{		
		$user=$this->CI->companies_users_auth->valid_user();
		if(empty($user['email'])) 
		{
			$user=$this->CI->icsp_agents_brokers_auth->valid_user();
		}

		if(empty($user['email'])) 
		{
			$user['name']=encrypt('Guest');
		}
		return $user;
	}
	
	function is_logged_in() 
	{
		$d_c_is_logged_in = $this->icsp_customers_auth->is_logged_in();
		$i_is_logged_in = $this->icsp_agents_brokers_auth->is_logged_in();

		if($d_c_is_logged_in!=true && $i_is_logged_in!=true)
		{
		 redirect('', 'refresh');
		 exit();
		} 
	}
	function is_admin_logged_in() 
	{
		$admin_is_logged_in = $this->CI->companies_users_auth->is_logged_in();
		if($admin_is_logged_in!=true)
		{		        
			redirect(base_url()."insurer/signin", 'refresh');
			exit;
		} 
	}
}