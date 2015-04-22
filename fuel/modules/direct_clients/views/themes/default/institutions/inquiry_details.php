<div class="col-md-12">
<div class="col-md-8 white-row">
<div class="about_header">
<i class="fa fa-question-circle"></i> International University Inquiry Details
<hr/>
</div> 
<div class="form-group">
      <label class="col-md-4 control-label">University Name</label>      
      <span class="col-md-8">
	  <?php 
	$res=$ci->gradstate_international_universities_model->find_one_array(array('institution_id'=>$inquiry['institution_id']));
	if(empty($res))
	{
		$res=$ci->gradstate_institutions_model->find_one_array(array('institution_id'=>$inquiry['institution_id']));
	}
	
	echo !empty($res)?$res['institution_name']:"n/a"?></span>
</div>

<div class="form-group">
	<label class="col-md-4 control-label">Names</label>
    <span class="col-md-8"><?=$inquiry['first_name']." ".$inquiry['last_name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Age</label>
       <span class="col-md-8"><?=$inquiry['age']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Gender</label>
       <span class="col-md-8"><?=$inquiry['gender']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Country</label>
      <span class="col-md-8"><?php 
	$res=$ci->gradstate_countries_model->find_one_array(array('id'=>$inquiry['country']));
	echo $res['name']?></span>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">County</label>      
      <span class="col-md-8"><?php 
	$res=$ci->gradstate_counties_model->find_one_array(array('id'=>$inquiry['location']));
	echo $res['name']?></span>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Nationality</label>
      <span class="col-md-8"><?php 
	$res=$ci->gradstate_countries_model->find_one_array(array('id'=>$inquiry['nationality']));
	echo $res['name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Email</label>      
      <span class="col-md-8"><?=$inquiry['email']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Contacts</label>      
      <span class="col-md-8"><?=$inquiry['contacts']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Highest Education Qualification</label>
     <span class="col-md-8"><?php 
	$res=$ci->gradstate_qualifications_model->find_one_array(array('id'=>$inquiry['qualification']));
	echo $res['name']?></span>
</div>
<div class="form-group">
      <label class="col-md-4 control-label">Faculty of Interest</label>     
    <span class="col-md-8"><?php 
	$res=$ci->gradstate_faculties_model->find_one_array(array('id'=>$inquiry['faculty']));
	echo $res['name']?></span>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Inquiry Date</label> 
  <span class="col-md-8"><?=format_full_date($inquiry['inquiry_date'])?></span>
</div>

</div>
</div>