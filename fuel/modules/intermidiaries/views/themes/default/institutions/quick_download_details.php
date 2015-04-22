<div class="col-md-12">
<div class="col-md-8 white-row">
<div class="about_header">
<i class="fa fa-download"></i> Downloaded Form Details
<hr/>
</div> 
<div class="form-group">
      <label class="col-md-4 control-label">Downloaded File Name</label>      
      <span class="col-md-8"><a href="<?=$form_src?>" target="_blank"><i class="fa fa-folder-open-o"></i> <?=$dload_form['file_name']?></a></span>
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
      <span class="col-md-8"><?=$dload_form['country']?></span>
</div>

<div class="form-group">
      <label class="col-md-4 control-label">Location</label>      
      <span class="col-md-8"><?=$dload_form['location']?></span>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Download Date</label> 
  <span class="col-md-8"><?=format_full_date($dload_form['download_date'])?></span>
</div>

</div>
</div>