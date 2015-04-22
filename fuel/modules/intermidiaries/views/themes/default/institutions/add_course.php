<div class="col-md-12">
<?php 
if($subscription>0)
{
?>
<?php 
if($free_slots>0)
{
?>
<form class="form-horizontal"  data-parsley-validate method="post" action="account/add_course" accept-charset="utf-8" enctype="multipart/form-data" > 

<div class="col-md-8 white-row">
<div class="about_header">
<i class="fa fa-book"></i> Course Details
<hr/>
</div> 

<div class="form-group">
	<label class="col-md-4 control-label">Course Title</label>
    <div class="col-md-8">
    <input type="text" name="course_title" placeholder="Course Title" class="bg-focus form-control" required>
    </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Campuses</label>
      <div class="col-md-8">
        <select name="campuses[]" size="8" multiple id='campuses[]'  class="select_2 no-left no-right col-md-12" required>      
        <?php foreach($campuses as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select>      
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Faculty</label>
      <div class="col-md-8">
      <select name="faculty" id='faculty' required class="select_2 no-left no-right">
        <option value="">Select One...</option>        
        <?php foreach($faculties as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Qualification Type</label>
      <div class="col-md-8">
      <select name="qualification_type" id='qualification_type' required class="select_2 no-left no-right">
        <option value="">Select One...</option>        
        <?php foreach($qualification_types as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
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
      <label class="col-md-4 control-label">Locations</label>
      <div class="col-md-8">
      <select name="locations[]" id='locations' required class="select_2 no-left no-right col-md-12" size="8" multiple>    
        
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Sectors</label>
      <div class="col-md-8">
      <select name="course_sectors[]" id='course_sectors' required class="select_2 no-left no-right col-md-12" multiple size="8">    
        <?php foreach($sectors as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Class Hours</label>
      <div class="col-md-8">
      <select name="class_hours[]" id='class_hours' required class="select_2 no-left no-right col-md-12" multiple size="8">    
        <?php foreach($class_hrs as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Course Type</label>
      <div class="col-md-8">
      <select name="course_types[]" id='course_types' required class="select_2 no-left no-right col-md-12"multiple size="8">    
        <?php foreach($course_types as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Course Levels</label>
      <div class="col-md-8">
      <select name="course_levels[]" id='course_levels' required class="select_2 no-left no-right col-md-12"multiple size="8">    
        <?php foreach($course_levels as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<!--<div class="form-group">
      <label class="col-md-4 control-label">Registration Deadline</label>
      <div class="col-md-4" id="sandbox-container">
      
        <input type="text" name="registration_deadline" placeholder="Registration Deadline" class="bg-focus form-control" required>
        
        </div>
</div>-->
<div class="form-group">
      <label class="col-md-4 control-label">Course Duration</label>
      <div class="col-md-2">      
        <input type="number" min="0" name="course_duration_fig" class="bg-focus form-control" required>        
        </div>
        <div class="col-md-3">      
         <select name="course_duration_per" id='course_duration_per' required class="select_2 no-left no-right col-md-12">    
          <option value="">Select one</option>
        <?php foreach($periods as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select>  
        </div>
        
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Intake Dates</label>
      <div class="col-md-8">
      
       <textarea placeholder="Intake dates" rows="15" class="form-control" name="intake_dates"></textarea>
        </div>
</div>


<div class="form-group">
      <label class="col-md-4 control-label">Course Fees</label>
       <div class="col-md-2">      
         <select name="currency" id='currency' required class="select_2 no-left no-right col-md-12">    
          <option value="">Select one</option>
        <?php foreach($currency as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select>  
        </div>
      <div class="col-md-3">      
        <input type="number" min="0" name="fees_amount" class="bg-focus form-control" required>        
        </div>
         <div class="col-md-3">      
         <select name="payment_period" id='payment_period' required class="select_2 no-left no-right col-md-12">    
          <option value="">Select one</option>
        <?php foreach($pmnt_per as $key =>$val) {?>
        <option value="<?=$key?>"><?=$val?></option>
        <?php }?>
        </select>  
        </div>
       
        
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Description</label>
      <div class="col-md-8">
      
       <textarea placeholder="Description" rows="15" class="form-control" name="description"></textarea>
        
        </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Eligibility</label>
      <div class="col-md-8">
      
       <textarea placeholder="Eligibility" rows="15" class="form-control" name="eligibility"></textarea>
        
        </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">How to apply</label>
      <div class="col-md-8">
      
       <textarea placeholder="How to apply" rows="15" class="form-control" name="how_to_apply"></textarea>
        
        </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Application form</label>
      <div class="col-md-8">
      
       <input name="application_form" type="file" required>
        
        </div>
</div>




<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Details</button>
</div>
 <input type="hidden" name="app_form" id="app_form" value="" >
 <input type="hidden" name="pending" id="pending" value="yes" >
 <input type="hidden" name="active" id="active" value="no" >
 <input type="hidden" name="institution_id" id="institution_id" value="<?=$institution['institution_id'];?>" >
 </div>
 <?php  $CI->load->view('_blocks/security');?> 
</form>
<?php }
else {?>
<div class="col-md-12">
<div class="alert alert-danger">
    <i class="fa fa-wrench"></i> 
    <span>Sorry, you have used up all  your allocated slots. You can increase the number of slots by purchasing another package or removing old courses.</span>
</div>
</div>
<?php }?>

<?php }
else {?>
<div class="col-md-12">
<div class="alert alert-danger">
    <i class="fa fa-wrench"></i> 
    <span>Sorry, you have not yet purchased any premium package. Please do so to enable this feature. <a href="account/packages"><strong>Buy Now</strong></a></span>
</div>
</div>
<?php }?>
</div>