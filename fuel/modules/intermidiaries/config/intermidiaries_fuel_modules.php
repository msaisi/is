<?php
$config['modules']['gradstate_sectors'] = array(
	'module_name' => 'Job Sectors',
	'model_name' => 'gradstate_sectors_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/sectors',
	'display_field' => 'name',
	'instructions' => 'Manage job sectors',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/sectors',	
	'permission' => 'gradstate_sectors',
	'exportable' => TRUE,	
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_institution_types'] = array(
	'module_name' => 'Institution Types',
	'model_name' => 'gradstate_institution_types_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/institution_types',
	'display_field' => 'name',
	'permission' => 'gradstate_institution_types',
	'instructions' => 'Manage institution types',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/institution_types',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_class_types'] = array(
	'module_name' => 'Class Types',
	'model_name' => 'gradstate_class_types_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/class_types',
	'permission' => 'gradstate_class_types',
	'display_field' => 'name',
	'instructions' => 'Manage class types',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/class_types',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_course_levels'] = array(
	'module_name' => 'Course Levels',
	'model_name' => 'gradstate_course_levels_model',
	'model_location' => 'gradstate',
	'permission' => 'gradstate_course_levels',
	'module_uri' => 'gradstate/course_levels',
	'display_field' => 'name',
	'instructions' => 'Manage class types',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/course_levels',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_course_types'] = array(
	'module_name' => 'Course Types',
	'model_name' => 'gradstate_course_types_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/course_types',
	'display_field' => 'name',
	'instructions' => 'Manage course types',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/course_types',
	'permission' => 'gradstate_course_types',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_faculties'] = array(
	'module_name' => 'Faculties',
	'model_name' => 'gradstate_faculties_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/faculties',
	'display_field' => 'name',
	'instructions' => 'Manage faculties',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/faculties',
	'permission' => 'gradstate_faculties',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_features'] = array(
	'module_name' => 'Features',
	'model_name' => 'gradstate_features_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/features',
	'display_field' => 'name',
	'instructions' => 'Manage features',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/features',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_features_subscriptions'] = array(
	'module_name' => 'Features subscriptions',
	'model_name' => 'gradstate_features_subscriptions_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/features_subscriptions',
	'display_field' => 'institution_name',
	'instructions' => 'Manage features subscriptions',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/features_subscriptions',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_countries'] = array(
	'module_name' => 'Countries',
	'model_name' => 'gradstate_countries_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/countries',
	'display_field' => 'name',
	'instructions' => 'Manage countries',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/countries',
	'exportable' => TRUE,
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_counties'] = array(
	'module_name' => 'Counties',
	'model_name' => 'gradstate_counties_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/counties',
	'display_field' => 'name',
	'instructions' => 'Manage counties',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/counties',
	'exportable' => TRUE,
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_packages'] = array(
	'module_name' => 'Packages',
	'model_name' => 'gradstate_packages_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/packages',
	'display_field' => 'name',
	'instructions' => 'Manage packages',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/packages',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_package_pricing'] = array(
	'module_name' => 'Package Prices',
	'model_name' => 'gradstate_package_pricing_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/package_pricing',
	'display_field' => 'name',
	'instructions' => 'Manage package prices',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/package_pricing',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_packages_subscriptions'] = array(
	'module_name' => 'Packages subscriptions',
	'model_name' => 'gradstate_packages_subscriptions_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/packages_subscriptions',
	'display_field' => 'institution_name',
	'instructions' => 'Manage packages subscriptions',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/packages_subscriptions',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_qualifications'] = array(
	'module_name' => 'Qualifications',
	'model_name' => 'gradstate_qualifications_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/qualifications',
	'display_field' => 'name',
	'instructions' => 'Manage qualifications',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/qualifications',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_institutions'] = array(
	'module_name' => 'Institution Profiles',
	'model_name' => 'gradstate_institutions_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/institutions',
	'display_field' => 'institution_name',
	'instructions' => 'Manage institution profiles',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/institutions',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_international_universities'] = array(
	'module_name' => 'International Universities Profiles',
	'model_name' => 'gradstate_international_universities_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/international_universities',
	'display_field' => 'institution_name',
	'instructions' => 'Manage international universities profiles',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/international_universities',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);

$config['modules']['gradstate_campuses'] = array(
	'module_name' => 'Campuses',
	'model_name' => 'gradstate_campuses_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/campuses',
	'permission' => 'gradstate_campuses',
	'display_field' => 'campus_name',
	'instructions' => 'Manage institution campuses',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/campuses',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);

$config['modules']['gradstate_courses'] = array(
	'module_name' => 'Courses',
	'model_name' => 'gradstate_courses_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/courses',
	'display_field' => 'course_title',
	'instructions' => 'Manage courses',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/courses',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);

$config['modules']['gradstate_top_banners'] = array(
	'module_name' => 'Top banners',
	'model_name' => 'gradstate_top_banners_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/top_banners',
	'display_field' => 'title',
	'instructions' => 'Manage top banners',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/top_banners',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_hot_courses'] = array(
	'module_name' => 'Hot Courses',
	'model_name' => 'gradstate_hot_courses_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/hot_courses',
	'display_field' => 'institution_name',
	'instructions' => 'Manage hot Courses',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/hot_courses',
	'exportable' => TRUE,
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_quick_downloads'] = array(
	'module_name' => 'Quick Downloads',
	'model_name' => 'gradstate_quick_downloads_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/quick_downloads',
	'display_field' => 'file_name',
	'instructions' => 'Manage quick downloads',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/quick_downloads',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_home_sliders'] = array(
	'module_name' => 'Home Sliders',
	'model_name' => 'gradstate_home_sliders_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/home_sliders',
	'display_field' => 'header',
	'instructions' => 'Manage home sliders',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/home_sliders',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_clicks'] = array(
	'module_name' => 'Site Clicks',
	'model_name' => 'gradstate_clicks_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/clicks',
	'display_field' => 'item',
	'archivable' => FALSE,
	'item_actions' => array(),
	'table_actions' => array(),
	'rows_selectable' => FALSE,
	'clear_cache_on_save' => FALSE,
	'instructions' => 'Site Clicks',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/clicks',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_quick_downloads_log'] = array(
	'module_name' => 'Quick Downloads Log',
	'model_name' => 'gradstate_quick_downloads_log_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/quick_downloads_log',
	'display_field' => 'file_name',
	'archivable' => FALSE,
	'item_actions' => array(),
	'table_actions' => array(),
	'rows_selectable' => FALSE,
	'clear_cache_on_save' => FALSE,
	'instructions' => 'Quick Download Forms',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/quick_downloads_log',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['gradstate_form_downloads'] = array(
	'module_name' => 'Form Downloads',
	'model_name' => 'gradstate_form_downloads_model',
	'model_location' => 'gradstate',
	'module_uri' => 'gradstate/form_downloads',
	'display_field' => 'names',
	'archivable' => FALSE,
	'item_actions' => array(),
	'table_actions' => array(),
	'rows_selectable' => FALSE,
	'clear_cache_on_save' => FALSE,
	'instructions' => 'Form Downloads',
	'configuration' => array('gradstate' => 'gradstate'),
	'nav_selected' => 'gradstate/form_downloads',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);