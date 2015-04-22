<?php
$periods=create_validity();
?>
<div class="col-md-12">
<div class="col-md-12 white-row">
<?php if(!empty($packages))
{ ?>
<div class="col-md-8">
<a href="account/my_packages" class="btn btn-primary btn-xs"><i class="fa fa-hand-o-right"></i>My Subscriptions</a>
<div class="dap gap-mini"></div>

<table class="table table-bordered table-striped contacts_div">
  <!-- table head -->
  <thead>
  <tr><!-- item -->
        <th>Name</th>
        <th>Description</th>
        <?php foreach($periods as $key=>$val){?>        
        <th><span class="right"><?=ucwords($val)?></span></th>
        <?php }?>
   </tr>
  </thead>
   <!-- table items -->
    <tbody>
    <?php foreach($packages as $row):	?>
        <tr><!-- item -->
            <td><?=$row['name']?></td>
            <td><?=$row['description']?></td>
			<?php foreach($periods as $key=>$val){?>        
            <td align="right"><?php 
			$per=$row['slug']."-".strtolower(url_title($val, 'dash', TRUE));			
			$filter=array('slug'=>$per);
			$res=$CI->gradstate_package_pricing_model->find_one_array($filter);
			echo $price=$res['price'];			
			?>
            <button class="btn btn-primary btn-xs purchase-package" purchase-item="<?=$per?>">Purchase</button>
            </td>
            <?php }?>           
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
    <span>Sorry, we do not yet have premium packages for you to purchase. Please check later</span>
</div>
<?php }?>
</div>



</div>