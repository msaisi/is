<?php
$university=$university_details['university'];
$my_faculties=$university_details['faculties'];
$my_qualifications=$university_details['qualifications'];
$logo=$logos_path.$university['logo_picture'];
$pic=$profile_img_path.$university['profile_picture'];
$accounts=$this->fuel->gradstate->inst_types();
?>
<div class="col-md-12">

<form class="form-horizontal"  data-parsley-validate method="post" action="account/update_university" accept-charset="utf-8" enctype="multipart/form-data" > 

<div class="col-md-9 white-row">
<div class="about_header">
<i class="fa fa-book"></i> University Details
<hr/>
</div>
<div class="col-md-6 white-row">                                 
<div class="about_header">
<i class="fa fa-picture-o"></i> Logo
<hr/>
</div>                          
  <div class="fileinput fileinput-new col-md-7" data-provides="fileinput">
  <div class="fileinput-new thumbnail">
    <img src="<?=$logo?>" data-src="holder.js/100%x100%" alt="Profile logo here...">
  </div>
  <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"></div>
  <div>
     <span class="btn btn-default btn-file">
     <span class="fileinput-new">Select logo </span>
     <span class="fileinput-exists">Change</span>
     <input type="file" name="logo_picture"></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>         
</div>

<div class="col-md-6 white-row">  
<div class="about_header">
<i class="fa fa-picture-o"></i> Profile Picture
<hr/>
</div>                                  
                          
  <div class="fileinput fileinput-new col-md-7" data-provides="fileinput">
  <div class="fileinput-new thumbnail">
    <img src="<?=$pic?>" data-src="holder.js/100%x100%" alt="Profile image here...">
  </div>
  <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"></div>
  <div>
     <span class="btn btn-default btn-file">
     <span class="fileinput-new">Select profile image </span>
     <span class="fileinput-exists">Change</span>
     <input type="file" name="profile_picture"></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>        
</div>


<div class="form-group">
	<label class="col-md-4 control-label">Universty Name</label>
    <div class="col-md-8">
    <input type="text" name="institution_name" placeholder="University Name" class="bg-focus form-control" required value="<?=$university['institution_name']?>">
    </div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Official Address</label>
    <div class="col-md-8">
    <input type="email" name="official_address" placeholder="Official Address" class="bg-focus form-control" required value="<?=$university['official_address']?>">
    </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Account Type</label>
      <div class="col-md-8">
      <select name="account_type" id='account_type' required class="select_2 no-left no-right"s>
        <option value="">Select One...</option>        
        <?php foreach($accounts as $key =>$val) {			
			$ctry=$university['account_type'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$ctry"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Country</label>
      <div class="col-md-8">
      <select name="country" id='country' required class="select_2 no-left no-right"s>
        <option value="">Select One...</option>        
        <?php foreach($countries as $key =>$val) {			
			$ctry=$university['country'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$ctry"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Faculties</label>
      <div class="col-md-8">
        <select name="faculties[]" size="8" multiple id='faculty'  class="select_2 no-left no-right col-md-12" required>      
        <?php foreach($faculties as $key =>$val) {?>               
         <option value="<?=$key?>" <?php 
		foreach($my_faculties as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>     
        <?php }?>
        </select>      
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Qualification Types</label>
      <div class="col-md-8">
      <select name="qualifications[]" size="8" multiple id='qualification'  class="select_2 no-left no-right col-md-12" required>   
        <?php foreach($qualification_types as $key =>$val) {?>               
         <option value="<?=$key?>" <?php 
		foreach($my_qualifications as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>     
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Profile summary</label>
      <div class="col-md-8">
      
       <textarea placeholder="Profile summary" rows="15" class="form-control" name="about">
       <?=$university['about']?></textarea>
        </div>
</div>

<div class="form-group">
	<label class="col-md-4 control-label">Youtube Video Link</label>
    <div class="col-md-8">
    <input type="text" name="youtube_video" placeholder="Youtube Video Link" class="bg-focus form-control"  value="<?=$university['youtube_video']?>">
    </div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Website</label>
    <div class="col-md-8">
    <input type="text" name="website" placeholder="Website link" class="bg-focus form-control" value="<?=$university['website']?>">
    </div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Facebook</label>
    <div class="col-md-8">
    <input type="text" name="facebook" placeholder="Facebook link" class="bg-focus form-control" value="<?=$university['facebook']?>">
    </div>
</div>

<div class="form-group">
	<label class="col-md-4 control-label">Twitter</label>
    <div class="col-md-8">
    <input type="text" name="twitter" placeholder="Twitter link" class="bg-focus form-control" value="<?=$university['twitter']?>">
    </div>
</div>

<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Details</button>
</div>
  <input type="hidden" name="pic" id="pic" value="<?=$university['profile_picture'];?>" >
 <input type="hidden" name="pic1" id="pic1" value="<?=$university['logo_picture'];?>" >
 <input type="hidden" name="institution_id" id="institution_id" value="<?=$university['institution_id'];?>" >
 </div>
 <?php  $CI->load->view('_blocks/security');?> 
</form>
</div>