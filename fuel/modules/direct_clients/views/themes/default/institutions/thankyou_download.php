<script>
function download()
{
	rl="ajax_load/download?f=<?=$file_sourse?>&n=<?=$file_name?>";
	window.location.href=rl;
}
</script>
<div class="col-md-12">
<div class="col-md-12 white-row">

<div class="alert alert-success" id="dwnload_file">
    <i class="fa fa-thumbs-o-up"></i> 
    <span>Thank you <i><?=$names?></i> for downloading a course application form.</span>
</div>

</div>
</div>