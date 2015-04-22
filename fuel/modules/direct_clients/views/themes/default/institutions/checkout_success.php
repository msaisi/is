<div class="col-md-12">
<div class="col-md-12 white-row">

<div class="col-md-8">
<div class="about_header">
<i class="fa fa-file-text-o"></i> My Order Details
<hr/>
</div>
<table class="table table-bordered table-striped contacts_div my_shopping_cart">
<thead>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </thead>
   <tbody>
  <tr>
    <td>Order ID:</td>
    <td> <?=$order_id?></td>
  </tr>
  <tr>
    <td>Institution Name:</td>
    <td><?=$institution['institution_name']?></td>
  </tr>
  <tr>
    <td>Order Date:</td>
    <td><?=$order_date?></td>
  </tr>
   <tr>
    <td>Order Total:</td>
    <td>Kes <?=number_format(cart_total(), 2)?></td>
  </tr>

  <tr>
    <td>Order Description:</td>
    <td><?=$order_description?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</tbody>
</table>	
</div>
<div class="col-md-4">
<div class="about_header">
<i class="fa fa-check-square-o"></i> Purchased Items
<hr/>
</div>
<?php if(!empty($items)){?>
<table class="table table-bordered table-striped contacts_div my_shopping_cart">
  <!-- table head -->
  <thead>
  <tr><!-- item -->
        <th>Item</th>
        <th><span class="right">Price</span></th>
   </tr>
  </thead>
   <!-- table items -->
    <tbody>
    <?php 
	$i=0;
	$cart_tot=0;
	foreach($items as $row):	?>
        <tr><!-- item -->
            <td><?=$row['name']?></td>
            <td align="right"><?php
            echo $row['item_tot_price'];
			$cart_tot=$cart_tot+$row['item_tot_price'];			
			?></td>
    </tr>
    <?php  
	$i++;
	endforeach;  ?>   
     <tr><!-- item -->
            <td>Cart Total</td>
            <td align="right"><?=$cart_tot?></td>
        </tr>  
    </tbody>
</table>
<?php }?>
</div>

</div>
<?php
	$CI->session->unset_userdata('order_id');
	$CI->session->unset_userdata('order_description');
	$CI->session->unset_userdata('order_date');
?>
</div>