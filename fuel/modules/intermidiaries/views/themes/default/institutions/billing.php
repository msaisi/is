<div class="col-md-12">
<div class="col-md-12 white-row">
<div class="col-md-9">
<div class="about_header">
<i class="fa fa-list-alt"></i> Billing Information
<hr/>
</div>
<form class="form-horizontal" data-validate="parsley" method="post" action="account/make_payment" >

<div class="form-group">
      <label class="col-md-4 control-label">Institution Name</label>
      <div class="col-md-8">
      <input type="text" name="institution_name" placeholder="Institution name" class="bg-focus form-control" data-required="true" value="<?=$institution['institution_name']?>" readonly="readonly">
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Account Holder</label>
      <div class="col-md-8">
      <input type="text" name="contact_person" placeholder="Your names" class="bg-focus form-control" data-required="true" value="<?=$institution['contact_person']?>" readonly="readonly">
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Email (Account Holder)</label>
      <div class="col-md-8">
      <input type="text" name="email" placeholder="Account holder's email address" class="bg-focus form-control" data-required="true" value="<?=$institution['email']?>" readonly="readonly">
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Phone Number (Account Holder)</label>
      <div class="col-md-8">
      <input type="text" name="contacts" placeholder="Account holder's contacts" class="bg-focus form-control" data-required="true" value="<?=$institution['contacts']?>" readonly="readonly">
      </div>
</div> 

<div class="form-group">
      <label class="col-md-4 control-label">Postal Address</label>
      <div class="col-md-8">
      <input type="text" name="postal_address" placeholder="Postal Address" class="bg-focus form-control" data-required="true" value="<?=$institution['postal_address']?>" readonly="readonly">
      </div>
</div> 
<div class="form-group">
      <label class="col-md-4 control-label">Amount</label>
      <div class="col-md-8">
      <input type="text" name="amount" placeholder="amount" class="bg-focus form-control" data-required="true" value="<?=cart_total()?>" readonly="readonly">
      </div>
</div> 
<hr class="gap gap-mini"/>
<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit"><i class="fa fa-hand-o-right"></i> Proceed to Payment</button>
</div>
 <?php  $CI->load->view('_blocks/security');?> 
 <input type="hidden" name="type" value="MERCHANT" />
  <input type="hidden" name="order_id" value="<?=$order_id?>"/>
</form>
</div>
<div class="col-md-3">
<?php  
 $data['v']="display";
$CI->load->view('_blocks/shopping_cart',$data);?> 		
</div>

</div>
</div>