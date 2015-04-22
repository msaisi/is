 <?=fuel_edit('create', 'Create listings', 'siteconfig/dealsevents')?>
	<?php
	 if (!empty($listings)) : ?>
        <div class="pull-left" style="color:#f02311;padding-bottom: 14px"><em><?php if (!empty($record_count)) : ?><?=$record_count?>  &nbsp;<?php endif; ?>
        </em></div>
            <div ></div>
             <div class="span9">
             <div class="row row-wrap">
                     <?php
					foreach($listings as $row):
						
					$row=(object)$row;?>
                    <div class="span3">
                        <!-- COUPON THUMBNAIL -->
                        <a href="<?=$row->url?>" class="coupon-thumb">
							 <img src="<?=$row->list_image_path?>" alt="Image Alternative text" title="<?=strtoupper($row->title)?>" />
                            <div class="coupon-inner">
                                <h5 class="coupon-title"><?=$row->title;?></h5>
                                <p class="coupon-desciption">
							  <div class="coupon-inner listing-div black my_text">
								<?=$row->get_excerpt_formatted(150)?>
                              </div></p>
                               <div class="coupon-meta">
                               <?php if(floatval($row->discount)>0){?>
                                <span class="coupon-time">Listing type: <?=$row->type?></span>
                                <span class="coupon-save">Save <?=$row->discount?>%</span>
                                  <div class="coupon-price full-width">
                                    <span class="coupon-old-price"><?php echo $this->fuel->siteconfig->config('currency')?> <?=format_currency($row->cost)?></span>
                                    <span class="coupon-new-price"><?php echo $this->fuel->siteconfig->config('currency')?> <?=format_currency($row->cost*((100-$row->discount)*0.01))?></span>
                                     
                                  </div>
                                 
                                  
                               <?php }
							   else
							   {?>
                                <span class="coupon-time">Listing type: <?=$row->type?></span>
                                <span class="coupon-save">Limited Offer</span>
                                  <div class="coupon-price full-width">
                                    <span class="coupon-old-price">&nbsp;</span>
                                    <span class="coupon-new-price"><?php if(floatval($row->cost)>0)
										{
										echo $this->fuel->siteconfig->config('currency')?> <?=format_currency($row->cost);
										}
										else
										{
										echo "N/A";
										}
										?></span>
                                  </div>
                               <?php }?>
                                
                               </div>
                                 <div class="gap gap-small"></div>
                                 <!--span class="btn btn-primary btn-block btn-large icon-shopping-cart" href="#">Buy Now</span-->
                            </div>		
                        </a>
                        <?php if($row->online_purchasable=='yes'){
                        	if($row->external_page!=''){
                        		//no popup required..set href to the external link
                        		$href= $row->external_page;
                        	} 
                        	?>
                        <a class="popup-text btn btn-primary btn-block btn-large" href="#verify_buymore_customer"  data-effect="mfp-zoom-out" next-to="<?php echo str_replace('/item/', '/buy/', $row->url)?>">Buy Now</a>
                        <?php $this->load->view('segments/student_verification_popup')?> 	
                        <?php }?>
                    </div>
                   <?php endforeach;?> 
                    
                </div>
                </div>
		<?php if (!empty($pagination)) : ?><?=$pagination?>  &nbsp;<?php endif; ?>
	<?php else: ?>
	<div class="alert alert-error" align="center">
		<p style="padding-top:1em">There are no deals available...</p>
	</div>
	<?php endif; ?> 