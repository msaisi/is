<?php
$course=$course_details['course'];
$my_campuses=$course_details['campuses'];
$my_locations=$course_details['locations'];
$my_course_sectors=$course_details['course_sectors'];
$my_class_hours=$course_details['class_hours'];
$my_course_types=$course_details['course_types'];
$my_course_levels=$course_details['course_levels'];

$inst=$this->gradstate_institutions_model->find_one_array(array("institution_id"=>$course['institution_id']));
?>
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5209d27922df6141" async="async"></script>
-->
<script type="text/javascript">
//<![CDATA[
  (function() {
    var shr = document.createElement('script');
    shr.setAttribute('data-cfasync', 'false');
    shr.src = '//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js';
    shr.type = 'text/javascript'; shr.async = 'true';
    shr.onload = shr.onreadystatechange = function() {
      var rs = this.readyState;
      if (rs && rs != 'complete' && rs != 'loaded') return;
      var site_id = '0c091e8807fc149fc385c97b49408b93';
      try { Shareaholic.init(site_id); } catch (e) {}
    };
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(shr, s);
  })();
//]]>
</script>



<div class="col-md-12">
<div class="col-md-3 white-row">
<?php  $ci->load->view('_blocks/simple_search');?> 
</div>
<div class="col-md-9 white-row">
<div class="about_header">
<i class="fa fa-book"></i> Course Details
<hr/>
</div> 
<div class="course_details_section">
<div class="col-md-9 col-sm-9">
<div class="form-group">
	<label class="col-md-3 control-label">Course Title</label>
    <span class="col-md-9"><?=$course['course_title']?></span>
</div>
<div class="form-group">
      <label class="col-md-3 control-label">Campuses</label>
      <div class="col-md-9">
      <ul class="col-md-12 course_view no-padding">
      <?php if(!empty($my_campuses)){?>
       	<?php foreach ($my_campuses as $key => $val):
			$res=$ci->gradstate_campuses_model->find_one_array(array('campus_id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['campus_name']?></li>
        <?php		
		 endforeach;?>
         <?php } else {?>
          <li>n/a</li>
         <?php }?>
      </ul>
       
      </div>
</div>
<div class="form-group">
      <label class="col-md-3 control-label">Faculty</label>
     
    <span class="col-md-9"><?php 
	$res=$ci->gradstate_faculties_model->find_one_array(array('id'=>$course['faculty']));
	if($res)
  {
    echo $res['name'];
  }
  ?></span>
</div>
<div class="form-group">
      <label class="col-md-3 control-label">Qualification Type</label>
     <span class="col-md-9"><?php $res=$ci->gradstate_qualifications_model->find_one_array(array('id'=>$course['qualification_type']));
	if($res)
  {
    echo $res['name'];
  }
  ?></span>
</div>
<div class="form-group">
      <label class="col-md-3 control-label">Country</label>
      <span class="col-md-9"><?php 
	$res=$ci->gradstate_countries_model->find_one_array(array('id'=>$course['country']));
	if($res)
  {
    echo $res['name'];
  }
  ?></span>
</div>

<div class="form-group">
      <label class="col-md-3 control-label">Locations</label>
      <div class="col-md-9">
     	<ul class="col-md-12 course_view no-padding">
       	<?php foreach ($my_locations as $key => $val):
			$res=$ci->gradstate_counties_model->find_one_array(array('id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['name']?></li>
        <?php
		
		 endforeach;?>
      	</ul>
      </div>
</div>

<div class="form-group">
      <label class="col-md-3 control-label">Sectors</label>
      <div class="col-md-9">
      <ul class="col-md-12 course_view no-padding">
       	<?php foreach ($my_course_sectors as $key => $val):
			$res=$ci->gradstate_sectors_model->find_one_array(array('id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['name']?></li>
        <?php
		
		 endforeach;?>
      	</ul>
      </div>
</div>

<div class="form-group">
      <label class="col-md-3 control-label">Class Hours</label>
      <div class="col-md-9">
      <ul class="col-md-12 course_view no-padding">
       	<?php foreach ($my_class_hours as $key => $val):
			$res=$ci->gradstate_class_types_model->find_one_array(array('id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['name']?></li>
        <?php		
		 endforeach;?>
      	</ul>
      </div>
</div>

<div class="form-group">
      <label class="col-md-3 control-label">Course Type</label>
      <div class="col-md-9">
     <ul class="col-md-12 course_view no-padding">
       	<?php foreach ($my_course_types as $key => $val):
			$res=$ci->gradstate_course_types_model->find_one_array(array('id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['name']?></li>
        <?php		
		 endforeach;?>
      	</ul>
      </div>
</div>

<div class="form-group">
      <label class="col-md-3 control-label">Course Levels</label>
      <div class="col-md-9">
      <ul class="col-md-12 course_view no-padding">
       	<?php foreach ($my_course_levels as $key => $val):
			$res=$ci->gradstate_course_levels_model->find_one_array(array('id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['name']?></li>
        <?php		
		 endforeach;?>
      	</ul>
      </div>
</div>
<!--<div class="form-group">
  <label class="col-md-3 control-label">Registration Deadline</label> 
  <span class="col-md-9">< ?=format_full_date($course['registration_deadline'])?></span>
</div>-->
<div class="form-group">
  <label class="col-md-3 control-label">Course Duration</label>
  <span class="col-md-9"><?=$course['course_duration_fig']." ".$course['course_duration_per']?></span> 
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Intake Dates</label>
  <span class="col-md-9"><?=$course['intake_dates']?></span>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Course Fees</label>
  <span class="col-md-9"><?=$course['currency']." ".number_format($course['fees_amount'],2)." ".$course['payment_period']?></span> 
</div>
<div class="form-group">
      <label class="col-md-3 control-label">Description</label>
      <span class="col-md-9"><?=$course['description']?></span>
</div>
<div class="form-group">
      <label class="col-md-3 control-label">Eligibility</label>
       <span class="col-md-9"><?=$course['eligibility']?></span>
</div>

<div class="form-group">
      <label class="col-md-3 control-label">How to apply</label>
       <span class="col-md-9"><?=$course['how_to_apply']?></span>
</div></div>
<div class="col-md-3 col-sm-3 inst_logo_course_list hidden-xs">   
   <a href="institutions/<?=$inst['slug']?>" title="<?=$inst['institution_name']?>">   
   <img alt="" src="<?=$img_path.$inst['logo_picture']?>">
    <span class="inner">            
        <strong><?=$inst['institution_name']?></strong>
    </span>
   </a>
   </div>
</div>
<div class="form-group">
      <label class="col-md-3 control-label"><br />
      Application form</label>
      <div class="col-md-9">        
        <p>
          <?php if($course['application_form'])
		{?>
        </p>
        <p>          <strong><a class="btn btn-primary btn-xs" href="courses/download?ref=<?=$course['course_id']?>" ><i class="fa fa-download"></i>Download Form</a></strong></p>
            
		<?php }
		?>
        
      </div>
</div>

 </div>
 
 </div>