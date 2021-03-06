<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FUEL_PATH.'models/base_module_model.php');
require_once(MODULES_PATH.'/group_access/config/group_access_constants.php');

class Group_to_users_model extends Base_module_model {
	
	public $foreign_keys = array('group_id' => array(GROUP_ACCESS_FOLDER=>'groups_model'),'user_id'=>array('fuel'=>'school_model'));	
	public $required = array();
	
	function __construct()
	{
		parent::__construct('is_usergroup_to_users'); // table name
	}

	function _common_query()
	{
		parent::_common_query();
		$a="is_usergroup_to_users";
		$b="is_usergroups";	
		$this->db->select("$a.*, $b.name, $b.order", FALSE);
        $this->db->join($b, $b.'.id = '.$a.'.group_id', 'left');
	}
}

class Group_to_user_model extends Data_record {

}
