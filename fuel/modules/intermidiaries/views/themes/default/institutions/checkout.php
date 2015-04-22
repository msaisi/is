<div class="col-md-12">
<div class="col-md-12 white-row">
<?php if(!empty($items))
{ ?>
<div class="col-md-12">
<?php 
 $data['v']="large";
 $CI->load->view('_blocks/shopping_cart',$data);?> 		
</div>
<?php
 } 
else {?>
<div class="alert alert-danger">
    <i class="fa fa-shopping-cart"></i> 
    <span>Your cart is empty, Plase add available premium features or packages to proceed.</span>
</div>
<?php }?>
</div>



</div>