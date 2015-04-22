<div class="col-md-12">
<form class="form-horizontal" id="download" data-parsley-validate method="post" action="courses/do_download"> 

<div class="col-md-8 white-row">
<div class="about_header">
<i class="fa fa-book"></i> Applicants Details
<hr/>
</div> 

<div class="form-group">
	<label class="col-md-4 control-label">First Name</label>
    <div class="col-md-8">
    <input type="text" name="first_name" placeholder="First Name" class="bg-focus form-control" required>
    </div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Last Name</label>
    <div class="col-md-8">
    <input type="text" name="last_name" placeholder="Last Name" class="bg-focus form-control" required>
    </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Age</label>
      <div class="col-md-8">
      <select name="age" id='age' required class="select_2 no-left no-right col-md-4">
        <option value="">Select One...</option>        
        <?php foreach($ages as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Gender</label>
      <div class="col-md-8">
      <select name="gender" id='gender' required class="select_2 no-left no-right col-md-5">
        <option value="">Select One...</option>  
        <option value="male">Male</option>
        <option value="female">Female</option>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Country</label>
      <div class="col-md-8">
      <select name="country" id='country' required class="select_2 no-left no-right"s>
        <option value="">Select One...</option>        
        <?php foreach($countries as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Location</label>
      <div class="col-md-8"> 
      <select name="locations" id='locations' required class="select_2 no-left no-right col-md-5">   
      <option value="">Select One...</option>  
      </select> 
      </div>
</div>

<div class="form-group">
	<label class="col-md-4 control-label">Email</label>
    <div class="col-md-8">
    <input type="email" name="email" placeholder="Email address" class="bg-focus form-control" required>
    </div>
</div>

<div class="form-group">
	<label class="col-md-4 control-label">Contacts</label>
    <div class="col-md-8">
    <input type="text" name="contacts" placeholder="Contacts" class="bg-focus form-control" required>
    </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Highest education qualification</label>
      <div class="col-md-8">
        <select name="qualification" id='qualification'  class="select_2 no-left no-right" required>
         <option value="">Select One...</option> 
		<?php foreach($qualification_types as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select>      
      </div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Current job title</label>
    <div class="col-md-8">
    <input type="text" name="current_job_title" placeholder="Current job title" class="bg-focus form-control" required>
    </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Faculty of interest</label>
      <div class="col-md-8">
      <select name="faculty_of_interest" id='faculty_of_interest' required class="select_2 no-left no-right">
        <option value="">Select One...</option>        
        <?php foreach($faculties as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Job sector of interest</label>
      <div class="col-md-8">
      <select name="job_sector_of_interest" id='job_sector_of_interest' required class="select_2 no-left no-right">    
      <option value="">Select One...</option>  
        <?php foreach($sectors as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Experience in years</label>
      <div class="col-md-8">
      <select name="experience" id='experience' required class="select_2 no-left no-right col-md-4">    	<option value="">Select One...</option>  
        <?php foreach($experience as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>


<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit" id="download_form"><i class="fa fa-download"></i>Proceed to download</button>
</div>
 <input type="hidden" name="course_id" id="slug" value="<?=$course_id;?>" >
 </div>
 <?php  $CI->load->view('_blocks/security');?> 
</form>
</div>