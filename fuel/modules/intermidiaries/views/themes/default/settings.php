<?php
 $email_sub=$not_status['email_sub'];
 $sms_sub=$not_status['sms_sub']; 
?>
<script>
 $(document).ready(function() {	 
	 $('#switch_sms').bootstrapSwitch('state', false); 
	 $('#switch_email').bootstrapSwitch('state', false); 
	 var sms_sub='<?=$sms_sub?>';
	 var email_sub='<?=$email_sub?>';
	 if (sms_sub==1)
	 {
		 $('#switch_sms').bootstrapSwitch('state', true); 
	 }	 
	 if (email_sub==1)
	 {
		 $('#switch_email').bootstrapSwitch('state', true); 
	 }
	 
	 $('#switch_email').on('switchChange.bootstrapSwitch', function (e, e_state) {
		 	if(e_state==true)
			{
				javascript:toggle_settings('email','1')
			}
			else
			{
				javascript:toggle_settings('email','0')
			}
		 }); 
	 
	$('#switch_sms').on('switchChange.bootstrapSwitch', function (e, s_state) {
		if(s_state==true)
			{
				javascript:toggle_settings('sms','1')
			}
			else
			{
				javascript:toggle_settings('sms','0')
			}
	});
	 
	 
 });
function toggle_settings(my_item,val)
{
	url="scripts_user/toggle_settings_"+my_item+"/"+val;
	$.get(url, function(data) 
		{	
			//alert(data);		
		});
}
</script>
<div class="row-fluid">
<div class="span6">
<h5 class="profile-title">Notification Settings &nbsp;<span class="small text-info"> <i class="icon-info"></i>&nbsp;click on toggle to change</span></h5>
<div class="my-divider"></div>
<table class="table table-bordered">
  <tr>
    <td>Email Notifications</td>
    <td>
     <div class="bootstrap-switch bootstrap-switch-mini" data-on="primary" data-off="info">
    <input type="checkbox" id="switch_email" class="my_switcher">
	</div>
    </td>
  </tr>
 <tr>
    <td>Short Messages</td>
    <td> 
    <div class="bootstrap-switch bootstrap-switch-mini" data-on="primary" data-off="info">
    <input type="checkbox" id="switch_sms" class="my_switcher">
	</div></td>
  </tr>
</table>
</div>

<div class="span6">
<h5 class="profile-title">Account Password &nbsp;<span class="small text-error"> <i class="icon-info"></i>&nbsp;changes will take effect during next login</span></h5>
<div class="my-divider"></div>
<form data-validate="parsley" method="post" action="account/update_password">

 <?php 
	 $my_arr=$this->session->flashdata('settings_flash_data');
	 if(!empty($my_arr))
	 {
	  ?>
	 <div class="block">             
	 <div class="alert alert-<?=$my_arr['type']?>">
	   <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
	   <?=$my_arr['message']?>
	 </div>          
	 </div>
<?php } ?>

<label>Current Password</label>
<input name="old_password" id="old_password" type="password" class="span12" placeholder="Current Password" data-required="true" data-error-message="Please enter your current password." />

<label>New Password</label>
<input name="new_password" id="new_password" type="password" class="span12" placeholder="New Password" data-required="true" data-error-message="Please enter your new password." />

<label>Confirm Password</label>
<input name="confirm_password" id="confirm_password" type="password" class="span12" placeholder="Confirm Password" data-required="true" data-equalto="#new_password" data-equalto-message="Confirm password must match new password."/>

<div class="my-divider"></div>
 <button type="submit" class="btn btn-primary">Save Details</button>
 <input type="hidden" name="<?=$CI->security->get_csrf_token_name()?>" value="<?=$CI->security->get_csrf_hash()?>" >
</form>

</div>
</div>