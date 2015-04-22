<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/group_access/config/group_access_constants.php');

class Groups_model extends Base_module_model 
{
	
	public $required = array('name','description');
	public $auto_date_add = array('date_added');
	public $auto_date_update = array('last_modified');
	
	function __construct()
	{
		parent::__construct('is_usergroups'); // table name
	}
	
	function form_fields($values = array())
	{
		$fields = parent::form_fields();
		$permission_list = $this->fuel_permissions_model->options_list('id','name',array('active'=>'yes'));

		$permissions=(!empty($values['id'])) ? array_keys($this->group_to_permissions_model->find_all_array_assoc('permission_id', array('group_id' => $values['id']))) : array();
		
		$fields['permissions'] = array('label' => 'Permission', 'type' => 'array', 'options' => $permission_list, 'value' => $permissions, 'mode' => 'multi');
		$fields['is_active']['order'] = 99;
		return $fields;
	}

    // save one to many permission in group_to_permissions table	
	function on_after_save($values)
	{
		$permissions = (!empty($this->normalized_save_data['permissions'])) ? $this->normalized_save_data['permissions'] : array();		
		$group_id=$values['id'];
		$this->save_related(array(GROUP_ACCESS_FOLDER=>'group_to_permissions_model'), array('group_id' => $values['id']), array('permission_id' => $permissions));
	}
	
	// cleanup permission from group_to_permissions table
    function on_after_delete($where)
    {
		$this->delete_related(array(GROUP_ACCESS_FOLDER=>'group_to_permissions_model'), 'group_id', $where);
    }

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
	public function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name')
	{
		$CI =& get_instance();
		if ($key == 'id')
		{
			$key = $this->table_name.'.id';
		}
		if ($val == 'name')
		{
			$val = 'name';
			$order = 'name';
		}
		else
		{
			$order = $val;
		}

		$this->db->where(array('is_active' => 'yes'));

		$return = parent::options_list($key, $val, $where, $order);
		return $return;
	}
}