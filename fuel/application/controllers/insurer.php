<?php
require_once(MODULES_PATH.'companies/libraries/companies_base_controller.php');
class Insurer extends Companies_base_controller {	

	public $user_data=array();
	public $email_nicename=null;

	public function __construct() 
	{			
		parent::__construct(); 
		$this->is_admin_logged_in();

		if(strtolower(uri_segment(2))==="lock")
		{	
			$this->session->set_userdata(array('is_locked'=>true));
		}
		else
		{
			$this->check_lock();
		}

		$this->user_data=get_logged_in_admin();
		$this->vars['first_name']=$this->user_data['first_name'];
		$this->vars['last_name']=$this->user_data['last_name'];
		$this->vars['names']=$this->user_data['names'];		
		$this->vars['email']=$this->user_data['email'];
		$this->vars['contacts']=$this->user_data['contacts'];
		$this->vars['company_code']=$this->user_data['company_code'];
		$this->vars['access_level']=$this->user_data['access_level'];
		$this->vars['department_code']=$this->user_data['department_code'];
		$this->vars['last_login']=$this->user_data['last_login'];	
		$this->vars['meta_description'] = encrypt('desctiption here...');   
		$this->vars['meta_keywords'] = encrypt('key words here...');
		$this->company_config = $this->fuel->companies->config();
		$this->vars['asset_path'] ="assets/".$this->company_config['asset_upload_path_company_user_images'];
		$this->vars['user_photo']=$this->companies_users_model->find_one_array(array('email'=>decrypt($this->vars['email'])))['profile_image'];
		$this->create_crumps(strtolower($this->uri->uri_string()));
	}	
	public function check_lock()
	{
		$is_locked=$this->session->userdata('is_locked');		
		if($is_locked)
		{
			redirect('insurer/lock','refresh');	
		}
	}
	public function dashboard()
	{
		$this->vars['page_title'] = 'Insurer : Dashboard'; 
		$output = $this->_render('insurer/dashboard', $this->vars, TRUE,'_layouts/admin_layout');
		$this->output->set_output($output);
	}
	public function lock()
	{
		$this->vars['page_title'] = 'Insurer : Lock Screen'; 
		$output = $this->_render('insurer/lock', $this->vars, TRUE,'_layouts/admin_layout');
		$this->output->set_output($output);
	}
	public function search()
	{
		$search_value=trim($this->security->xss_clean($this->input->post('search_value',TRUE)));
		$search_using=trim($this->security->xss_clean($this->input->post('search_using',TRUE)));
		$accounttype=(int)$this->security->xss_clean($this->input->post('accounttype',TRUE));
		$filter=array('accounttype'=>$accounttype, 'search_using'=>$search_using, 'search_value'=>$search_value);	
		$encoded_data=array('search_array'=>json_encode($filter));
		$this->session->set_userdata($encoded_data);
		redirect('admin/search_results');
	}
	function create_crumps($str)
	{
		//echo $str;
		//die;
		$parts=array();

		if($str!=="")
		{
			$parts=explode("/", $str);
		}
		foreach($parts as $key => $val)
		{
			if($val==="insurer")
			{
				unset($parts[$key]);
			}
		}

		$parts=array_values($parts);
			
		$ctr=0;
		$icon=false;
		$icon_ass="";
		foreach($parts as $key => $val)
		{
			$ctr++;
			$active=true;
			$last=false;

			if($ctr==count($parts))
			{
				$active=false;
				$last=true;
			}
			if(trim($val)==="dashboard")
			{
				$icon=true;
				$icon_ass="fa fa-home";
			}			
			$crumps[]=array('url_link'=>"insurer/".strtolower($val),'display_name'=>ucwords($val),'active'=>$active,'last'=>$last,'crump_icon'=>$icon,'crump_ass'=>$icon_ass);
		}	
		//$this->vars['frame_main_title_sub'] = "reports & statistics";
		$this->vars['crumps'] = $crumps;
	}
	public function search_results()
	{
		/*$this->vars['page_title'] = 'ICSP : Clients'; 
		$this->vars['panel_page_title'] = 'My Clients'; 
		$this->vars['clients_list']=$this->clients_list();
		$output = $this->_render('my_clients', $this->vars, TRUE);
		$this->output->set_output($output);*/


		$a = array('name', 'partnernumber', 'c_partnernumber','email','id_number','kra_pin','branch_agent');
		$b = array('policy_no', 'claim_number', 'insured_item');

		$search_array=json_decode($this->session->userdata('search_array'));
		$fld=$search_array->search_using;
		$filter=array();
		$ret_val=array();
		$user_model="icsp_customers_model";
		$partner_fld="c_partnernumber";
		$view="results_customers";
		$heading="Customers";
		if($search_array->accounttype==2)
		{
			$user_model="icsp_agents_brokers_model";
			$partner_fld="a_partnernumber";
			$view="results_agents_brokers";
			$heading="Intermidiaries";
		}

		if (in_array($fld, $a, true)) 
		{
			if($fld!=="c_partnernumber")
			{
				$db_field=$search_array->search_using;
				$val=$search_array->search_value;
				$str="$db_field like '%{$val}%'";
			    $filter[$str]="";
			    $ret_val=$this->$user_model->find_all_array($filter);
			}
			else
			{				
			    $list_models=array('icsp_policies_model','icsp_claims_model','icsp_insured_items_model');
			    $a_part_nos=array();
			    foreach($list_models as $key=>$val)
			    {
			    	$srch_val=$search_array->search_value;
				    $str="c_partnernumber like '%{$srch_val}%'";
			    	$filter[$str]="";
			    	$ret_str=$this->$val->find_all_array($filter);

			    	foreach($ret_str as $item)
			    	{
			    	  $a_part_nos[$item['a_partnernumber']]=$item['a_partnernumber'];
			    	}
			    }

			    foreach($a_part_nos as $a_no)
			    {
			    	$filter=array('partnernumber'=>$a_no);
				    $ret_val[]=$this->$user_model->find_one_array($filter);
			    }
			}
		}
		if (in_array($fld, $b, true)) 
		{
		   // echo "$fld";			
			$val=$search_array->search_value;
			if($fld==="policy_no")
			{
				$model="icsp_policies_model";
				$val=remove_slashes($val);
			}
			if($fld==="claim_number")
			{
				$model="icsp_claims_model";
				$val=remove_slashes($val);
			}
			if($fld==="insured_item")
			{
				$model="icsp_insured_items_model";
			}
			$db_field=$search_array->search_using;
			$str="$db_field like '%{$val}%'";
		    $filter[$str]="";
		    $user_list=$this->$model->find_all_array($filter);
		    foreach($user_list as $row)
		    {
		    	$filter=array('partnernumber'=>$row[$partner_fld]);
			    $ret_val[$row[$partner_fld]]=$this->$user_model->find_one_array($filter);
		    }
		}

		$results=array();
		foreach($ret_val as $row)
		{
			array_push($results, $row['partnernumber']);
		}

		$encoded_data=array('search_results'=>json_encode($results));
		$this->session->set_userdata($encoded_data);


		$this->vars['page_title'] = 'ICSP Admin : '.$heading.' Search Results'; 
		$this->vars['panel_page_title'] = $heading.' Search Results'; 
		$this->vars['search_array']=$search_array;
		//$this->vars['results']=$encoded_data;
		$output = $this->_render('admin/'.$view, $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
//====================================================================================================================//
	public function general_classes()
	{
		$this->vars['page_title'] = 'ICSP Admin : General Classes'; 
		$this->vars['panel_page_title'] = 'General Classes'; 
		$output = $this->_render('admin/general_classes', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function policy_classes()
	{
		$this->vars['page_title'] = 'ICSP Admin : Policy Classes'; 
		$this->vars['panel_page_title'] = 'Policy Classes'; 
		$output = $this->_render('admin/classes', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function branches()
	{
		$this->vars['page_title'] = 'ICSP Admin : Branches'; 
		$this->vars['panel_page_title'] = 'Branches'; 
		$output = $this->_render('admin/branches', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function agents_brokers()
	{
		$this->vars['page_title'] = 'ICSP Admin : Agents/ Brokers'; 
		$this->vars['panel_page_title'] = 'Agents/ Brokers'; 
		$tbl="agents_brokers";
	//	$this->vars['numbers_list']=$this->get_list_items($tbl,'partnernumber');
		//$this->vars['names_list']=$this->get_list_items($tbl,'name');
		//$this->vars['email_list']=$this->get_list_items($tbl,'email');
		$output = $this->_render('admin/agents_brokers', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function customers()
	{
		$this->vars['page_title'] = 'ICSP Admin : Customers'; 
		$this->vars['panel_page_title'] = 'Customers';
		$tbl="customers";
		//$this->vars['numbers_list']=$this->get_list_items($tbl,'partnernumber');
		//$this->vars['names_list']=$this->get_list_items($tbl,'name');
		//$this->vars['email_list']=format_email($this->get_list_items($tbl,'email'));
		$output = $this->_render('admin/customers', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function policies()
	{
		$this->vars['page_title'] = 'ICSP Admin : Policies'; 
		$this->vars['panel_page_title'] = 'Policies'; 
		$output = $this->_render('admin/policies', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function claims()
	{
		$this->vars['page_title'] = 'ICSP Admin : Claims'; 
		$this->vars['panel_page_title'] = 'Claims'; 
		$output = $this->_render('admin/claims', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function claims_tracking()
	{
		$this->vars['page_title'] = 'ICSP Admin : Claims Tracking'; 
		$this->vars['panel_page_title'] = 'Claims Tracking'; 
		$output = $this->_render('admin/claims_tracking', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function claims_changes()
	{
		$this->vars['page_title'] = 'ICSP Admin : Claims Changes'; 
		$this->vars['panel_page_title'] = 'Claims that moved from Motor/ Non-motor to Legal'; 
		$output = $this->_render('admin/claims_changes', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function turn_around_times()
	{
		$this->vars['page_title'] = 'ICSP Admin : Turn Around Times'; 
		$this->vars['panel_page_title'] = 'Claims Turn Around Times'; 
		$output = $this->_render('admin/turn_around_times', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}	
	public function claims_stages()
	{
		$this->vars['page_title'] = 'ICSP Admin : Claims at Different Stages'; 
		$this->vars['panel_page_title'] = 'Claims at Different Stages'; 
		$output = $this->_render('admin/claims_stages', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function active_clients()
	{
		$this->vars['page_title'] = 'ICSP Admin : Active Clients'; 
		$this->vars['panel_page_title'] = 'Active Clients'; 
		$output = $this->_render('admin/active_clients', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function activate_clients()
	{
		$this->vars['page_title'] = 'ICSP Admin : Activate Clients'; 
		$this->vars['panel_page_title'] = 'Activate Clients'; 
		$output = $this->_render('admin/activate_clients', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function signatures()
	{
		$this->vars['page_title'] = 'ICSP Admin : Email Notification Signatures'; 
		$this->vars['panel_page_title'] = 'Email Notification Signatures'; 
		$output = $this->_render('admin/signatures', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function handlers()
	{
		$this->vars['page_title'] = 'ICSP Admin : Claim Handlers'; 
		$this->vars['panel_page_title'] = 'Claim Handlers'; 
		$output = $this->_render('admin/handlers', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function notifications()
	{
		$this->vars['page_title'] = 'ICSP Admin : Notification Messages'; 
		$this->vars['panel_page_title'] = 'Notification Messages'; 

		$cats= $this->icsp_claim_categories_model->options_list('id','category',array());

		$this->vars['categories'] = $cats; 
		$this->vars['category'] = $this->session->userdata('touch_type')?$this->session->userdata('touch_type'):"";

		$output = $this->_render('admin/notifications', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}

	public function chat()
	{
		echo "link to chat here...";
	}
	public function survey_tq()
	{
		$this->vars['page_title'] = 'ICSP Admin : Survey Templates & Questions'; 
		$this->vars['panel_page_title'] = 'Survey Templates & Questions'; 
		$output = $this->_render('admin/survey_tq', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function survey_settings()
	{
		$this->vars['page_title'] = 'ICSP Admin : Survey Settings'; 
		$this->vars['panel_page_title'] = 'Survey Settings'; 
		$output = $this->_render('admin/survey_settings', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function load($page)
	{
		$par=$_SERVER['QUERY_STRING'];
		$control_string=$page.my_ext($par);
		$tittle=create_headers($control_string);

		$this->vars['page_q_string'] = $par!==""?"?".$par:""; 
		$this->vars['view_page'] = $page; 
		$this->vars['page_title'] = 'ICSP Admin : '.$tittle; 
		$this->vars['panel_page_title'] = $tittle; 
		$output = $this->_render('admin/load', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}

	public function add_edit_handlers($id="")
	{
		$data['id']=$id;
		$data['my_arr']= array();
		if(!empty($id))
		{
			$filter=array('id'=>$id);
			$data['my_arr']=$this->icsp_claim_handlers_model->find_one_array($filter);;
		}
		$this->load->view('pages/handlers_form',$data);
	}
	public function add_edit_touchpoint($id="")
	{
		$data['id']=$id;
		$data['my_arr']= array();
		if(!empty($id))
		{
			$filter=array('id'=>$id);
			$data['my_arr']=$this->icsp_touchpoints_model->find_one_array($filter);
		}
		$this->load->view('pages/touchpoint_form',$data);
	}



	public function save_handler($id="")
	{
	   $old_data=$_POST;
       $_POST['name']=$_POST['names'];

	   $vals=$this->icsp_claim_handlers_model->clean($_POST);
	   $vals=$this->icsp_claim_handlers_model->cleaned_data();

	   if($id==="")
	   {
	   		$this->icsp_claim_handlers_model->save($vals, TRUE, TRUE);
	   }
	   else
	   {
	   		$where=array('id'=>$id);
	   		$this->icsp_claim_handlers_model->update($vals, $where);
	   }	   
	   redirect('admin/handlers');
	}
	public function save_touchpoint($id="")
	{
       $_POST['category']= $this->session->userdata('touch_type');

	   $vals=$this->icsp_touchpoints_model->clean($_POST);
	   $vals=$this->icsp_touchpoints_model->cleaned_data();

	   if($id==="")
	   {
	   		$this->icsp_touchpoints_model->save($vals, TRUE, TRUE);
	   }
	   else
	   {
	   		$where=array('id'=>$id);
	   		$this->icsp_touchpoints_model->update($vals, $where);
	   }	   
	   redirect('admin/notifications');
	}
	public function delete_handler($id)
	{
   		$where=array('id'=>$id);
   		$this->icsp_claim_handlers_model->delete($where);	   		
	    redirect('admin/handlers');
	}
	public function delete_touchpoint($id)
	{
   		$where=array('id'=>$id);
   		$this->icsp_touchpoints_model->delete($where);	   		
	    redirect('admin/notifications');
	}
//===============================================================================================================
public function agent_broker_details($id)
	{
		$this->vars['page_title'] = 'ICSP Admin : Agent/ Broker Details'; 
		$filter=array('partnernumber'=>$id);
		$dets=$this->icsp_agents_brokers_model->find_one_array($filter);
		$this->vars['panel_page_title'] = $dets['name'].' Details'; 
		$this->vars['current_user']=$dets;
		$output = $this->_render('admin/agent_broker_details', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}	
	public function agent_broker_clients($id)
	{
		$filter=array('partnernumber'=>$id);
		$dets=$this->icsp_agents_brokers_model->find_one_array($filter);
		$this->vars['page_title'] = 'ICSP Admin : Customers Under '.$dets['name']; 
		$this->vars['panel_page_title'] = 'Customers Under '.$dets['name']; 
		$this->vars['int_part_no'] = $id; 
		$output = $this->_render('admin/agent_broker_clients', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
public function customer_details($id)
	{
		$this->vars['page_title'] = 'ICSP Admin : Customer Details'; 
		$filter=array('partnernumber'=>$id);
		$dets=$this->icsp_customers_model->find_one_array($filter);
		$this->vars['panel_page_title'] = $dets['name'].' Details'; 
		$this->vars['current_user']=$dets;
		$output = $this->_render('admin/customers_details', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}	
	public function customer_policies($id)
	{
		$this->vars['page_title'] = 'ICSP Admin : Customer Details'; 
		$filter=array('partnernumber'=>$id);
		$dets=$this->icsp_customers_model->find_one_array($filter);
		$this->vars['panel_page_title'] = $dets['name'].' Policies'; 
		$this->vars['partnernumber'] = $id; 
		$output = $this->_render('admin/customer_policies', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}	

	public function policy_claims($policy)
	{
		$data=array('view_policy_claims'=>$policy,'type'=>'claims');
		$this->session->set_userdata($data);
		redirect('admin/user_policy_claims');
	}
	public function policy_claims_policy($policy)
	{
		$filter=array();
		$this->vars['page_title'] = 'ICSP Admin : Claims'; 
		$this->vars['panel_page_title'] = 'Claims Under Policy Number : '.add_slashes($policy); 
		$this->vars['policy']=$policy;

		
		$filter=array('policy_no'=>$policy);

		//$this->vars['claims_list']=$this->admin_claims_list($filter);
		$output = $this->_render('admin/admin_claims_policy', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function policy_insured_items($policy)
	{
		$data=array('view_policy_risk'=>$policy,'type'=>'insured_items');
		$this->session->set_userdata($data);
		redirect('admin/insured_items');
	}
	public function endorsements($policy)
	{
		$this->vars['page_title'] = 'ICSP Admin : Endorsements'; 
		$this->vars['panel_page_title'] = 'Endorsements under policy: '.add_slashes($policy); 

		//$filter=array('policy_no'=>$policy);
		//$this->vars['endorsement_list']=$this->endorsement_list($filter);
		$this->vars['policy']=$policy;
		$output = $this->_render('admin/endorsements', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}	
	public function insured_items()
	{
		$this->vars['page_title'] = 'ICSP Admin : Insured Items'; 
		$this->vars['panel_page_title'] = 'Insured Items'; 
		$this->vars['policy_list']=$this->admin_risk_policy_list();

		$policy=$this->CI->session->userdata('view_policy_risk')?$this->CI->session->userdata('view_policy_risk'):"";
		$this->vars['policy']=$policy;
		$data=array('view_type'=>'insured_items','view_policy_risk'=>$policy);
		$this->session->set_userdata($data);
		//$this->vars['insured_items_list']=$this->insured_items_list($filter);
		$output = $this->_render('admin/insured_items', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function user_policy_claims()
	{
		$filter=array();
		$this->vars['page_title'] = 'ICSP Admin : Claims'; 
		$this->vars['panel_page_title'] = 'Claims'; 
		$policy=$this->CI->session->userdata('view_policy_claims')?$this->CI->session->userdata('view_policy_claims'):"";
		$this->vars['policy']=$policy;

		if($policy!=="")
		{
			$filter=array('policy_no'=>$policy);
		}
		
		$this->vars['policy_list']=$this->claims_policy_list();

		$data=array('view_type'=>'claims','view_policy_claims'=>$policy);
		$this->session->set_userdata($data);

		$this->vars['claims_list']=$this->admin_claims_list($filter);
		$output = $this->_render('admin/admin_claims', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function claim_details($claim)
	{
		$this->vars['page_title'] = 'ICSP Admin : Claim Details'; 
		$this->vars['panel_page_title'] = 'Claim Number: '.add_slashes($claim); 

		$filter=array('claim_no'=>$claim);

		$this->vars['claim_details']=$this->get_claim_details($filter);
		$this->vars['claim']=$claim;
		$output = $this->_render('admin/claim_details', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function policy_details($policy)
	{
		$this->vars['page_title'] = 'ICSP Admin : Policy Details'; 
		$this->vars['panel_page_title'] = 'Policy Number: '.add_slashes($policy); 

		$filter=array('policy_no'=>$policy);

		$this->vars['policy_details']=$this->get_policy_details($filter);
		$this->vars['policy']=$policy;
		$output = $this->_render('admin/policy_details', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function renewals()
	{
		$this->vars['page_title'] = 'ICSP Admin : Upcoming Renewals'; 
		$this->vars['panel_page_title'] = 'Upcoming policy renewals'; 
		$output = $this->_render('admin/renewals', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function smscenter()
	{
		$this->vars['page_title'] = 'ICSP Admin : SMS Communication'; 
		$this->vars['panel_page_title'] = 'Send messages to clients and agents/ Brokers'; 
		$output = $this->_render('smscenter', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	public function reminders($policy_no)
	{
		$this->vars['page_title'] = 'ICSP Admin : Reminders'; 
		$this->vars['panel_page_title'] = "Send reminders to clients under policy No.".add_slashes($policy_no); 
		$filter=array('policy_no'=>$policy_no);		
		$this->vars['policy_total'] = $this->get_policy_total($filter);
		$this->vars['rem_policy'] = $policy_no;
		//$this->vars['names_list'] = $this->my_clients_list('names',$filter);
		//$output = $this->_render('reminders', $this->vars, TRUE);
		$output = $this->_render('reminders', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
	}
	function send_sms()
	{
		$tel=$this->input->get_post('tel')?$this->input->get_post('tel',true):"";
		$msg=$this->input->get_post('message')?$this->input->get_post('message',true):"";
		
		$tel=str_replace("+","",$tel);
		$ptn = "/^0/";  // Regex
		$rpltxt = "254";  // Replacement string
		$tel=preg_replace($ptn, $rpltxt, $tel);
		$res=send_sms($tel,$msg);
		if($res==="ok")
		{
			$post_data['type']='success';
			$post_data['message']="Message sent.";
		}
		else
		{
			$post_data['type']='danger';
			$post_data['message']="Operation failed. Could not send message";
		}		
		$this->session->set_flashdata('send_sms',$post_data);
		redirect('admin/smscenter');
	}

function activate($id)
{
	$filter=array('id'=>$id);
	$res=$this->icsp_user_reg_model->find_one_array($filter);
	if(empty($res))
	{
		$msg="Account already activated or removed from list.";
				$this->return_method($msg,'info');	
	}
	$email_sub='Account activation notification';

	$salt = salt();	
	$salt= substr($salt, 0, 32);
	$pwd=gen_int_pass();
	$res['password']= salted_password_hash($pwd, $salt);
	$res['salt']= $salt;
	$res['is_first_time']= 'yes';
	$res['is_active']= 'yes';
	$mobile_no=$res['contacts'];
	unset($res['id']);

	$act_fld=$res['activation_field'];

	if($act_fld==="Partner Number")
	{
		$act_fld="partnernumber";
		$amsg="partner number: ".$res['activation_value'];
	}

	if($act_fld==="Policy Number")
	{
		$act_fld="policy_no";
		$amsg="policy number: ".add_slashes($res['activation_value']);
	}
	
	if($act_fld==="Insured Item")
	{
		$act_fld="insured_item";
		$amsg="insured item: ".$res['activation_value'];
	}	
				
	if($res['accounttype']==="1") 
   	{ 
   		$partner_no=$this->check_act_user($res['names'],$act_fld,$res['activation_value'],'icsp_customers_model','c_partnernumber');  
        if($partner_no!=="")
	   	{
	   		$res['user_id']=$partner_no;
	   		$user_dets=$this->icsp_customers_model->find_one_array(array('partnernumber'=>$partner_no));
		   	$url = base_url();
		    $message="Dear ".$user_dets['name'].",<br/>You have sucessfully been authenticated to use the ICSP online customer portal. Your login credentials are as listed below:<br/>\tYour username: ".$res['email']."<br/>\tYour password: $pwd<br/>Follow the link below to login to your account<br/>".$url."<br/>";
		    $msga="Dear ".$user_dets['name'].", You have sucessfully been authenticated to use the ICSP online portal. Your login username is : ".$res['email']." and the password is: $pwd. The login url is: ".$url;
		  	$params['to'] = $res['email'];
			$params['subject'] = $email_sub;;
			$params['message'] = $message;
			$params['use_dev_mode'] = FALSE;
			$params['from_name']=$this->email_nicename;

			if (!$this->fuel->notification->send($params))
			{   
				$msg="Could not send notification email to the address provided. Please try again or contact our information center.";
				$this->return_method($msg);				
	      	}
			else
			{				
			    send_sms($msga,$mobile_no);
				$user_dets=$this->icsp_customers_model->clean($res);
				$this->icsp_customers_model->update($user_dets,array('partnernumber'=>$partner_no));
				$auth_dets=$this->icsp_customers_auth_model->clean($res);
				$this->icsp_customers_auth_model->update($auth_dets,array('partnernumber'=>$partner_no));
				$docs=$this->icsp_documents_model->clean($res);
				$this->icsp_documents_model->update($docs,array('user_id'=>$res['pseudo_id']));
				$this->icsp_user_reg_model->delete(array('pseudo_id'=>$res['pseudo_id']));  
			    $msg="User activated and email notification sent to the email address provided <b>[ ".$res['email']." ]</b>.";
			    $this->return_method($msg,'success');
			}
		}
		else
		{
		    $msg="Could not find any user account linked to activation details provided <b>[ $amsg ]</b>";
			$this->return_method($msg);
		}
	}    
    else 
    {
	  	$partner_no=$this->check_act_user($res['names'],$act_fld,$res['activation_value'],'icsp_agents_brokers_model','a_partnernumber'); 
	  	$res['user_id']=$partner_no;
	    if($partner_no!=="")
	   	{
	        $user_dets=$this->icsp_customers_model->find_one_array(array('partnernumber'=>$partner_no));
		  	$message="Dear ".$user_dets['name'].",<br/>You have sucessfully been authenticated to use the ICSP online customer portal. Your login credentials are as listed below:<br/>\tYour username: ".$res['email']."<br/>\tYour password: $pwd<br/>Follow the link below to login to your account<br/>".$url."<br/>";
		  	$msga="Dear ".$user_dets['name'].", You have sucessfully been authenticated to use the ICSP online portal. Your login username is : ".$res['email']." and the password is: $pwd. The login url is: ".$url;
		  	$params['to'] = $res['email'];
			$params['subject'] = $email_sub;;
			$params['message'] = $message;
			$params['use_dev_mode'] = FALSE;
			$params['from_name']=$this->email_nicename;

			if (!$this->fuel->notification->send($params))
			{   
				$msg="Could not send notification email to the address provided. Please try again or contact our information center.";
				$this->return_method($msg);				
	      	}
			else
			{		 
		  		send_sms($msga,$mobile_no);
		  		$user_dets=$this->icsp_agents_brokers_model->clean($res);
				$this->icsp_agents_brokers_model->update($user_dets,array('partnernumber'=>$partner_no));
				$auth_dets=$this->icsp_agents_brokers_auth_model->clean($res);
				$this->icsp_agents_brokers_auth_model->update($auth_dets,array('partnernumber'=>$partner_no));
				$docs=$this->icsp_documents_model->clean($res);
				$this->icsp_documents_model->update($docs,array('user_id'=>$res['pseudo_id']));
				$this->icsp_user_reg_model->delete(array('pseudo_id'=>$res['pseudo_id']));
				$msg="User activated and email notification sent to the email address provided <b>[ ".$res['email']." ]</b>.";
			    $this->return_method($msg,'success');
		  	}
		}	
		else
		{
			$msg="Could not find any user account linked to activation details provided <b>[ $amsg ]</b>";
			$this->return_method($msg);
		}
	}
}

function check_act_user($names,$act_fld,$val,$model,$fld)
{
	$res=array();
	$fltr=array($act_fld=>$val);
	$p_no="";
	if($act_fld==="policy_no")
	{
		$resp=$this->icsp_policies_model->find_one_array($fltr);
		if(!$resp)
		{
			$msg="Provided activation value not found in the database. Policy No. : <b>$val</b>. Activation not possible.";
			$this->return_method($msg);
		}

		$res=$this->$model->find_one_array(array('partnernumber'=>$resp[$fld]));
		$acc_names=$res['name'];
		$p_no=$res['partnernumber'];
		if(clean_string($acc_names)!==clean_string($names))
		{
			$msg="Policy number provided is valid but the account names differ. Please reconcile the names to proceed. Account name : <b>$acc_names</b>, Provided name : <b>$names.</b>";
			$this->return_method($msg);
		}
	}
	if($act_fld==="insured_item")
	{
		$resp=$this->icsp_insured_items_model->find_one_array($fltr);
		if(!$resp)
		{
			$msg="Provided activation value not found in the database. Insured Item : <b>$val</b>. Activation not possible.";
			$this->return_method($msg);
		}

		$res=$this->$model->find_one_array(array('partnernumber'=>$resp[$fld]));
		$acc_names=$res['name'];
		$p_no=$res['partnernumber'];
		if(clean_string($acc_names)!==clean_string($names))
		{
			$msg="Insured Item provided is valid but the account names differ. Please reconcile the names to proceed. Account name : <b>$acc_names</b>, Provided name : <b>$names.</b>";
			$this->return_method($msg);
		}
	}
	if($act_fld==="partnernumber" || $act_fld==="id_number")
	{
		$res=$this->$model->find_one_array(array($act_fld=>$val));
		if(empty($res))
		{
			$msg="No Records found matching any of the provided details. Activation not possible!!";
			$this->return_method($msg);
		}
		$acc_names=$res['name'];
		$p_no=$res['partnernumber'];
		if(clean_string($acc_names)!==clean_string($names))
		{
			$msg="Partner Number provided is valid but the account names differ. Please reconcile the names to proceed. Account name : <b>$acc_names</b>, Provided name : <b>$names.</b>";
			$this->return_method($msg);
		}
	}
	return $p_no;
}

function return_method($msg,$type="danger")
{
	$old_data['type']=$type;
	$old_data['message']=$msg;
	$old_data['link']='reg_link';
	$this->session->set_flashdata('act_msg', $old_data);
	redirect("admin/activate_clients");
}
function edit_name($id)
{
	$data['id']=$id;
	$data['my_arr']= array();
	if(!empty($id))
	{
		$filter=array('id'=>$id);
		$data['my_arr']=$this->icsp_user_reg_model->find_one_array(array('id'=>$id));
	}
	$this->load->view('pages/edit_name',$data);
}
function save_name($id)
{
	$data=$this->icsp_user_reg_model->clean($_POST);
	$this->icsp_user_reg_model->update($data,array('id'=>$id));
	$old_data['type']='success';
	$old_data['message']="Name change successfull!";
	$old_data['link']='reg_link';
	$this->session->set_flashdata('act_msg', $old_data);
	redirect("admin/activate_clients");
}
function reported_claims()
{
		$this->vars['page_title'] = 'ICSP Admin : Reported Claims'; 
		$this->vars['panel_page_title'] = "View claims reported by customers and agents/ brokers"; 
		$output = $this->_render('admin/reported_claims', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
}
function claim_report_details($id)
{
	$this->vars['page_title'] = 'ICSP : Registered Claim Detils'; 
	$this->vars['panel_page_title'] = 'Registered Claim Detils'; 
	$filter=array('reference_number'=>$id);
	$this->vars['res_dets'] = $this->icsp_claims_registration_model->find_one_array($filter);
	$output = $this->_render('registered_claim', $this->vars, TRUE,'_layouts/icsp_admin');
	$this->output->set_output($output);
}
function user_documents()
{
		$this->vars['page_title'] = 'ICSP Admin : User Documents'; 
		$this->vars['panel_page_title'] = "User Documents"; 
		$output = $this->_render('admin/user_documents', $this->vars, TRUE,'_layouts/icsp_admin');
		$this->output->set_output($output);
}

}