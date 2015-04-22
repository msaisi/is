<!-- BEGIN BODY -->
<body>
<div class="page-lock">
	<div class="page-logo">
	<a class="brand" href="<?=base_url()?>insurer/lock">
	<img src="assets/metronic/admin/layout/img/logo-big.png" alt="logo"/>
	</a>
	</div>
	<div class="page-body">
		<img class="page-lock-img" src="<?=$asset_path.$user_photo?>" alt="">
		<div class="page-lock-info">
			<h1><?=decrypt($names)?></h1>
			<span class="email">
			<?=decrypt($email)?> </span>
			<span class="locked">
			Locked </span>
			<form class="lock-form" action="admin_auth/unlock" method="post">
            <?php 
				$type="success";
				$disp="display-hide";
				$msg="Enter account password. ";
				$my_flash_data=$this->session->flashdata('admin_unlock_item');
			
				if(!empty($my_flash_data))
				{
					$type=$my_flash_data['type'];
					$disp="";
					$msg=$my_flash_data['message'];
				}
				?>        
				<div class="alert alert-<?=$type?> <?=$disp?>">
					<button class="close" data-close="alert"></button>            
					<span><?=$msg?></span>            
				</div>  
            
            
            
				<div class="input-group input-medium">
					<input type="password" class="form-control" placeholder="Password" name="password">
					<span class="input-group-btn">
					<button type="submit" class="btn blue icn-only"><i class="m-icon-swapright m-icon-white"></i></button>
                    <input type="hidden" name="username" value="<?=decrypt($email)?>" >
                     <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" >
<input type="hidden" name="cur_page" value="<?=$this->uri->uri_string();?>" >
					</span>
				</div>
				<!-- /input-group -->
				<div class="relogin">
					<a href="insurer/signin">
					Not <?=decrypt($names)?> ? </a>
				</div>
			</form>
		</div>
	</div>
	<div class="page-footer-custom">
		 2014 &copy; Metronic. Admin Dashboard Template.
	</div>
</div>
</body>
<!-- END BODY -->