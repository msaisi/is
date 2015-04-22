<?php
class Admin_auth extends MY_Controller 
{	
	public $company_config=array();
    public function __construct() 
	{			
		parent::__construct(); 
		$this->company_config = $this->fuel->companies->config();
	}
   public function signout()
	{		
	    $this->companies_users_auth->logout();	    
		redirect(base_url()."insurer/signin", 'refresh');
		exit;
	}
	public function login()
	{
		$this->companies_users_auth->logout();
		$this->companies_users_auth->login($this->input->get_post('username'),$this->input->get_post('password'));

		$user=isset($this->companies_users_auth->valid_user()['email'])?$this->companies_users_auth->valid_user()['email']:NULL;
		if($user==NULL)
		{
			$msg="Authentication Failed. Please confirm the Username and Password you provided are correct and try again.";
			$flash_data=array('type'=>'danger','message'=>$msg);
			$this->session->set_flashdata('admin_login_item',$flash_data);
			redirect($this->input->get_post('cur_page'),'refresh');			
		}
		else
		{	
			redirect('insurer/dashboard');
		}
		
	}
	public function unlock()
	{
		$ret=$this->companies_users_auth->unlock($this->input->get_post('username'),$this->input->get_post('password'));
		if($ret==false)
		{
			$msg="Authentication Failed. Please confirm the Password you provided is correct and try again if this is your account.";
			$flash_data=array('type'=>'danger','message'=>$msg);
			$this->session->set_flashdata('admin_unlock_item',$flash_data);
			redirect($this->input->get_post('cur_page'),'refresh');			
		}
		else
		{	
			redirect('insurer/dashboard');
		}		
	}
	/*
	public function recover_password()
	{
		$email=trim($this->security->xss_clean($this->input->post('email',TRUE)));
		$pass=trim($this->security->xss_clean($this->input->post('pass',TRUE)));
		$accounttype=(int)$this->security->xss_clean($this->input->post('accounttype',TRUE));		
		$cur_page=trim($this->security->xss_clean($this->input->post('cur_page',TRUE)));

		if($accounttype==1)
		{
			$model="icsp_customers_model";
			$auth_model="icsp_customers_auth_model";	
			$lang='auth_customer_log_login_success';		
		}
		else
		{
			$model="icsp_agents_brokers_model";
			$auth_model="icsp_agents_brokers_auth_model";	
			$lang='auth_agent_broker_log_reset_success';	
		}

		$user = $this->$model->user_exists($email);

		if(!$user)
		{
			$msg="Sorry, could not reset your password as requested. Please confirm the Email and Account type details you provided are correct and try again.";
			$flash_data=array('type'=>'danger','message'=>$msg,'email'=>$email,'accounttype'=>$accounttype,'link'=>'recover_link'); 
			$this->session->set_flashdata('reset_item',$flash_data);
			redirect($cur_page);
		}
		else
		{	
			$filter= array('email'=>$email);
			$res=$this->$model->find_one_array($filter);
			$partnernumber = $res['partnernumber'];
			$names = ucwords($res['name']);

		    $pwd=strtoupper(gen_unique_id(6));

			$params['to'] = $email;
			$params['subject'] = lang('edit_client_email_subject');
			$params['message'] = "Dear $names,<br/>".lang('edit_client_email', site_url(), $email, $pwd);
			$params['use_dev_mode'] = FALSE;
			$params['from_name']=$this->email_nicename;

			if (!$this->fuel->notification->send($params))
			{
				$this->fuel->logs->write($this->fuel->notification->last_error(), 'debug');
				//add_error(lang('edit_client_pass', $email));
				$msg="Sorry, we could not complete the requested action at the moment. Our email server is not responding. Please try again later!";
				$flash_data=array('type'=>'danger','message'=>$msg,'email'=>$email,'accounttype'=>$accounttype,'link'=>'recover_link'); 
			}
			else
			{
				 $flash_data=$this->reset($email,$partnernumber,$pwd,$auth_model,$lang);
			}
			$this->session->set_flashdata('reset_item',$flash_data);
			redirect($cur_page);
		}
	}
	public function reset($email,$partnernumber,$pwd,$auth_model,$lang){
		    $salt = salt();
			$updated_user_profile = array('password' => salted_password_hash($pwd, $salt), 'salt' => $salt);
			$updated_where = array('partnernumber' => $partnernumber);
			if ($this->CI->$auth_model->update($updated_user_profile, $updated_where))
			{
				$this->CI->fuel->logs->write(lang($lang,$email, $this->CI->input->ip_address()), 'debug');
				$msg="Congratulations, your account password was successfuly reset and an email notification sent to your email address. Please check it to get your new credentials.";
				$flash_data=array('type'=>'success','message'=>$msg,'email'=>null,'accounttype'=>null,'link'=>'recover_link'); 
			}
			else
			{
				$msg="Sorry, we could not reset your account pasword at this time. Please try again later or contact admin.";
				$flash_data=array('type'=>'danger','message'=>$msg,'email'=>$email,'accounttype'=>$accounttype,'link'=>'recover_link'); 
			}
			return $flash_data;
	}
	public function activate()
	{
		$email=trim($this->security->xss_clean($this->input->post('email',TRUE)));
		$names=ucwords(trim($this->security->xss_clean($this->input->post('names',TRUE))));
		$accounttype=(int)$this->security->xss_clean($this->input->post('accounttype',TRUE));		
		$cur_page=trim($this->security->xss_clean($this->input->post('cur_page',TRUE)));

		$params['to'] = $email;
		$params['subject'] = lang('activate_client_email_subject');
		$params['message'] = "Dear $names,<br/>".lang('activate_client_email');
		$params['use_dev_mode'] = FALSE;
		$params['from_name']=$this->email_nicename;

		if (!$this->fuel->notification->send($params))
		{
			$old_data=$_POST;
			$this->fuel->logs->write($this->fuel->notification->last_error(), 'debug');
			$msg="Sorry, we could not complete the requested action at the moment. Our email server is not responding. Please try again later!";
			$old_data['message']=$msg;
			$old_data['type']='danger';
			$flash_data=$old_data; 
		}
		else
		{
			 $flash_data=$this->activate_request();
		}
		$this->session->set_flashdata('activate_item',$flash_data);
		redirect($cur_page);
		
	}
	public function activate_request()
	{
	   $old_data=$_POST;
       $_POST[$_POST['activate_using']]=$_POST['activation_value'];
	   $vals=$this->icsp_user_reg_model->on_before_clean($_POST);
	   $vals=$this->icsp_user_reg_model->clean($vals);
	   $vals=$this->icsp_user_reg_model->cleaned_data();

	   $names=$vals['names'];

	 	if ($this->icsp_user_reg_model->save($vals, TRUE, TRUE))
		{
			$msg="Congratulations $names, your request was successfuly submitted and an email notification sent to your email address. Please check it for further instructions.";
			$old_data=null_values($old_data);
			$old_data['type']='success';
			$old_data['message']=$msg;
		}
		else
		{
			$msg="Sorry, we could not submit your request at this time. Please try again later or contact admin.";

			$old_data['message']=$msg;
			$old_data['type']='danger';
		}

		$old_data['link']='reg_link';
		return $old_data;
	}
*/	
}