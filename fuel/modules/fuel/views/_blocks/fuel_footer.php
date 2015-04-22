	<?=js('jqx/jqx', 'fuel')?>
	<?php $fuel_js = $this->fuel->config('fuel_javascript'); ?>
	<?php foreach($fuel_js as $m => $j) : echo js(array($m => $j))."\n\t"; endforeach; ?>

	<?php foreach($js as $m => $j) : echo js(array($m => $j))."\n\t"; endforeach; ?>

	<?php if (!empty($this->js_controller)) : ?> 
	<script type="text/javascript">
		<?php if ($this->js_controller != 'fuel.controller.BaseFuelController') : ?>
		jqx.addPreload('fuel.controller.BaseFuelController');
		<?php endif; ?>
		jqx.init('<?=$this->js_controller?>', <?=json_encode($this->js_controller_params)?>, '<?=$this->js_controller_path?>');
	</script>
	<?php endif; ?>
<style>
.form td.label 
{
	width: 25%;
}
</style>
<script type="application/javascript">
$(function() 
{
	$('#userfile_file_name').attr("readonly",true);


	$('#subfolder').hide();
	$('#label_subfolder').hide();
	
	hide_show_access($('input[name=super_admin]:checked').val());
	
	$("input[name='super_admin']").change(function()
	{
		hide_show_access($('input[name=super_admin]:checked').val());
	});
	
}); 

function hide_show_access(val)
{
	if(val==="yes")
	{
		$('#access_level').hide();
		$('#label_access_level').hide();
		$('#department_code').hide();
		$('#label_department_code').hide();			
	}
	else
	{
		$('#access_level').show();
		$('#label_access_level').show();
		$('#department_code').show();
		$('#label_department_code').show();	
	}
}
</script>