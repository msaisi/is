<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/gradstate/config/gradstate_constants.php');

class Gradstate_institutions_model extends Base_module_model {
	
	public $required = array('email', 'institution_name', 'contact_person','postal_address','contacts','account_type'); // ,'website','facebook','twitter'
	public $filters = array('email', 'institution_name', 'contact_person','postal_address','contacts','account_type','website','facebook','twitter'); // Additional fields that will be searched
	public $unique_fields = array('email', 'institution_id'); // User name is a unique field
	public $hidden_fields = array('institution_id','language','last_login','slug'); // User name is a unique field
	

	public $image_path = null;
	public $logo_image_path = null;	
	public $CI=null;
	public $gradstate_config=array();

	public function __construct()
	{
		parent::__construct('gradstate_institutions', GRADSTATE_FOLDER);
		$this->CI =& get_instance();				
		$this->gradstate_config = $this->CI->fuel->gradstate->config();
		$this->image_path=$this->gradstate_config['asset_upload_path_institution_profile_images'];
		$this->logo_image_path=$this->gradstate_config['asset_upload_path_institution_logo_images'];
		
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
	function filters()
	{
	   $filters['institution_name'] = array('label'=>'Institution Name');
	   $filters['b:name'] = array('label' => 'Institution Type', 'type'=>'select','options'=>$this->gradstate_institution_types_model->options_list('name','name'),'first_option'=>'select one', 'style'=>'max-width: 217px;');
	   $filters['contact_person'] = array('label'=>'Contact Person');
	   $filters['email'] = array('label'=>'Email');
	   $filters['contacts'] = array('label'=>'Contacts'); 
	   $filters['is_active'] = array('label' => 'Active', 'type'=>'select','options'=>array('yes'=>'yes','no'=>'no'),'first_option'=>'select one', 'style'=>'max-width: 217px;'); 

	    $filters['last_login_fromequal'] = array('type' => 'date','label'=>'From date');
	   $filters['last_login_toequal'] = array('type' => 'date','label'=>'To date');
	  // $filters['b:name'] = array('label'=>'Contacts');
	  return $filters;
	}

	public function list_items($limit = NULL, $offset = NULL, $col = 'email', $order = 'asc', $just_count = FALSE)
	{
		$this->filter_join= 'and'; 
		$b=$this->_tables['gradstate_institution_types'];
		$a=$this->_tables['gradstate_institutions'];

		$this->db->select("$a.id,institution_name,contact_person,email,contacts,b.name as institution_type,is_active,last_login",FALSE); 

		$this->db->join($b.' as b', "b.id = $a.account_type", 'left');

		$data = parent::list_items($limit, $offset, $col, $order, $just_count);
		return $data;
	}

	public function user_info($user_id)
	{
		$user = $this->find_one_array(array('institution_id' => $user_id));
		$user_data = $user->values();
		return $user_data;
	}
	
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
		
	public function user_exists($email)
	{
		return $this->record_exists(array('email' => $email));
	}
	public function activate_rec($where)
	{
		return $this->record_exists($where);
	}
	
	public function options_list($key = 'id', $val = 'institution_id', $where = array(), $order = 'institution_id')
	{
		if($val==='CONCAT(email, " - ", language) AS val_field')
		{
			$val=$this->table_name.".email";
		}
		$order=$this->table_name.'.email';
		if($val==='name')
		{
			$val='CONCAT(institution_name, " ", contact_person) AS name';
			$order='name';
		}
		if ($key === 'id')
		{
			$key = $this->table_name.'.id';
		}
		
		
		$return = parent::options_list($key, $val, $where, $order);		
		return $return;
	}
/*	public function my_ajax_options()
	{
		$options = $this->options_list('campus_id','campus_name',$where);
		$str = '';
		//$i=0;
		foreach($options as $key => $val)
		{
			$str .= "<option value=\"".$key."\" label=\"".$val."\">".$val."</option>\n";
			//$str .="<li id=\"campuses_$i\" data-label=\"$val\">$val</li>\n";
			//$i++;
		}
		return $str;
	}*/
	
	
	public function on_before_clean($values)
	{
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
		
		$values['institution_id'] = empty($values['institution_id'])? gen_unique_id(20) : $values['institution_id'];
		if(isset($values['institution_name']))
		{
		   $values['slug'] = strtolower(url_title($values['institution_name'], 'dash', TRUE));
		}
		if(isset($values['pic']))
		{
			$_POST['pic']=$values['pic'];
			$_POST['pic1']=$values['pic1'];
		}
		return $values;		
	}
	
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
		return $values;
	}
	public function is_new_email($email)
	{
		return $this->is_new($email, 'email');
	}
	
	public function is_editable_email($email, $id)
	{
		return $this->is_editable($email, 'email', $id);
	}
	
	public function _common_query($params = NULL)
	{
		parent::_common_query();
		$this->db->select('*',FALSE); 
	}
	public function form_fields($values = array())
	{
		$fields = parent::form_fields($values);

		$fields['profile_picture']['type']='file';
		$fields['profile_picture']['folder'] = $this->image_path;
		$fields['profile_picture']['upload_path'] = $this->image_path;
		$fields['profile_picture']['img_styles'] = 'float: left; width: 150px;height:150px';

		$fields['logo_picture']['type']='file';
		$fields['logo_picture']['folder'] = $this->logo_image_path;
		$fields['logo_picture']['upload_path'] = $this->logo_image_path;
		$fields['logo_picture']['img_styles'] = 'float: left; width: 100px;height:100px';

		// save reference it so we can reorder
		$pwd_field = $fields['password'];
		unset($fields['password']);
				
		if (!empty($values['id']))
		{
			$fields['new_password'] = array('label' => lang('form_label_new_password'), 'type' => 'password', 'size' => 20, 'order' => 13);
		    $fields['is_active']['order'] = 20;
		    $pic=$values['profile_picture'];
		    $pic1=$values['logo_picture'];		   
		}
		else
		{
			$pwd_field['type'] = 'password';
			$pwd_field['size'] = 20;
			$pwd_field['order'] = 13;
			$fields['password']= $pwd_field;
			$pic="";
			$pic1="";
		}

		$fields['pic'] = array('type' => 'hidden', 'value' =>$pic);
		$fields['pic1'] = array('type' => 'hidden', 'value' =>$pic1);

		$fields['profile_picture']['style'] = 'width: 350px;';
		$fields['logo_picture']['style'] = 'width: 350px;';
		$fields['email']['style'] = 'width: 300px;';
		$fields['institution_name']['style'] = 'width: 300px;';
		$fields['contact_person']['style'] = 'width: 300px;';
		$fields['contacts']['style'] = 'width: 300px;';
		$fields['website']['style'] = 'width: 300px;';
		$fields['twitter']['style'] = 'width: 300px;';

		$fields['profile_picture']['order']=2;	
		$fields['logo_picture']['order']=1;	
		$fields['institution_name']['order'] = 3;
		$fields['contact_person']['order'] = 4;
		$fields['postal_address']['order']=5;
		$fields['email']['order'] = 6;
		$fields['contacts']['order'] = 7;
		$fields['account_type']['order'] = 8;
		$fields['about']['order'] = 9;
		$fields['website']['order'] = 10;
		$fields['twitter']['order'] = 11;
		$fields['facebook']['order'] = 12;
		$fields['confirm_password'] = array('label' => lang('form_label_confirm_password'), 'type' => 'password', 'size' => 20, 'order' => 14);
		$fields['account_type']['type']='select';
		$fields['account_type']['options']=$this->gradstate_institution_types_model->options_list('id','name');
		$fields['account_type']['first_option']='Select one...';

		//$fields = array_merge($fields, $perm_fields);
		unset($fields['reset_key'], $fields['salt'],$fields['registration_date']);
		return $fields;
	
	}
	public function check_old_password($pwd,$uid)
	{
		$clients=$this->_tables['gradstate_institutions'];
		$where = array($clients.'.institution_id ' => $uid);
		$user = $this->find_one_array($where);

		if (empty($user['salt'])) return FALSE;

		if ($user['password'] === salted_password_hash($pwd, $user['salt']))
		{
			return $user;
		}
		return FALSE;
	}
	public function on_before_save($values)
	{
	    $path= assets_server_path($this->logo_image_path);	
	    $the_fld='logo_picture';
		$rename=$values['institution_id'];
		$ret=trim(upload_files($the_fld,$path,$rename));
	
	    if($ret!=="")	
	    {
			$pic=$ret;
		}
		else
		{
			$pic=$_POST['pic1'];
		}
		$values['logo_picture']=$pic;

		$path= assets_server_path($this->image_path);	

	 	$the_fld='profile_picture';
		$rename=$values['institution_id'];
		$ret=trim(upload_files($the_fld,$path,$rename));
	
	    if($ret!=="")	
	    {
			$pic=$ret;
		}
		else
		{
			$pic=$_POST['pic'];
		}
		$values['profile_picture']=$pic;

	    return $values;
	}

	function get_search_data($term,$my_array,$order_by = 'institution_name asc',$limit = NULL, $offset = NULL)
	{
		$a=$this->_tables['gradstate_institutions'];
		$b=$this->_tables['gradstate_campuses'];
		$c=$this->_tables['gradstate_counties'];
		$d=$this->_tables['gradstate_institution_types'];		
		$this->db->from($a);
		$this->db->select("$a.*", FALSE);
		$this->db->join($b,"$a.institution_id=$b.institution_id", 'left');
		$this->db->join($d,"$d.id=$a.account_type", 'left');
		$this->db->join($c, "$c.id=$b.location", 'left');		
		$this->db->group_by($a.'.id');
		$this->db->where($my_array);
		if($term!=="")
		{
			$this->db->where("MATCH (institution_name) AGAINST ('*$term*' IN BOOLEAN MODE)", NULL, FALSE);
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
	
}