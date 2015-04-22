<?php
$course=$course_details['course'];
$my_campuses=$course_details['campuses'];
$my_locations=$course_details['locations'];
$my_course_sectors=$course_details['course_sectors'];
$my_class_hours=$course_details['class_hours'];
$my_course_types=$course_details['course_types'];
$my_course_levels=$course_details['course_levels'];
?>
<div class="col-md-12">

<form class="form-horizontal"  data-parsley-validate method="post" action="account/update_course" accept-charset="utf-8" enctype="multipart/form-data" > 

<div class="col-md-8 white-row">
<div class="about_header">
<i class="fa fa-book"></i> Course Details
<hr/>
</div> 

<div class="form-group">
	<label class="col-md-4 control-label">Course Title</label>
    <div class="col-md-8">
    <input type="text" name="course_title" placeholder="Course Title" class="bg-focus form-control" required value="<?=$course['course_title']?>">
    </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Campuses</label>
      <div class="col-md-8">
        <select name="campuses[]" size="8" multiple id='campus'  class="select_2 no-left no-right col-md-12" required>      
        <?php foreach($campuses as $key =>$val) {?>               
         <option value="<?=$key?>" <?php 
		foreach($my_campuses as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>     
        <?php }?>
        </select>      
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Faculty</label>
      <div class="col-md-8">
      <select name="faculty" id='faculty' required class="select_2 no-left no-right">
        <option value="">Select One...</option>        
        <?php foreach($faculties as $key =>$val) {
			$fac=$course['faculty'];
			?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$fac"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Qualification Type</label>
      <div class="col-md-8">
      <select name="qualification_type" id='qualification_type' required class="select_2 no-left no-right">
        <option value="">Select One...</option>        
        <?php foreach($qualification_types as $key =>$val) {
			$qual=$course['qualification_type'];
			?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$qual"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
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
			$ctry=$course['country'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$ctry"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Locations</label>
      <div class="col-md-8">
      <select name="locations[]" id='locations' required class="select_2 no-left no-right col-md-12" size="8" multiple>    
       <?php foreach($counties as $key =>$val) {?>               
        <option value="<?=$key?>" <?php 
		foreach($my_locations as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>               
        <?php }?>     
        
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Sectors</label>
      <div class="col-md-8">
      <select name="course_sectors[]" id='course_sectors' required class="select_2 no-left no-right col-md-12" multiple size="8">    
        <?php foreach($sectors as $key =>$val) {?>   
        <option value="<?=$key?>" <?php 
		foreach($my_course_sectors as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Class Hours</label>
      <div class="col-md-8">
      <select name="class_hours[]" id='class_hours' required class="select_2 no-left no-right col-md-12" multiple size="8">    
        <?php foreach($class_hrs as $key =>$val) {?>
                
        <option value="<?=$key?>" <?php 
		foreach($my_class_hours as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>        
        
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Course Type</label>
      <div class="col-md-8">
      <select name="course_types[]" id='course_types' required class="select_2 no-left no-right col-md-12"multiple size="8">    
        <?php foreach($course_types as $key =>$val) {?>
         <option value="<?=$key?>" <?php 
		foreach($my_course_types as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>
        <?php }?>
        </select> 
      </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Course Levels</label>
      <div class="col-md-8">
      <select name="course_levels[]" id='course_levels' required class="select_2 no-left no-right col-md-12"multiple size="8">    
        <?php foreach($course_levels as $key =>$val) {?>
        <option value="<?=$key?>" <?php 
		foreach($my_course_levels as $m_a=>$b_m):
		if (!(strcmp("$key", "$b_m"))) {echo "selected=\"selected\"";}		
        endforeach;
		 ?>><?=$val?></option>
        
        <?php }?>
        </select> 
      </div>
</div><!--
<div class="form-group">
      <label class="col-md-4 control-label">Registration Deadline</label>
      <div class="col-md-4" id="sandbox-container">
      
        <input type="text" name="registration_deadline" placeholder="Registration Deadline" class="bg-focus form-control" required value="< ?=$course['registration_deadline']?>">
        
        </div>
</div>-->
<div class="form-group">
      <label class="col-md-4 control-label">Course Duration</label>
      <div class="col-md-2">      
        <input type="number" min="0" name="course_duration_fig" class="bg-focus form-control" required value="<?=$course['course_duration_fig']?>">        
        </div>
        <div class="col-md-3">      
         <select name="course_duration_per" id='course_duration_per' required class="select_2 no-left no-right col-md-12">    
          <option value="">Select one</option>
        <?php foreach($periods as $key =>$val) {        
        $per=$course['course_duration_per'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$per"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        
        
        
        <?php }?>
        </select>  
        </div>
        
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Intake Dates</label>
      <div class="col-md-8">
      
       <textarea placeholder="Intake dates" rows="15" class="form-control" name="intake_dates">
       <?=$course['intake_dates']?></textarea>
        </div>
</div>


<div class="form-group">
      <label class="col-md-4 control-label">Course Fees</label>
       <div class="col-md-2">      
         <select name="currency" id='currency' required class="select_2 no-left no-right col-md-12">    
          <option value="">Select one</option>
        <?php foreach($currency as $key =>$val) {        
         $cur=$course['currency'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$cur"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        
        <?php }?>
        </select>  
        </div>
      <div class="col-md-3">      
        <input type="text" name="fees_amount" class="bg-focus form-control" required value="<?=$course['fees_amount']?>">        
        </div>
         <div class="col-md-3">      
         <select name="payment_period" id='payment_period' required class="select_2 no-left no-right col-md-12">    
          <option value="">Select one</option>
        <?php foreach($pmnt_per as $key =>$val) {
         $pmnt=$course['payment_period'];?>
        <option value="<?=$key?>" <?php if (!(strcmp("$key", "$pmnt"))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
        <?php }?>
        </select>  
        </div>
       
        
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Description</label>
      <div class="col-md-8">
      
       <textarea placeholder="Description" rows="15" class="form-control" name="description"><?=$course['description']?></textarea>
        
        </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Eligibility</label>
      <div class="col-md-8">
      
       <textarea placeholder="Eligibility" rows="15" class="form-control" name="eligibility"><?=$course['eligibility']?></textarea>
        
        </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">How to apply</label>
      <div class="col-md-8">
      
       <textarea placeholder="How to apply" rows="15" class="form-control" name="how_to_apply"><?=$course['how_to_apply']?></textarea>
        
        </div>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Application form</label>
      <div class="col-md-8">
        <input name="application_form" type="file">
        
        <?php if($course['application_form'])
		{?>
			<strong><a href="<?=$application_path.$course['application_form']?>" target="_blank"><i class="fa fa-folder-open-o"></i> View application form</a></strong>
		<?php }
		?>
        
        </div>
</div>
<div class="col-md-12" align="center">
 	<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Details</button>
</div>
 <input type="hidden" name="app_form" id="app_form" value="<?=$course['application_form']?>" >
 <input type="hidden" name="course_id" id="course_id" value="<?=$course['course_id']?>" >
 <!--<input type="hidden" name="active" id="active" value="no" >-->
 <input type="hidden" name="institution_id" id="institution_id" value="<?=$institution['institution_id'];?>" >
 </div>
 <?php  $CI->load->view('_blocks/security');?> 
</form>
</div>