<?php 
/*
|--------------------------------------------------------------------------
| FUEL NAVIGATION: An array of navigation items for the left menu
|--------------------------------------------------------------------------
*/
$config['nav']['companies'] = array(		
	'companies/accounts' => lang('module_companies_accounts'),
	'companies/departments' => lang('module_companies_departments'),
	'companies/users' => lang('module_companies_users')
);

/*
|--------------------------------------------------------------------------
| Configurable in settings if companies_use_db_table_settings is set
|--------------------------------------------------------------------------
*/

// deterines whether to use this configuration below or the database for controlling the companiess behavior
$config['companies_use_db_table_settings'] = TRUE;


// set as defaults 
$config['companies'] = array();
$config['companies']['title'] = '';
$config['companies']['description'] = '';
$config['companies']['theme_layout'] = 'companies';
$config['companies']['theme_module'] = 'companies';
$config['companies']['theme_path'] = 'themes/default';
$config['companies']['asset_upload_path_company_profile_images'] = 'images/companies/profiles/';
$config['companies']['asset_upload_path_company_user_images'] = 'images/companies/users/';
$config['companies']['home_slider_upload_path'] = 'images/sliders/home/';
$config['companies']['uri'] = 'companies';
$config['companies']['contact_us_email_address'] = "my@address.co.ke";
$config['companies']['contact_us_phone'] = "N/A";
$config['companies']['email_nice_name'] = "IS";
$config['companies']['user_exists_message'] = "user exists message...";
$config['companies']['signup_thank_you'] = 'Thank you for signing up...';
$config['companies']['signup_email_subject'] = 'Welcome to IS';
$config['companies']['alerts_email_nice_name'] = 'IS Alerts';
$config['companies']['alerts_email_subject'] = 'New Sign Up';
$config['companies']['login_error_msg'] = 'The error message here....';
$config['companies']['currency'] = 'kes';
$config['companies']['companies_meta_keywords'] = 'companies_meta_keywords';
$config['companies']['companies_meta_description'] = 'companies_meta_description';
$config['companies']['homepage_title'] = 'IS homepage';

$config['companies']['settings']['companies_meta_keywords'] = array('default' => 'companies_meta_keywords','type'=>'text');
$config['companies']['settings']['companies_meta_description'] = array('default' => 'companies_meta_description','type'=>'text');
$config['companies']['settings']['homepage_title'] = array('default' => 'IS homepage');
$config['companies']['settings']['currency'] = array('default' => 'kes');
$config['companies']['settings']['contact_us_email_address'] = array('default' => "my@address.co.ke");
$config['companies']['settings']['contact_us_phone'] = array('default' => "N/A");
$config['companies']['settings']['email_nice_name'] = array('default' => "Gradstate");
$config['companies']['settings']['user_exists_message'] = array('default' => "user exists message...");
$config['companies']['settings']['signup_thank_you'] = array('default' => 'Thank you for signing up...');
$config['companies']['settings']['signup_email_subject'] = array('default' => 'Welcome to Gradstate');
$config['companies']['settings']['alerts_email_nice_name'] = array('default' => 'Gradstate Alerts');
$config['companies']['settings']['alerts_email_subject'] = array('default' => 'New Sign Up');
$config['companies']['settings']['login_error_msg'] = array('default' => 'The error message here....');

$config['companies_cache_group'] = 'companies';


/*
|--------------------------------------------------------------------------
| Programmer specific config (not exposed in settings)
|--------------------------------------------------------------------------
*/
// content formatting options
$config['companies']['formatting'] = array(
	'auto_typography' => 'Automatic',
	'Markdown' => 'Markdown',
	'' => 'None'
	);
$config['companies']['yes_no'] = array(
	'yes' => 'yes',
	'no' => 'no',
	);
$config['companies']['genders'] = array(
	'male' => 'Male',
	'female' => 'Female'
	);

// tables for companies
$config['tables']['companies_users'] = 'is_company_users';
$config['tables']['companies_accounts'] = 'is_insurance_companies';
$config['tables']['companies_countries'] = 'is_insurance_companies';
$config['tables']['companies_counties'] = 'is_insurance_companies';
$config['tables']['companies_departments'] = 'is_company_departments';

