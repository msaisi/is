<?php
$vars =array();
$pge=ucwords(uri_segment(2));
$vars['page_title']="IS Front : ".$pge;
?>
<?php $this->load->view('_blocks/is_front_header',$vars)?>
<?php $this->load->view('_blocks/is_front_body')?>	
<?php $this->load->view('_blocks/is_front_footer')?>
