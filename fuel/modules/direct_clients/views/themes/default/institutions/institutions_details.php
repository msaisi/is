<?php
$inst_twitter=get_twitter($institution['twitter']);
$facebook=trim($institution['facebook'])===""?$site_fb:$institution['facebook'];
?>
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
<script>
twitter_username = '<?=$inst_twitter?>';
ticker_tweet_count_max = 20;
</script>
<br />
<div class="col-md-12">
<?php  $CI->load->view('_blocks/insts_topbar');?> 
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
<?=truncate($institution['about'],700);?>
</div>

</div>

</div>

<div class="gap gap-medium"></div>
<div class="col-md-3" id="my_search_div">
<?php  $CI->load->view('_blocks/inst_search');?> 
</div>
<div class="col-lg-6 col-md-9 col-sm-12 col-xs-12">
<?php  $CI->load->view('pages/campuses',array('inst_slug'=>$institution['slug']));?> 
</div>

<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
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
            <td>Phone</td>
            <td class="specifictd"><?=$institution['institution_contacts'];?></td>
        </tr>
        <tr><!-- item -->
            <td>Email</td>
            <td class="specifictd"><?=trim($institution['institution_email'])!==""?"<a href=\"".mail_to($institution['institution_email'])."\" title=\"".$institution['institution_email']."\">".$institution['institution_email']."</a>":"";?></td>
        </tr>
        <tr><!-- item -->
            <td>Website</td>
            <td class="specifictd"><?=trim($institution['website'])!==""?"<a class=\"my_ext_link\" href=\"".ext_link($institution['website'])."\" target=\"_blank\" title=\"".$institution['website']."\">".$institution['website']."</a>":"";?></td>
        </tr>
         <tr><!-- item -->
            <td>Facebook</td>
            <td class="specifictd"><span><?=trim($institution['facebook'])!==""?"<a class=\"my_ext_link\" href=\"".ext_link($institution['facebook'])."\" target=\"_blank\" title=\"".$institution['facebook']."\">".$institution['facebook']."</a>":"";?></span></td>
        </tr>
         <tr><!-- item -->
            <td>Twitter</td>
            <td class="specifictd"><?=trim($institution['twitter'])!==""?"<a class=\"my_ext_link\" href=\"".ext_link($institution['twitter'])."\" target=\"_blank\" title=\"".$institution['twitter']."\">".$institution['twitter']."</a>":"";?></td>
        </tr>
          <tr><!-- item -->
               <td>HQ</td>
            <td class="specifictd"><?=$institution['hq'];?></td>
        </tr>
       
    </tbody>
</table>
</div>
</div>
</div>
<div class="gap gap-medium"></div>
<div class="col-md-6 ">
   <h3 class="page-header">
    <i class="fa fa-youtube-square"></i> 
    You<strong class="styleColor">tube</strong> 
  </h3>
        <div class="col-md-12 no-padding">
        <iframe class="col-md-12 no-padding" height="315" src="<?=$youtube?>"></iframe>        
        </div>
  </div>
  <div class="col-md-6">
   <h3 class="page-header">
    <i class="fa fa-cloud-download"></i> 
    Quick <strong class="styleColor">Downloads</strong> 
  </h3>
       <div class="col-md-12 no-padding">
        <?php if(!empty($quick_downloads))
	{?>
        <table class="table table-striped table-hover">
  <!-- table head -->
   <!-- table items -->
    <tbody>
   <?php
		foreach($quick_downloads as $row):
		?>
        <tr><!-- item -->
            <td><i class="fa fa-angle-double-right"></i> <?=$row['file_name'];?></td>
            <td><button class="btn btn-primary btn-xs" onclick="javascript:do_quick_download('<?=$row['item_id']?>')"><i class="fa fa-download"></i> Download</button></td>
        </tr>
     <?php endforeach;?>                
    </tbody>
</table>   
 <?php } 
	 else{?>        
            
 <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> 
            <span>No downloads available.</span>
            
        </div>
        <?php }?> 
        </div>
  </div>
<div class="gap gap-medium"></div>

<div class="col-md-6 hidden-xs hidden-sm social-media-prof">
  <h3 class="page-header">
    <i class="fa fa-facebook"></i> Latest <strong class="styleColor">Updates</strong> 
  </h3>
  <div class="col-md-12 no-padding">
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