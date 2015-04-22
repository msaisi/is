<div class="col-md-12">
<div class="col-md-12 white-row">
<?php if(!empty($features))
{ ?>
<div class="col-md-8">

<a href="account/my_features" class="btn btn-primary btn-xs"><i class="fa fa-hand-o-right"></i>My Subscriptions</a>
<div class="dap gap-mini"></div>

<table class="table table-bordered table-striped contacts_div">
  <!-- table head -->
  <thead>
  <tr><!-- item -->
        <th>Name</th>
        <th>Description</th>
        <th><span class="right">Price</span></th>
        <td>&nbsp;</td>
   </tr>
  </thead>
   <!-- table items -->
    <tbody>
    <?php foreach($features as $row):	?>
        <tr><!-- item -->
            <td><?=$row['name']?></td>
            <td><?=$row['description']?></td>
            <td align="right"><?=$row['price']?></td>
            <td><button class="btn btn-primary btn-xs purchase-feature" purchase-item="<?=$row['slug']?>">Purchase</button></td>
        </tr>
    <?php  endforeach;  ?>       
    </tbody>
</table>
</div>
<div class="col-md-4">
<?php  
 $data['v']="small";
$CI->load->view('_blocks/shopping_cart',$data);?> 		
</div>
<?php
 } 
else {?>
<div class="alert alert-danger">
    <i class="fa fa-wrench"></i> 
    <span>Sorry, we do not yet have premium features for you to purchase. Please check later</span>
</div>
<?php }?>
</div>



</div>