<?php 
$insts=$CI->fuel->gradstate->get_logo_list();
shuffle($insts);
if(!empty($insts))
{?>
<ul class="conts no-padding ext-inst_list">
		<?php 
		$i=0;
		foreach($insts as $key=>$val):
			if($i<5)
			{	
			$filter=array('institution_id'=>$val);
			$resp=$this->gradstate_institutions_model->find_one_array($filter);		
		?>
        <li><a href="institutions/<?=$resp['slug']?>" target="_blank" title="<?=$resp['institution_name']?>"><div align="center" class="logo_list ext-logo-list">
            <img class="img-responsive" src="<?=base_url()?>assets/<?=$logos_path.$resp['logo_picture']?>" alt="<?=$resp['institution_name']?>">
        </div></a></li>
        <?php 		
			}
			$i++;
		endforeach;?>
       
    </ul>
    <?php
} ?>