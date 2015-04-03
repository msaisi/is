<?php
$vars =array();
$pge=ucwords(uri_segment(2));
$vars['page_title']="IS : ".$pge;
?>
<?php $this->load->view('_blocks/is_admin_header',$vars)?>
<?php $this->load->view('_blocks/is_admin_body')?>	
<?php $this->load->view('_blocks/is_admin_footer')?>
