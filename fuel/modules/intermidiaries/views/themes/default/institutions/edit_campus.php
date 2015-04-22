<?php $pic=$campus_path.$campus['profile_picture']; ?>
<div class="col-md-12">

<form class="form-horizontal" data-parsley-validate method="post" action="account/update_campus" accept-charset="utf-8" enctype="multipart/form-data" > 
<div class="col-md-8 white-row">
<div class="form-group">
	<label class="col-md-4 control-label">Profile Picture</label>
    <div class="col-md-8">
   <div class="fileinput fileinput-new col-md-7" data-provides="fileinput">
  <div class="fileinput-new thumbnail">
    <img src="<?=$pic?>" data-src="holder.js/100%x100%" alt="Profile picture here...">
  </div>
  <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"></div>
  <div>
     <span class="btn btn-default btn-file">
     <span class="fileinput-new">Select profile picture </span>
     <span class="fileinput-exists">Change</span>
     <input type="file" name="profile_picture"></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>  
    </div>
</div>

<div class="form-group">
	<label class="col-md-4 control-label">Campus Name</label>
    <div class="col-md-8">
    <input type="text" name="campus_name" placeholder="Campus Name" class="bg-focus form-control" required value="<?=$campus['campus_name']?>">
    </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Location</label>
      <div class="col-md-8">
      <select name="location" id='location' required class="select_2 no-left no-right"s>
        <option value="">Select One...</option>        
       <?php foreach($counties as $key =>$val) {			
			$loc=$campus['location'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$loc"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Email</label>
      <div class="col-md-8">
      <input type="text" name="campus_email" placeholder="Campus email address" class="bg-focus form-control" required value="<?=$campus['campus_email']?>">
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Contacts</label>
      <div class="col-md-8">
      <input type="text" name="contacts" placeholder="Campus contacts" class="bg-focus form-control" required value="<?=$campus['contacts']?>">
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Postal Address</label>
      <div class="col-md-8">
      <input type="text" name="postal_address" placeholder="Campus postal address" class="bg-focus form-control" required value="<?=$campus['postal_address']?>">
      </div>
</div>
<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Update Details</button>
</div>
 <input type="hidden" name="pic" id="pic" value="<?=$campus['profile_picture'];?>" >
 <input type="hidden" name="institution_id" id="institution_id" value="<?=$campus['institution_id'];?>" >
 <input type="hidden" name="campus_id" id="campus_id" value="<?=$campus['campus_id'];?>" >
 </div>
 <?php  $CI->load->view('_blocks/security');?> 
</form>
</div>