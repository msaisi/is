<?php header("HTTP/1.1 404 Not Found"); ?>
<?php 
$ci= & get_instance();
define('IS_404', TRUE);
define('FUELIFY', FALSE);
$vars['page_title'] = '404 Error : Page Cannot Be Found';
$vars['err_page']='error';
?>	
<?php $ci->load->view('_blocks/is_front_header',$vars)?>
<?php $ci->load->view('_blocks/is_front_body')?>	
<?php $ci->load->view('_blocks/is_front_footer')?>