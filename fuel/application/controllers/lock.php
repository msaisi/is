<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Lock extends MY_Controller 
{	
    public function __construct() 
	{			
		parent::__construct(); 
		$this->company_config = $this->fuel->companies->config();
	}
	public function index()
	{
		$is_locked=$this->session->userdata('is_locked');
		
		if(!$is_locked)
		{
			$this->session->set_userdata(array('is_locked'=>true));
		}
		redirect('insurer/lock','refresh');	
	}
}