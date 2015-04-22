<?php 
/*
|--------------------------------------------------------------------------
| FUEL NAVIGATION: An array of navigation items for the left menu
|--------------------------------------------------------------------------
*/
$config['nav']['gradstate'] = array(	
	'gradstate/home_sliders' => lang('module_gradstate_home_sliders'), 
	'gradstate/sectors' => lang('module_gradstate_sectors'),	
	'gradstate/institution_types' => lang('module_gradstate_institution_types'), 	
	'gradstate/class_types' => lang('module_gradstate_class_types'), 
	'gradstate/course_levels' => lang('module_gradstate_course_levels'),	
	'gradstate/course_types' => lang('module_gradstate_course_types'),	
	'gradstate/faculties' => lang('module_gradstate_faculties'),
	'gradstate/features' => lang('module_gradstate_features'),
	'gradstate/packages' => lang('module_gradstate_packages'),
	'gradstate/package_pricing' => lang('module_gradstate_package_pricing'),
	'gradstate/countries' => lang('module_gradstate_countries'),
	'gradstate/counties' => lang('module_gradstate_counties'),
	'gradstate/qualifications' => lang('module_gradstate_qualifications'),
	'gradstate/institutions' => lang('module_gradstate_institutions'), 
	'gradstate/international_universities' => lang('module_gradstate_international_universities'), 
	'gradstate/campuses' => lang('module_gradstate_campuses'), 
	'gradstate/courses' => lang('module_gradstate_courses'), 
	'gradstate/hot_courses' => lang('module_gradstate_hot_courses'),
	'gradstate/features_subscriptions' => lang('module_gradstate_features_subscriptions'),
	'gradstate/packages_subscriptions' => lang('module_gradstate_packages_subscriptions'),
	'gradstate/top_banners' => lang('module_gradstate_top_banners'),
	'gradstate/clicks' => lang('module_gradstate_clicks'),
	'gradstate/quick_downloads' => lang('module_gradstate_quick_downloads'),
	'gradstate/quick_downloads_log' => lang('module_gradstate_quick_downloads_log'),	
	'gradstate/form_downloads' => lang('module_gradstate_form_downloads')
);

/*
|--------------------------------------------------------------------------
| Configurable in settings if gradstate_use_db_table_settings is set
|--------------------------------------------------------------------------
*/

// deterines whether to use this configuration below or the database for controlling the gradstates behavior
$config['gradstate_use_db_table_settings'] = TRUE;


// set as defaults 
$config['gradstate'] = array();
$config['gradstate']['title'] = '';
$config['gradstate']['description'] = '';
$config['gradstate']['theme_layout'] = 'gradstate';
$config['gradstate']['theme_module'] = 'gradstate';
$config['gradstate']['theme_path'] = 'themes/default';
$config['gradstate']['asset_upload_path_institution_profile_images'] = 'images/institutions/profiles/';
$config['gradstate']['asset_upload_path_institution_logo_images'] = 'images/institutions/logos/';
$config['gradstate']['asset_upload_path_institution_campus_profile_images'] = 'images/institutions/campuses/';
$config['gradstate']['asset_upload_path_top_banners'] = 'images/top_banners/';
$config['gradstate']['asset_upload_path_application_forms'] = 'application_forms/';
$config['gradstate']['forms_download_folder'] = 'application_downloads/';
$config['gradstate']['home_slider_upload_path'] = 'images/sliders/home/';
$config['gradstate']['quick_downloads_path'] = 'quick_downloads/';
$config['gradstate']['study_abroad_panoramic_image'] = '';
$config['gradstate']['uri'] = 'gradstate';
$config['gradstate']['contact_us_email_address'] = "my@address.co.ke";
$config['gradstate']['contact_us_phone'] = "N/A";
$config['gradstate']['email_nice_name'] = "Gradstate";
$config['gradstate']['google_maps_address_code'] = '';
$config['gradstate']['contact_text'] = '';
$config['gradstate']['user_exists_message'] = "user exists message...";
$config['gradstate']['signup_thank_you'] = 'Thank you for signing up...';
$config['gradstate']['signup_email_subject'] = 'Welcome to Gradstate';
$config['gradstate']['alerts_email_nice_name'] = 'Gradstate Alerts';
$config['gradstate']['alerts_email_subject'] = 'New Sign Up';
$config['gradstate']['login_error_msg'] = 'The error message here....';
$config['gradstate']['institutions_per_page'] = '9';
$config['gradstate']['courses_per_page'] = '9';
$config['gradstate']['institution_hot_courses_slots'] = '6';
$config['gradstate']['institution_quick_downloads_slots'] = '6';
$config['gradstate']['facebook'] = 'facebook';
$config['gradstate']['twitter'] = 'twitter';
$config['gradstate']['maisha_url'] = 'maisha_url';
$config['gradstate']['googleplus'] = 'googleplus';
$config['gradstate']['package_validity'] = '1;6;12';
$config['gradstate']['currency'] = 'kes';
$config['gradstate']['top_banner_speed'] = '15000';
$config['gradstate']['display_logos'] = '4';
$config['gradstate']['display_logos_speed'] = '10000';
$config['gradstate']['newsletter_footer'] = '';
$config['gradstate']['newsletter_header'] = '';
$config['gradstate']['newsletter_prefix_title'] = '';
$config['gradstate']['default_youtube_link'] = 'http://www.youtube.com/embed/W7Las-MJnJo';
$config['gradstate']['gradstate_meta_keywords'] = 'gradstate_meta_keywords';
$config['gradstate']['gradstate_meta_description'] = 'gradstate_meta_description';
$config['gradstate']['homepage_title'] = 'GradState homepage';

$config['gradstate']['uniserv_countries'] = 'Australia;Canada;China;Cyprus;Dubai;France;Germany;Hungary;India;Ireland;Malaysia;Netherlands;New Zealnd;Romania;Slovenia;South Africa;Switzerland;Turkey;UAE;United Kingdom;United States';


$config['gradstate']['study_abroad_home_page_link'] = '';
$config['gradstate']['study_abroad_home_page_text'] = '';
$config['gradstate']['study_abroad_home_page_image'] = '';
$config['gradstate']['newsletter_popup_window'] = 'on';

$config['gradstate']['settings']['gradstate_meta_keywords'] = array('default' => 'gradstate_meta_keywords','type'=>'text');
$config['gradstate']['settings']['gradstate_meta_description'] = array('default' => 'gradstate_meta_description','type'=>'text');

$config['gradstate']['settings']['homepage_title'] = array('default' => 'Gradstate homepage');



//$config['gradstate']['settings']['homepage_title'] = array('default' => 'kes');

$config['gradstate']['settings']['currency'] = array('default' => 'kes');
$config['gradstate']['settings']['contact_us_email_address'] = array('default' => "my@address.co.ke");
$config['gradstate']['settings']['contact_us_phone'] = array('default' => "N/A");
$config['gradstate']['settings']['email_nice_name'] = array('default' => "Gradstate");
$config['gradstate']['settings']['google_maps_address_code'] = array('default' => '');
$config['gradstate']['settings']['contact_text'] = array('default' => '');
$config['gradstate']['settings']['user_exists_message'] = array('default' => "user exists message...");
$config['gradstate']['settings']['signup_thank_you'] = array('default' => 'Thank you for signing up...');
$config['gradstate']['settings']['signup_email_subject'] = array('default' => 'Welcome to Gradstate');
$config['gradstate']['settings']['alerts_email_nice_name'] = array('default' => 'Gradstate Alerts');
$config['gradstate']['settings']['alerts_email_subject'] = array('default' => 'New Sign Up');
$config['gradstate']['settings']['login_error_msg'] = array('default' => 'The error message here....');
$config['gradstate']['settings']['institutions_per_page'] = array('default' => '9');
$config['gradstate']['settings']['courses_per_page'] = array('default' => '9');
$config['gradstate']['settings']['institution_hot_courses_slots'] = array('default' => '6');
$config['gradstate']['settings']['institution_quick_downloads_slots'] = array('default' => '6');
$config['gradstate']['settings']['facebook'] = array('default' => 'facebook');
$config['gradstate']['settings']['twitter'] = array('default' => 'twitter');
$config['gradstate']['settings']['maisha_url'] = array('default' => 'twitter');
$config['gradstate']['settings']['googleplus'] = array('default' => 'googleplus');
$config['gradstate']['settings']['package_validity'] = array('default' => '1;6;12');
$config['gradstate']['settings']['top_banner_speed'] = array('default' => '15000');
$config['gradstate']['settings']['display_logos'] = array('default' => '4');
$config['gradstate']['settings']['display_logos_speed'] = array('default' => '10000');
$config['gradstate']['settings']['default_youtube_link'] = array('default' => 'http://www.youtube.com/embed/W7Las-MJnJo');
$config['gradstate']['settings']['study_abroad_panoramic_image'] = array('default' => '','subfolder'=>'study_abroad');


$config['gradstate']['settings']['study_abroad_home_page_link'] = array('default' => '');
$config['gradstate']['settings']['study_abroad_home_page_text'] = array('default' => '');
$config['gradstate']['settings']['study_abroad_home_page_image'] = array('default' => '','subfolder'=>'study_abroad');

$config['gradstate']['settings']['newsletter_popup_window'] = array('default' => 'no', 'comment'=>"use 'yes' to enable this feature or otherwise it will be turned off. ");

$config['gradstate']['settings']['uniserv_countries'] = array('default' => 'Australia;Canada;China;Cyprus;Dubai;France;Germany;Hungary;India;Ireland;Malaysia;Netherlands;New Zealnd;Romania;Slovenia;South Africa;Switzerland;Turkey;UAE;United Kingdom;United States','type'=>'text');


$config['gradstate_cache_group'] = 'gradstate';


/*
|--------------------------------------------------------------------------
| Programmer specific config (not exposed in settings)
|--------------------------------------------------------------------------
*/
// content formatting options
$config['gradstate']['formatting'] = array(
	'auto_typography' => 'Automatic',
	'Markdown' => 'Markdown',
	'' => 'None'
	);

$config['gradstate']['institutions_order_fields'] = array(
	'institution_name' => 'Institution Name',
	'account_type' => 'Account Type',
	);
$config['gradstate']['courses_order_fields'] = array(
	'course_title' => 'Course Title',
	'post_date' => 'Date Posted',
	);
$config['gradstate']['sources'] = array(
	'Outdoor advertising' => 'Outdoor advertising',
	'Print advertising' => 'Print advertising',
	'Search engine (Google, Yahoo!...)' => 'Search engine (Google, Yahoo!...)',
	'Word of mouth' => 'Word of mouth',
	'Facebook' => 'Facebook',
	'TV' => 'TV',
	'Radio' => 'Radio',
	'Other' => 'Other',
	);
$config['gradstate']['genders'] = array(
	'male' => 'male',
	'female' => 'female',
	);
$config['gradstate']['yes_no'] = array(
	'yes' => 'yes',
	'no' => 'no',
	);




$config['gradstate']['duration_periods']=array('N/A'=>'N/A','days'=>"Days", 'weeks'=>'Weeks', 'months'=>'Months', 'years'=>'Years');

$config['gradstate']['currency_list']=array('N/A'=>'N/A','KSH'=>"KSH", 'USD'=>'USD', 'GBP'=>'GBP', 'EUR'=>'EUR');

$config['gradstate']['payment_period']=array('N/A'=>'N/A','Per Semester'=>"Per Semester", 'Per Year'=>'Per Year', 'Entire Course'=>'Entire Course');

$config['gradstate']['experience']=array('0-1 Year'=>"0-1 Year", '1-3 Years'=>'1-3 Years', '3-5 Years'=>'3-5 Years', '5-7 Years'=>'5-7 Years', '7-10 Years'=>'7-10 Years', '10-15 Years'=>'10-15 Years', '15+ Years'=>'15+ Years');

$config['gradstate']['ages']=array('18-25'=>"18-25", '26-30'=>'26-30', '31-40'=>'31-40', '41-50'=>'41-50', '50+'=>'50+');


// tables for gradstate
$config['tables']['gradstate_sectors'] = 'tbl_sectors';
$config['tables']['gradstate_institution_types'] = 'tbl_institution_types';
$config['tables']['gradstate_class_types'] = 'tbl_class_types';
$config['tables']['gradstate_course_levels'] = 'tbl_course_levels';
$config['tables']['gradstate_course_types'] = 'tbl_course_types';
$config['tables']['gradstate_faculties'] = 'tbl_faculties';
$config['tables']['gradstate_features'] = 'tbl_features';
$config['tables']['gradstate_countries'] = 'tbl_countries';
$config['tables']['gradstate_counties'] = 'tbl_counties';
$config['tables']['gradstate_packages'] = 'tbl_packages';
$config['tables']['gradstate_qualifications'] = 'tbl_qualifications';
$config['tables']['gradstate_campuses'] = 'tbl_institution_campuses';
$config['tables']['gradstate_institutions'] = 'tbl_institutions';
$config['tables']['gradstate_courses'] = 'tbl_courses';
$config['tables']['gradstate_package_pricing'] = 'tbl_package_pricing';
$config['tables']['gradstate_features_subscriptions'] = 'tbl_features_subscriptions';
$config['tables']['gradstate_packages_subscriptions'] = 'tbl_packages_subscriptions';
$config['tables']['gradstate_top_banners'] = 'tbl_top_banners';
$config['tables']['gradstate_course_campus'] = 'tbl_course_to_campuses';
$config['tables']['gradstate_course_location'] = 'tbl_course_to_locations';
$config['tables']['gradstate_course_to_class_type'] = 'tbl_course_to_class_types';
$config['tables']['gradstate_course_to_level'] = 'tbl_course_to_course_levels';
$config['tables']['gradstate_course_to_type'] = 'tbl_course_to_course_types';
$config['tables']['gradstate_course_to_sector'] = 'tbl_course_to_sectors';
$config['tables']['gradstate_orders'] = 'tbl_orders';
$config['tables']['gradstate_order_details'] = 'tbl_order_details';
$config['tables']['gradstate_form_downloads'] = 'tbl_form_downloads';
$config['tables']['gradstate_hot_courses'] = 'tbl_hot_courses';
$config['tables']['gradstate_hot_courses_bind'] = 'tbl_hot_courses_bind';
$config['tables']['gradstate_home_sliders'] = 'fuel_home_sliders';
$config['tables']['gradstate_course_alerts'] = 'tbl_course_alerts';
$config['tables']['gradstate_clicks'] = 'tbl_site_clicks';
$config['tables']['gradstate_international_universities'] = 'tbl_international_universities';
$config['tables']['gradstate_international_universities_to_faculty'] = 'tbl_international_inst_to_faculties';
$config['tables']['gradstate_international_universities_to_qualifications'] = 'tbl_international_inst_to_qualifications';
$config['tables']['gradstate_university_inquiries'] = 'tbl_university_inquiries';
$config['tables']['gradstate_quick_downloads'] = 'tbl_quick_downloads';
$config['tables']['gradstate_quick_downloads_log'] = 'tbl_quick_downloads_log';