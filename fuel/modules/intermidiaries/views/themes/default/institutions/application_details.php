<div class="col-md-12">
<div class="col-md-8 white-row">
<div class="about_header">
<i class="fa fa-file-o"></i> Downloaded Form Details
<hr/>
</div> 
<div class="form-group">
      <label class="col-md-4 control-label">Form Serial</label>      
      <span class="col-md-8"><?=$dload_form['form_serial']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Course Title</label>      
      <span class="col-md-8"><?php 
	$res=$ci->gradstate_courses_model->find_one_array(array('course_id'=>$dload_form['course_id']));
	echo !empty($res)?$res['course_title']:"#old serial";?></span>
</div>


<div class="form-group">
	<label class="col-md-4 control-label">Names</label>
    <span class="col-md-8"><?=$dload_form['first_name']." ".$dload_form['last_name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Age</label>
       <span class="col-md-8"><?=$dload_form['age']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Gender</label>
       <span class="col-md-8"><?=$dload_form['gender']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Country</label>
      <span class="col-md-8"><?php 
	$res=$ci->gradstate_countries_model->find_one_array(array('id'=>$dload_form['country']));
	echo $res['name']?></span>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Location</label>      
      <span class="col-md-8"><?php 
	$res=$ci->gradstate_counties_model->find_one_array(array('id'=>$dload_form['locations']));
	echo $res['name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Email</label>      
      <span class="col-md-8"><?=$dload_form['email']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Contacts</label>      
      <span class="col-md-8"><?=$dload_form['contacts']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Highest Education Qualification</label>
     <span class="col-md-8"><?php 
	$res=$ci->gradstate_qualifications_model->find_one_array(array('id'=>$dload_form['qualification']));
	echo $res['name']?></span>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Current Job Title</label> 
  <span class="col-md-8"><?=$dload_form['current_job_title']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Faculty of Interest</label>     
    <span class="col-md-8"><?php 
	$res=$ci->gradstate_faculties_model->find_one_array(array('id'=>$dload_form['faculty_of_interest']));
	echo $res['name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Job Sector of Interest</label>     
    <span class="col-md-8"><?php 
	$res=$ci->gradstate_sectors_model->find_one_array(array('id'=>$dload_form['job_sector_of_interest']));
	echo $res['name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Experience</label>     
    <span class="col-md-8"><?=$dload_form['experience']?></span>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Download Date</label> 
  <span class="col-md-8"><?=format_full_date($dload_form['download_date'])?></span>
</div>

</div>
</div>