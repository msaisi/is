<div class="col-md-12">
<form class="form-horizontal" data-parsley-validate method="post" action="account/add_campus" accept-charset="utf-8" enctype="multipart/form-data" > 
<div class="col-md-8 white-row">
<div class="form-group">
	<label class="col-md-4 control-label">Profile Picture</label>
    <div class="col-md-8">
   <div class="fileinput fileinput-new col-md-7" data-provides="fileinput">
  <div class="fileinput-new thumbnail">
    <img src="assets/images/avatar.png" data-src="holder.js/100%x100%" alt="Profile picture here...">
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
    <input type="text" name="campus_name" placeholder="Campus Name" class="bg-focus form-control" required>
    </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Location</label>
      <div class="col-md-8">
      <select name="location" id='location' required class="select_2 no-left no-right"s>
        <option value="">Select One...</option>        
       <?php foreach($counties as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Email</label>
      <div class="col-md-8">
      <input type="text" name="campus_email" placeholder="Campus email address" class="bg-focus form-control" required>
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Contacts</label>
      <div class="col-md-8">
      <input type="text" name="contacts" placeholder="Campus contacts" class="bg-focus form-control" required>
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Postal Address</label>
      <div class="col-md-8">
      <input type="text" name="postal_address" placeholder="Campus postal address" class="bg-focus form-control" required>
      </div>
</div>
<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Submit Details</button>
</div>
 <input type="hidden" name="pic" id="pic" value="" >
 <input type="hidden" name="institution_id" id="institution_id" value="<?=$institution['institution_id'];?>" >
 </div>
 <?php  $CI->load->view('_blocks/security');?> 
</form>
</div>