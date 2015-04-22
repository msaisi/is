<?php 
$company_config = $this->fuel->companies->config();
$countries=$this->companies_countries_model->options_list();
$genders=$company_config['genders'];
?>
<div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?=base_url()?>">Home</a></li>
            <li class="active">Create new account</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
         <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12">
            <h1>Create an account</h1>
            <div class="content-form-page">
              <div class="row">
                <div class="col-md-7 col-sm-7">
                  <form class="form-horizontal" role="form" method="post">
                    <fieldset>
                      <legend>Your personal details</legend>
                      <div class="form-group">
                        <label for="firstname" class="col-lg-4 control-label">First Name <span class="require">*</span></label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" id="firstname">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="lastname" class="col-lg-4 control-label">Last Name <span class="require">*</span></label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" id="lastname">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" id="email">
                        </div>
                      </div>
                    </fieldset>
                    <fieldset>
                      <legend>Your password</legend>
                      <div class="form-group">
                        <label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" id="password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="confirm-password" class="col-lg-4 control-label">Confirm password <span class="require">*</span></label>
                        <div class="col-lg-8">
                          <input type="text" class="form-control" id="confirm-password">
                        </div>
                      </div>
                    </fieldset>
                    <fieldset>
                      <legend>Newsletter</legend>
                      <div class="checkbox form-group">
                        <label>
                          <div class="col-lg-4 col-sm-4">Singup for Newsletter</div>
                          <div class="col-lg-8 col-sm-8">
                            <input type="checkbox">
                          </div>
                        </label>
                      </div>
                    </fieldset>
                    <div class="row">
                      <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                        <button type="submit" class="btn btn-primary">Create an account</button>
                        <button type="button" class="btn btn-default">Cancel</button>
                      </div>
                    </div>
                    
                  </form>
                  
                                          
             <form class="form-horizontal register-form" role="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" action="auth/create_account">
                        
             <?php 
			 $my_arr=$this->session->flashdata('activate_item');	
			 $email=NULL;
			 $type=NULL;
			 $accounttype=NULL;	
			 $country=NULL;
			 $contacts=NULL;	
			 $names=NULL;	
			 $activate_using=NULL;
			 $activation_value=NULL;
			 $gender=NULL;
			 $occupation=NULL;
			 $id_number=NULL;
			 $passport=NULL;
			 $nhif=NULL;
			 $postofficebox=NULL;
			 $postal_code=NULL;
			 $kra_pin=NULL;
			 		 
			 if(!empty($my_arr)){				 				 
			 $email=$my_arr['email'];	
			 $accounttype=$my_arr['accounttype'];	
			 $type=$my_arr['type'];	
			 $contacts=$my_arr['contacts'];	
			 $country=$my_arr['country'];
			 $occupation=$my_arr['occupation'];
			 $gender=$my_arr['gender'];
			 $names=$my_arr['names'];	
			 $activate_using=$my_arr['activate_using'];
			 $activation_value= $my_arr['activation_value'];			 
			 $id_number=$my_arr['id_number'];
			 $passport=$my_arr['passport'];
			 
			 $nhif=$my_arr['nhif'];
			 $postofficebox=$my_arr['postofficebox'];
			 $postal_code=$my_arr['postal_code'];
			 $kra_pin=$my_arr['kra_pin'];
			 
			 ?>         
             <div class="alert alert-<?=$my_arr['type']?>">
               <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
			   <?=$my_arr['message']?>
             </div>
             <?php }?>
              
              <div class="form-group">            
               <label for="accounttype" class="col-lg-4 control-label">Account Type 
               <span class="require">*</span></label>
               <div class="col-lg-8">              
            <select name="accounttype" id="accounttype" class="form-control" required data-parsley-error-message="Please select your account type." onchange="javascript:activate_item_select(this)"> 
              <option value="" <?php if (!(strcmp("", "$accounttype"))) {echo "selected=\"selected\"";} ?>>Select...</option>
              <option value="1" <?php if (!(strcmp(1, "$accounttype"))) {echo "selected=\"selected\"";} ?>>Customer</option>
              <option value="2" <?php if (!(strcmp(2, "$accounttype"))) {echo "selected=\"selected\"";} ?>>Agent/ Broker</option>
                </select>
                 </div>
                 </div>
               <div class="form-group">            
               <label for="country" class="col-lg-4 control-label">Country <span class="require">*</span></label>
               <div class="col-lg-8"> 
            <select name="country" id="country" class="form-control" required data-parsley-error-message="Please select your country."> 
              <option value="" <?php if (!(strcmp("", "$country"))) {echo "selected=\"selected\"";} ?>>Select...</option>
              <?php foreach($countries as $key=>$val):?>
              <option value="<?=$key?>" <?php if (!(strcmp($key, $country))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
              <?php endforeach;?>
                </select> </div></div>  
                   
             <div class="form-group">            
               <label for="names" class="col-lg-4 control-label">Names <span class="require">*</span></label>
               <div class="col-lg-8">
              <input name="names" type="text" class="form-control" id="names" placeholder="Your Names"  data-parsley-error-message="Please provide your names." required value="<?=$names?>">
              </div></div>
               <div class="form-group">            
               <label for="gender" class="col-lg-4 control-label">Gender <span class="require">*</span></label>
               <div class="col-lg-8">
            <select name="gender" id="gender" class="form-control" required data-parsley-error-message="Please select your gender."> 
              <option value="" <?php if (!(strcmp("", "$gender"))) {echo "selected=\"selected\"";} ?>>Select...</option>
              <?php foreach($genders as $key=>$val):?>
              <option value="<?=$key?>" <?php if (!(strcmp($key, $gender))) {echo "selected=\"selected\"";} ?>><?=$val?></option>
              <?php endforeach;?>
                </select> 
                </div></div>   
             <div class="form-group">            
             <label for="email" class="col-lg-4 control-label">Email Address <span class="require">*</span></label>
               <div class="col-lg-8">
              <input name="email" type="email" class="form-control" id="email" placeholder="Email Address"  data-parsley-error-message="Please provide a valid email address." required value="<?=$email?>" data-parsley-trigger="change">
              </div></div>
              <div class="form-group">            
             <label for="contacts" class="col-lg-4 control-label">Contacts <span class="require">*</span></label>
               <div class="col-lg-8">
              <input name="contacts" type="text" class="form-control" id="contacts" placeholder="Your contacts"  data-parsley-error-message="Please provide your contacts." required value="<?=$contacts?>">
              </div></div>
               <div class="form-group">            
             <label for="id_number" class="col-lg-4 control-label">National ID <span class="require">*</span></label> 		 <div class="col-lg-8">
              <input name="id_number" type="text" class="form-control" id="id_number" placeholder="Your national ID"  data-parsley-error-message="Please provide your national ID." required value="<?=$id_number?>">
              </div></div>
                <div class="form-group">            
             <label for="id_number" class="col-lg-4 control-label">Passport <span class="require">*</span></label> 		 <div class="col-lg-8">
              <input name="passport" type="text" class="form-control" id="passport" placeholder="Your passport"  value="<?=$passport?>"></div></div>
              <div class="form-group">            
             <label for="nhif" class="col-lg-4 control-label">NHIF No. <span class="require">*</span></label> 		 <div class="col-lg-8">
              <input name="nhif" type="text" class="form-control" id="nhif" placeholder="Your NHIF No."  value="<?=$nhif?>" data-parsley-error-message="Please provide your NHIF No." required>
              </div></div>
              <div class="form-group">            
             <label for="kra_pin" class="col-lg-4 control-label">KRA Pin No. <span class="require">*</span></label> 		 <div class="col-lg-8">
              <input name="kra_pin" type="text" class="span6 form-control" id="kra_pin" placeholder="Your KRA pin No."  value="<?=$kra_pin?>" data-parsley-error-message="Please provide your KRA pin No." required>
              </div></div>
               <div class="form-group">            
             <label for="occupation" class="col-lg-4 control-label">Specific Occupation <span class="require">*</span></label> 		
              <div class="col-lg-8">
              <input name="occupation" type="text" class="form-control" id="occupation" placeholder="Your Specific Occupation" value="<?=$occupation?>">   
              </div></div>
               <div class="form-group">            
             <label for="postal_code" class="col-lg-4 control-label">Postal Code<span class="require">*</span></label> 		 <div class="col-lg-8">
              <input name="postal_code" type="text" class="form-control" id="postal_code" placeholder="Your postal code"  value="<?=$postal_code?>">
              </div>
              </div>
               <div class="form-group">            
             <label for="postofficebox" class="col-lg-4 control-label">Postal Address <span class="require">*</span></label> 		 <div class="col-lg-8">
              <input name="postofficebox" type="text" class="form-control" id="postofficebox" placeholder="Your post office box"  value="<?=$passport?>"></div></div>
               <div class="form-group">            
             <label id="activate_using_lbl" for="activate_using" class="col-lg-4 control-label hide_def">Activate Account Using <span class="require">*</span></label> 		 
             <div class="col-lg-8">             
            <select name="activate_using" id="activate_using" class="form-control hide_def" required data-parsley-error-message="Please select an activation item." onchange="javascript:activate_value_select(this)">
              <option value="">Select...</option>
              <option value="Partner Number" <?php if (!(strcmp("Partner Number", "$activate_using"))) {echo "selected=\"selected\"";} ?>>Partner Number</option>
              <option value="Policy Number" <?php if (!(strcmp("Policy Number", "$activate_using"))) {echo "selected=\"selected\"";} ?>>Policy Number</option>
               <option value="Insured Item" <?php if (!(strcmp("Insured Item", "$activate_using"))) {echo "selected=\"selected\"";} ?>>Insured Item</option>
               </select>
               </div></div>
                <div class="form-group">
                 <label id="activation_value_lbl" for="activation_value" class="col-lg-4 control-label hide_def">Activation Value <span class="require">*</span></label> 		 
             <div class="col-lg-8"> 
                <input name="activation_value" type="text" class="form-control hide_def" id="activation_value" placeholder="Activation value"  data-parsley-error-message="Please provide an activation value." required value="<?=$activation_value?>">    
                </div></div>
              <div class="form-group">
                 <label for="pin_cert" class="col-lg-4 control-label">Pin Certificate <span class="require">*</span></label> 		 
             <div class="col-lg-8"> 
              <input name="pin_cert" type="file" class="form-control" id="pin_cert"/>
              <span class="span12 small red">
              Note : Please upload only pdf, docx, png, jpg, jpeg, doc documents. Maximum file upload size is 10MB only
              </span>
              </div></div>
              <div class="gap gap-mini"></div>
              
                <input type="submit" value="Send activation request" class="btn btn-primary">              
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" >
				<input type="hidden" name="cur_page" value="<?=$this->uri->uri_string();?>" >
            </form>                 
                  
                  
                </div>
                <div class="col-md-4 col-sm-4 pull-right">
                  <div class="form-info">
                    <h2><em>Important</em> Information</h2>
                    <p>Lorem ipsum dolor ut sit ame dolore  adipiscing elit, sed sit nonumy nibh sed euismod ut laoreet dolore magna aliquarm erat sit volutpat. Nostrud exerci tation ullamcorper suscipit lobortis nisl aliquip  commodo quat.</p>

                    <p>Duis autem vel eum iriure at dolor vulputate velit esse vel molestie at dolore.</p>

                    <button type="button" class="btn btn-default">More details</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>