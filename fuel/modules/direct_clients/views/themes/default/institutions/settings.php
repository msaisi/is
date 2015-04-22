<div class="col-md-12">
<div class="col-md-8 white-row">                                 
    <div class="about_header">
    <i class="fa fa-cog"></i> Account Passsword 
    <hr/>
    </div>                          
   <div class="alert alert-info">
    <i class="fa fa-exclamation-circle"></i> 
    <span>New password will take effect on your next login.</span>
    </div>      
   
   <form class="white-row" method="post" action="account/update_password" data-parsley-validate>


 <?php 
	 $my_arr=$this->session->flashdata('settings_item');
	 if(!empty($my_arr))
	 {
	  ?>
	 <div class="block">             
	 <div class="alert alert-<?=$my_arr['type']?>">
	   <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
	   <?=$my_arr['message']?>
	 </div>          
	 </div>
<?php } ?>

<label><strong>Current Password</strong></label>
<input name="old_password" id="old_password" type="password" class="col-md-12" placeholder="Current Password" required data-parsley-error-message="Please enter your current password." />

<label><strong>New Password</strong></label>
<input name="new_password" id="new_password" type="password" class="col-md-12" placeholder="New Password" required data-parsley-error-message="Please enter your new password." />

<label><strong>Confirm Password</strong></label>
<input name="confirm_password" id="confirm_password" type="password" class="col-md-12" placeholder="Confirm Password" required data-parsley-error-message="Please enter a confirm password." data-equalto="#new_password"/>

 <hr/>
 <button type="submit" class="btn btn-primary">Update Password</button>
 <?php  $CI->load->view('_blocks/security');?>   
</form>
</div>

<!--<div class="col-md-6 white-row">  
    <div class="about_header">
    <i class="fa fa-times"></i> Deactivate Account
    <hr/>
    </div> 
    
    <div class="alert alert-warning">
    <i class="fa fa-exclamation-circle"></i> 
    <span>Caution! Deativating your account will only disable login capabilities for your account but the account will not be removed. This will concequently prevent you from registering another account with the same email address used here. You will be signed out immediately.</span>
    </div>                                 
<form class="form-horizontal" method="post" action="account/deactivate"> 
<div class="col-md-12">
<button class="btn btn-danger" type="submit"><i class="fa fa-lock"></i> Deactivate accoount</button>
</div>
<input type="hidden" name="institution_id" id="institution_id" value="< ?=$institution['institution_id'];?>" >
<input type="hidden" name="is_active" id="is_active" value="no" >
< ?php  $CI->load->view('_blocks/security');?>         
</form>
</div>-->
</div>
</div>