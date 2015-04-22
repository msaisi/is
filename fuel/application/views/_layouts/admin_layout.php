<?php
$vars =array();
$pge=$page_title?$page_title: "IS : ".ucwords(uri_segment(2));
$vars['page_title']=$pge;
?>
<?php $this->load->view('_blocks/is_admin_header',$vars)?>
<?php $this->load->view('_blocks/is_admin_body')?>	
<?php $this->load->view('_blocks/is_admin_footer')?>
