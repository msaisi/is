<?php 
$courses=$this->fuel->gradstate->get_hot_courses();
?>
<?php if(!empty($courses))
{ 
$i=0;
foreach($courses as $row):
if($i<6)
{
$img="assets/".$logos_path.$row['logo_picture'];
?>

<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
 
  <div class="item-box item-box-ext">
   <div class="hot_course_header no-margin">
    <a style="text-transform:uppercase !important;" href="courses/<?=$row['course_id']?>" title="<?=$row['course_title']?>" target="_blank"><i class="fa fa-book">&nbsp;</i><?=$row['course_title']?></a>
    </div> 
   <hr class="gap gap-mini2 no-margin-top"/>
   <div class="col-md-12 no-left no-right">
   <div class="col-md-12" >   
   <a style="color:#FF7B26 !important ; text-transform:uppercase !important; font-size:13px;" href="institutions/<?=$row['inst_slug']?>" title="<?=$row['institution_name']?>" target="_blank">  
    <!--<i class="fa fa-building-o">&nbsp;</i>-->
	<img src="<?=base_url()?>assets/<?=$logos_path.$row['logo_picture']?>" alt="<?=$row['institution_name']?>" width="24" height="24">
	<?=truncate($row['institution_name'],33)?>
   </a>
   </div>
   
   </div>
   
   
</div>  


<hr class="gap gap-mini no-margin" />
</div>

<?php } $i++; endforeach; }?>