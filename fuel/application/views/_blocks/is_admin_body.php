<?php 
if($this->session->userdata('is_locked') || strtolower(uri_segment(2))==="lock")
{	
	$this->load->view('admin_template/layouts/lock_screen');		
}
else
{
	if(strtolower(uri_segment(1))=="insurer" && strtolower(uri_segment(2))==="signin" )
	{
		$this->load->view('admin_template/layouts/auth_view');
	}
	else
	{
		$this->load->view('admin_template/layouts/pages_view');
	}
}
?>