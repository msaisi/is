<?php
$inst_twitter=get_twitter($institution['twitter']);
$facebook=trim($institution['facebook'])===""?$site_fb:$institution['facebook'];
?>
<script>
twitter_username = '<?=$inst_twitter?>';
ticker_tweet_count_max = 20;
</script>

<div class="col-md-12">
<div class="col-md-4">

<div class="col-md-12 line-border white-row dashboard-div">
<div class="about_header">
<i class="fa fa-info"></i> My Contact Information

<i><a href="account/profile"><span class="fa fa-pencil-square-o pull-right"> Edit</span></a></i>

<hr/>
</div>
<div class="col-md-8 profile_photo_small">
<img src="<?=$profile_img_path.$institution['profile_picture']?>" alt="<?=$institution['institution_name']?>"/>
</div>

<div class="col-md-12 no-left no-right">
<table class="table table-striped contacts_div">
  <!-- table head -->
   <!-- table items -->
    <tbody>
        <tr><!-- item -->
            <td>Phone</td>
            <td><?=$institution['institution_contacts'];?></td>
        </tr>
        <tr><!-- item -->
            <td>Email</td>
            <td><?=trim($institution['institution_email'])!==""?"<a href=\"".mail_to($institution['institution_email'])."\" >".$institution['institution_email']."</a>":"";?></td>
        </tr>
        <tr><!-- item -->
            <td>Website</td>
            <td><?=trim($institution['website'])!==""?"<a href=\"".ext_link($institution['website'])."\" target=\"_blank\">".$institution['website']."</a>":"";?></td>
        </tr>
         <tr><!-- item -->
            <td>Facebook</td>
            <td><?=trim($institution['facebook'])!==""?"<a href=\"".ext_link($institution['facebook'])."\" target=\"_blank\">".$institution['facebook']."</a>":"";?></td>
        </tr>
         <tr><!-- item -->
            <td>Twitter</td>
            <td><?=trim($institution['twitter'])!==""?"<a href=\"".ext_link($institution['twitter'])."\" target=\"_blank\">".$institution['twitter']."</a>":"";?></td>
        </tr>
         
    </tbody>
</table>
</div>

</div>

</div>
<div class="col-md-4">
<div class="col-md-12 inst_desc line-border white-row dashboard-div">
<div class="about_header">
<i class="fa fa-building-o"></i> My Universities
<i><a href="account/university_add"><span class="fa fa-plus-square pull-right"> Add</span></a></i>
<i><a href="account/universities"><span class="fa fa-folder-open-o pull-right"> Open</span></a> &nbsp;</i>
<hr/>
</div>
<div class="col-md-12 univ-list no-padding no-margin">
<table class="table table-striped table-hover contacts_div">
  <!-- table head -->
  <thead>
  <tr><!-- item -->
        <th>University Name</th>
        <th>Is Active</th>
   </tr>
  </thead>
   <!-- table items -->
    <tbody>
    <?php if(!empty($universities))
	{
		foreach($universities as $row):
		?>
        <tr><!-- item -->
            <td><a href="account/university_details/<?=$row['institution_id']?>"><?=$row['institution_name'];?></a></td>
            <td><?=$row['is_active'];?></td>
        </tr>
       <?php 
	   endforeach;
	   }
	   else
	   {?> 
        <tr class="danger"><!-- item -->
            <td colspan="2"><span class="red">No universities added yet.</span></td>
        </tr>
       <?php }?>
       
    </tbody>
</table>
</div>
</div>



</div>
<div class="col-md-4">
<div class="col-md-12  line-border white-row dashboard-div">

<div class="about_header">
<i class="fa fa-question-circle"></i> My Inquiries
<i><a href="account/inquiries"><span class="fa fa-folder-open-o pull-right"> Open</span></a> &nbsp;</i>
<hr/>
</div>
<table class="table table-striped table-hover contacts_div">
    <!-- table items -->
    <tbody>
   
        <tr><!-- item -->
            <td>Received Inquiries: <?=$inquiries;?></td>
        </tr>
            
    </tbody>
</table>

</div>
</div>

<div class="col-md-4">
<div class="col-md-12 inst_desc line-border white-row dashboard-div">
<div class="gap gap-mini"></div> 
<div class="about_header">
<i class="fa fa-magic"></i> Clicks
<i><a href="account/clicks"><span class="fa fa-folder-open-o pull-right"> Open</span></a> &nbsp;</i>
<hr/>
</div>
<table class="table table-striped table-hover contacts_div">
<thead>
  <tr><!-- item -->
        <th>Item</th>
        <th>Count</th>
   </tr>
  </thead>
    <!-- table items -->
    <tbody>
   
        <tr><!-- item -->
            <td>Inquiries Clicks:</td>
            <td><?=get_count($institution['institution_id'],'Inquiry Click')?></td>
        </tr>
        <tr><!-- item -->
            <td>Homepage Uniserv box Clicks:</td>
            <td><?=get_count($institution['institution_id'],'Homepage Uniserv Click')?></td>
        </tr>
         <tr><!-- item -->
            <td>International Universities Clicks:</td>
            <td><?=get_count($institution['institution_id'],'International University Click')?></td>
        </tr>
        
            
    </tbody>
</table>

</div>
</div>
<div class="col-md-4 hidden-xs hidden-sm social-media">
  <h3 class="page-header">
    <i class="fa fa-facebook"></i> Latest <strong class="styleColor">Updates</strong> 
  </h3>
  <div class="col-md-12">
      <div class="fb-like-box" data-href="<?=$facebook?>" data-width="263" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false">
      </div>
  </div>
</div>
 <div class="col-md-4 hidden-xs hidden-sm social-media">
   <h3 class="page-header">
    <i class="fa fa-twitter"></i> 
    Latest <strong class="styleColor">Tweets</strong> 
  </h3>
        <!-- START TWITTER -->
        <div class="twitter-ticker" id="twitter-ticker"></div>
        <!-- END TWITTER -->
  </div>

</div>