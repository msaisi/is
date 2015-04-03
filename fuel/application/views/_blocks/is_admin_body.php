<?php 
if(strtolower(uri_segment(1))=="admin" && strtolower(uri_segment(2))==="profile" )
{
	$this->load->view('admin_template/layouts/pages_view');
}
else
{
	$this->load->view('admin_template/layouts/auth_view');
}
?>