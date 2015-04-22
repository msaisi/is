<?php
$institution=$university_details['university'];
$inst_twitter=get_twitter($institution['twitter']);
$facebook=trim($institution['facebook'])===""?$site_fb:$institution['facebook']; 
$faculties=$university_details['faculties'];
?>
<script>
twitter_username = '<?=$inst_twitter?>';
ticker_tweet_count_max = 20;
</script>
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5209d27922df6141" async="async"></script>-->
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
<br />
<div class="col-md-12">
<?php 
$my_vars['institution']=$institution;
$CI->load->view('_blocks/insts_topbar',$my_vars);?> 
<div class="gap gap-medium"></div>
<div class="col-md-12 line-border">
<div class="col-md-6 profile_photo">
<img src="<?=$profile_img.$institution['profile_picture']?>" alt="<?=$institution['institution_name']?>"/>
</div>
<div class="col-md-6 inst_desc">
<div class="about_header">
<i class="fa fa-comment-o"></i> About <?=$institution['institution_name']?>
<hr/>
</div>
<?=$institution['about'];?>
</div>

</div>


</div>

<div class="gap gap-medium"></div>
<div class="col-md-3" id="my_search_div">
<?php $CI->load->view('_blocks/int_univ_search');?> 
</div>

<div class="col-md-6 no-padding">
<div class="col-md-12"> <!--  line-border white-row -->
   <div class="about_header">
<i class="fa fa-info"></i> Faculties
<hr/>
</div>
      <div class="col-md-12">
      <ul class="col-md-12 course_view no-padding">
      <?php if(!empty($faculties)){?>
       	<?php foreach ($faculties as $key => $val):
			$res=$ci->gradstate_faculties_model->find_one_array(array('id'=>$val));
		?>
        <li><span class="fa fa-angle-double-right"></span> <?=$res['name']?></li>
        <?php		
		 endforeach;?>
         <?php } else {?>
          <li>n/a</li>
         <?php }?>
      </ul>
  </div>     
      </div>
</div>

<div class="col-md-3">
<div class="col-md-12  line-border white-row ">
<div class="about_header">
<i class="fa fa-info"></i> Contact Information
<hr/>
</div>
<div class="col-md-12 no-padding no-overflow">
<table class="table table-striped contacts_div table-responsive">
  <!-- table head -->
   <!-- table items -->
    <tbody>
        <tr><!-- item -->
            <td>Location</td>
            <td class="specifictd"><?=$institution['official_address'];?></td>
        </tr>
        <tr><!-- item -->
            <td>Website</td>
            <td class="specifictd"><?=trim($institution['website'])!==""?"<a class=\"my_ext_link\" href=\"".ext_link($institution['website'])."\" target=\"_blank\" title=\"".$institution['website']."\">".$institution['website']."</a>":"";?></td>
        </tr>
         <tr><!-- item -->
            <td>Facebook</td>
            <td class="specifictd"><?=trim($institution['facebook'])!==""?"<a class=\"my_ext_link\" href=\"".ext_link($institution['facebook'])."\" target=\"_blank\" title=\"".$institution['facebook']."\">".$institution['facebook']."</a>":"";?></td>
        </tr>
         <tr><!-- item -->
            <td>Twitter</td>
            <td class="specifictd"><?=trim($institution['twitter'])!==""?"<a class=\"my_ext_link\" href=\"".ext_link($institution['twitter'])."\" target=\"_blank\" title=\"".$institution['twitter']."\">".$institution['twitter']."</a>":"";?></td>
        </tr>
       
    </tbody>
</table><!--
<div class="col-md-12 no-padding">
<div class="col-md-12 white-row no-margin">
sdf
</div>
</div>


-->
</div>
</div>
</div>
<div class="gap gap-medium"></div>
<div class="col-md-12 no-padding">
<div class="col-md-12 white-row no-margin">
 <div class="alert alert-info  no-margin">
    <i class="fa fa-exclamation-circle"></i> 
    <span>For more information on specific courses, entry requirements, application process, visa assistance and scholarships, please
</span><br />

 <button class="btn btn-danger" onclick="javascript:inquiry()"><i class="fa fa-angle-double-right"></i>click here</button>
    </div>
 </div>

 
</div>

<div class="col-md-6 hidden-xs hidden-sm social-media-prof">
  <h3 class="page-header">
    <i class="fa fa-facebook"></i> Latest <strong class="styleColor">Updates</strong> 
  </h3>
  <div class="col-md-12">
      <div class="fb-like-box" data-href="<?=$facebook?>" data-width="263" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="true" data-show-border="false">
      </div>
  </div>
</div>
 <div class="col-md-6 hidden-xs hidden-sm social-media-prof">
   <h3 class="page-header">
    <i class="fa fa-twitter"></i> 
    Latest <strong class="styleColor">Tweets</strong> 
  </h3>
        <!-- START TWITTER -->
        <div class="twitter-ticker" id="twitter-ticker"></div>
        <!-- END TWITTER -->
  </div>