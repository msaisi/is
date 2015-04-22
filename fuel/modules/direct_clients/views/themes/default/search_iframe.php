<?php 
$where=array('published'=>'yes');
$faculties=$CI->gradstate_faculties_model->options_list('id','name',$where);
$qualifications=$CI->gradstate_qualifications_model->options_list('id','name',$where);
$countries=$CI->gradstate_countries_model->options_list('id','name');
$counties=$CI->gradstate_counties_model->options_list('id','name');
$sectors=$CI->gradstate_sectors_model->options_list('id','name');
$course_types=$CI->gradstate_course_types_model->options_list('id','name');
$course_levels=$CI->gradstate_course_levels_model->options_list('id','name');
?>
<form class="white-row styleBackground" method="post" action="courses/search" target="_blank">
        
         <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Search text</label>
                    <input type="text" value="" class="form-control" id="str" name="str" placeholder="e.g. Accounting">
                </div>
            </div>
        </div>
        			
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Faculty</label>
                     <select name="f" id="f" class="form-control">                     
                        <option value="">Select...</option>
                        <?php foreach($faculties as $key=>$val):?>
                        <option value="<?=$key?>"><?=$val?></option>
                        <?php endforeach;?>
                        </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Qualification</label>
                    <select name="q" id="q" class="form-control">                     
                        <option value="">Select...</option>
                        <?php foreach($qualifications as $key=>$val):?>
                        <option value="<?=$key?>"><?=$val?></option>
                        <?php endforeach;?>
                        </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <label>Location</label>
                      <select name="l" id="l" class="form-control">                     
                        <option value="">Select...</option>
                        <?php foreach($counties as $key=>$val):?>
                        <option value="<?=$key?>"><?=$val?></option>
                        <?php endforeach;?>
                        </select>
                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-md-12" align="center">                
                <button type="submit" class="btn btn-primary push-bottom btn-sm" data-loading-text="Loading..."><i class="fa fa-search"></i>Search courses</button>
                
            </div>
        </div>
    
 <?php  $CI->load->view('_blocks/security');?> 
</form>