<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/companies/config/companies_constants.php');

class Companies_accounts_model extends Base_module_model {
	
	public $required = array('email', 'registration_number', 'company_code','name','contacts','post_office_box','postal_code');
	public $filters = array('email', 'registration_number', 'company_code','name','contacts','post_office_box','postal_code'); // Additional fields that will be searched
	public $unique_fields = array('email', 'company_code'); // User name is a unique field
	public $hidden_fields = array('slug','system_id','date_added'); // User name is a unique field	
	public $auto_date_add = array('date_added');
	public $image_path = null;

	public function __construct()
	{
		parent::__construct('companies_accounts', COMPANIES_FOLDER);
		$this->my_fields_map=array('company_image'=>"-logo-image-is-accounts");		
		$this->company_config= $this->fuel->companies->config();
	}

	public function valid_user($uid, $pwd)
	{
		$where = array('is_active ' => 'yes');
		$where['email']=$uid;
		$user = $this->find_one_array($where);	

		if (empty($user['salt'])) return FALSE;

		if ($user['password'] === salted_password_hash($pwd, $user['salt']))
		{		
			$user=encrypt_data($user);
			$user= unset_user_data($user);
			return $user;
		}
		return FALSE;
	}
	/*function filters()
	{
	   $filters['institution_name'] = array('label'=>'Institution Name');
	 //  $filters['b:name'] = array('label' => 'Institution Type', 'type'=>'select','options'=>$this->companies_institution_types_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['contact_person'] = array('label'=>'Contact Person');
	   $filters['email'] = array('label'=>'Email');
	   $filters['contacts'] = array('label'=>'Contacts'); 
	   $filters['is_active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 

	    $filters['last_login_fromequal'] = array('type' => 'date','label'=>'From date');
	   $filters['last_login_toequal'] = array('type' => 'date','label'=>'To date');
	  // $filters['b:name'] = array('label'=>'Contacts');
	  return $filters;
	}
*/
	public function list_items($limit = NULL, $offset = NULL, $col = 'email', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$a=$this->_tables['companies_accounts'];
		$this->db->select("$a.id,name,company_code,registration_number,email,contacts,postal_code,post_office_box,is_active",FALSE); 
		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}
		
	public function user_exists($email)
	{
		return $this->record_exists(array('email' => $email));
	}
	
	public function options_list($key = 'id', $val = 'company_code', $where = array(), $order = 'company_code')
	{
		if($val==='CONCAT(email, " - ", language) AS val_field')
		{
			$val=$this->table_name.".email";
		}
		$order=$this->table_name.'.email';
		/*if($val==='name')
		{
			$val='CONCAT(institution_name, " ", contact_person) AS name';
			$order='name';
		}
		*/
		if ($key === 'id')
		{
			$key = $this->table_name.'.id';
		}		
		
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
	
	public function on_before_clean($values)
	{				
		$values['system_id'] = empty($values['system_id'])? gen_unique_id("",20) : $values['system_id'];
		if(isset($values['name']))
		{
		   $values['slug'] = strtolower(url_title($values['name'], 'dash', TRUE));
		}
		if(isset($values['pic']))
		{
			$_POST['pic']=$values['pic'];
		}
		return $values;		
	}
	
	public function is_new_email($email)
	{
		return $this->is_new($email, 'email');
	}	
	
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);

		$fields['company_image']['folder'] = $this->fuel->companies->config('asset_upload_path_company_profile_images');	
		$fields['company_image']['upload_path'] = $this->fuel->companies->config('asset_upload_path_company_profile_images');
		$fields['company_image']['img_styles'] = 'float: left; width: 150px;height:150px; margin-left:5px;margin-top:3px';
		$fields['company_image']['label']="Logo";
		$fields['company_image']['file_name'] = '{system_id}'.$this->my_fields_map['company_image'];
		$fields['company_image']['readonly'] = true;
		$fields['company_image']['style'] = 'width: 0%;';

		if (!empty($values['id']))
		{
			$pic=$values['company_image'];	   
		}
		else
		{
			$pic="";
		}

		$fields['pic'] = array('type' => 'hidden', 'value' =>$pic);

		$fields['company_image']['order'] = 1;

		$fields['name']['style'] = 'width: 300px;';
		$fields['email']['style'] = 'width: 300px;';
		$fields['company_code']['style'] = 'width: 300px;';
		$fields['registration_number']['style'] = 'width: 300px;';
		$fields['postal_code']['style'] = 'width: 300px;';
		$fields['post_office_box']['style'] = 'width: 300px;';
		$fields['contacts']['style'] = 'width: 300px;';
		$fields['kra_pin']['style'] = 'width: 300px;';
		$fields['nhif']['style'] = 'width: 300px;';
		$fields['location']['style'] = 'width: 300px;';
		$fields['price_per_claim']['style'] = 'width: 100px;';


		$fields['price_per_claim']['currency'] = $this->company_config['currency'];
		$fields['price_per_claim']['default'] =0;

		$fields['company_image']['order'] = 1;
		$fields['name']['order'] = 2;
		$fields['email']['order'] = 3;
		$fields['company_code']['order'] = 4;
		$fields['registration_number']['order'] = 5;
		$fields['postal_code']['order'] = 6;
		$fields['post_office_box']['order'] = 7;
		$fields['contacts']['order'] = 8;
		$fields['location']['order'] = 9;
		$fields['kra_pin']['order'] = 10;
		$fields['nhif']['order'] = 11;
		$fields['about']['order'] = 12;
		$fields['price_per_claim']['order'] = 20;
		$fields['is_active']['order'] = 99;

		//$fields = array_merge($fields, $perm_fields);
		unset($fields['nhif'], $fields['kra_pin']);
		return $fields;
	
	}
	public function on_before_save($values)
	{
		$values=image_upload_rename('companies_accounts_model',$this->company_config['asset_upload_path_company_profile_images'],$values,$this->my_fields_map,'system_id');  
		$values=upload_files($this->my_fields_map,$this->company_config['asset_upload_path_company_profile_images'],$values);
		return $values;
	}
	public function on_before_validate($values)
	{	
		$this->add_validation('email', 'valid_email', lang('error_invalid_email'));	

		// for new 
		if (empty($values['id']))
		{
			//$this->required[] = 'password';
			$this->add_validation('email', array(&$this, 'is_new_email'), lang('error_val_empty_or_already_exists', lang('form_label_email')));
		}		
		// for editing
		else
		{
			$this->add_validation('email', array(&$this, 'is_editable_email'), lang('error_val_empty_or_already_exists', lang('form_label_email')), $values['id']);
		}
		return $values;		
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
}