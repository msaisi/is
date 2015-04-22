<?php

$logo=$logos_path.$institution['logo_picture'];

$pic=$profile_img_path.$institution['profile_picture'];

?>

<div class="col-md-12">



<form class="form-horizontal" data-parsley-validate method="post" action="account/save_prof_details" accept-charset="utf-8" enctype="multipart/form-data" > 
<div class="col-md-12 row">
<div class="col-md-4 white-row">                                 

<div class="about_header">

<i class="fa fa-picture-o"></i> Institution Logo

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



<div class="col-md-4 white-row">  

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


</div>


<div class="col-md-8 white-row" style="float:left;">



<div class="form-group">

	<label class="col-md-4 control-label">Institution Name</label>

    <div class="col-md-8">

    <input type="text" name="institution_name" placeholder="Institution name" class="bg-focus form-control" required value="<?=$institution['institution_name']?>">

    </div>

</div>

<div class="form-group">

      <label class="col-md-4 control-label">Contact Person</label>

      <div class="col-md-8">

      <input type="text" name="contact_person" placeholder="Contact person" class="bg-focus form-control" required value="<?=$institution['contact_person']?>">

      </div>

</div>

<div class="form-group">

      <label class="col-md-4 control-label">Email (Contact Person)</label>

      <div class="col-md-8">

      <input type="text" name="email" placeholder="Contact person's email address" class="bg-focus form-control" required value="<?=$institution['email']?>">

      </div>

</div>

<div class="form-group">

      <label class="col-md-4 control-label">Contacts (Contact Person)</label>

      <div class="col-md-8">

      <input type="text" name="contacts" placeholder="Contact person's contacts" class="bg-focus form-control" required value="<?=$institution['contacts']?>">

      </div>

</div>

<div class="form-group">

<div class="col-md-12">

 <h4>About <?=$institution['institution_name']?></h4>

 <hr class="gap gap-mini"/>

 </div>



  <div class="col-md-12">

    <textarea placeholder="Profile" rows="15" class="form-control" name="about"><?=$institution['about']?></textarea>

  </div>

</div>



<div class="col-md-12" align="center">

 	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Details</button>

</div>

 <input type="hidden" name="pic" id="pic" value="<?=$institution['profile_picture'];?>" >

 <input type="hidden" name="pic1" id="pic1" value="<?=$institution['logo_picture'];?>" >

 <input type="hidden" name="institution_id" id="institution_id" value="<?=$institution['institution_id'];?>" >

 </div>

 <?php  $CI->load->view('_blocks/security');?> 

</form>

</div>