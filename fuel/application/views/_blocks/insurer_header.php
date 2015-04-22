<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Blank Page <small>blank page</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<!--<li>
						
                        <a href="#">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>-->
                    <?php 
					foreach($crumps as $row):					
					?>
					<li>
                     <?php if($row['active']==true){?>
                     	<?php if($row['crump_icon']==true){?> 
                        <i class="<?=$row['crump_ass']?>"></i>
                        <?php }?>
						<a href="<?=$row['url_link']?>"><?=$row['display_name']?></a>
                     <?php }else?>
                     <?php if($row['active']==false){?>
                     <?php if($row['crump_icon']==true){?> 
                        <i class="<?=$row['crump_ass']?>"></i>
                        <?php }?>
						<?=$row['display_name']?>
                     <?php }?>
                     <?php if($row['last']==false){?>
                     <i class="fa fa-angle-right"></i><?php }?>
					</li>
					<?php endforeach;?>                   
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Actions <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="#">Action</a>
							</li>
							<li>
								<a href="#">Another action</a>
							</li>
							<li>
								<a href="#">Something else here</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="#">Separated link</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->