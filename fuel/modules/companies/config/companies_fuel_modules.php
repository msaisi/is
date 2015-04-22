<?php
$config['modules']['companies_accounts'] = array(
	'module_name' => 'Insurance Companies',
	'module_uri' => 'companies/accounts',
	'model_name' => 'companies_accounts_model',
	'model_location' => 'companies',
	'display_field' => 'company_code',
	'permission' => 'companies_accounts',
	'instructions' => lang('module_instructions_default', 'insurance company accounts'),
	'archivable' => TRUE,
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/accounts',
	'default_col' => 'company_code',
	'default_order' => 'desc',
	'sanitize_input' => array('template','php')
);

$config['modules']['companies_users'] = array(
	'module_name' => 'Staff & Users',
	'module_uri' => 'companies/users',
	'model_name' => 'companies_users_model',
	'model_location' => 'companies',
	'display_field' => 'email',
	'permission' => 'companies_users',
	'instructions' => lang('module_instructions_default', 'company users'),
	'archivable' => TRUE,
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/users',
	'default_col' => 'email',
	'default_order' => 'desc',
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_departments'] = array(
	'module_name' => 'Company Departments',
	'module_uri' => 'companies/departments',
	'model_name' => 'companies_departments_model',
	'model_location' => 'companies',
	'display_field' => 'department_code',
	'permission' => 'companies_users',
	'instructions' => lang('module_instructions_default', 'company departments'),
	'archivable' => TRUE,
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/departments',
	'default_col' => 'department_code',
	'default_order' => 'desc',
	'sanitize_input' => array('template','php')
);
/*$config['modules']['company_users'] = array(
	'module_name' => 'Company Users',
	'model_name' => 'is_company_users_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/company_users',
	'display_field' => 'email',
	'instructions' => 'Manage users',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/sectors',	
	'permission' => 'companies_sectors',
	'exportable' => TRUE,	
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);


/*$config['modules']['companies_sectors'] = array(
	'module_name' => 'Job Sectors',
	'model_name' => 'companies_sectors_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/sectors',
	'display_field' => 'name',
	'instructions' => 'Manage job sectors',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/sectors',	
	'permission' => 'companies_sectors',
	'exportable' => TRUE,	
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_institution_types'] = array(
	'module_name' => 'Institution Types',
	'model_name' => 'companies_institution_types_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/institution_types',
	'display_field' => 'name',
	'permission' => 'companies_institution_types',
	'instructions' => 'Manage institution types',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/institution_types',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_class_types'] = array(
	'module_name' => 'Class Types',
	'model_name' => 'companies_class_types_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/class_types',
	'permission' => 'companies_class_types',
	'display_field' => 'name',
	'instructions' => 'Manage class types',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/class_types',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_course_levels'] = array(
	'module_name' => 'Course Levels',
	'model_name' => 'companies_course_levels_model',
	'model_location' => 'companies',
	'permission' => 'companies_course_levels',
	'module_uri' => 'companies/course_levels',
	'display_field' => 'name',
	'instructions' => 'Manage class types',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/course_levels',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_course_types'] = array(
	'module_name' => 'Course Types',
	'model_name' => 'companies_course_types_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/course_types',
	'display_field' => 'name',
	'instructions' => 'Manage course types',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/course_types',
	'permission' => 'companies_course_types',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_faculties'] = array(
	'module_name' => 'Faculties',
	'model_name' => 'companies_faculties_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/faculties',
	'display_field' => 'name',
	'instructions' => 'Manage faculties',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/faculties',
	'permission' => 'companies_faculties',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_features'] = array(
	'module_name' => 'Features',
	'model_name' => 'companies_features_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/features',
	'display_field' => 'name',
	'instructions' => 'Manage features',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/features',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_features_subscriptions'] = array(
	'module_name' => 'Features subscriptions',
	'model_name' => 'companies_features_subscriptions_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/features_subscriptions',
	'display_field' => 'institution_name',
	'instructions' => 'Manage features subscriptions',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/features_subscriptions',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_countries'] = array(
	'module_name' => 'Countries',
	'model_name' => 'companies_countries_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/countries',
	'display_field' => 'name',
	'instructions' => 'Manage countries',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/countries',
	'exportable' => TRUE,
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_counties'] = array(
	'module_name' => 'Counties',
	'model_name' => 'companies_counties_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/counties',
	'display_field' => 'name',
	'instructions' => 'Manage counties',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/counties',
	'exportable' => TRUE,
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_packages'] = array(
	'module_name' => 'Packages',
	'model_name' => 'companies_packages_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/packages',
	'display_field' => 'name',
	'instructions' => 'Manage packages',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/packages',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_package_pricing'] = array(
	'module_name' => 'Package Prices',
	'model_name' => 'companies_package_pricing_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/package_pricing',
	'display_field' => 'name',
	'instructions' => 'Manage package prices',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/package_pricing',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_packages_subscriptions'] = array(
	'module_name' => 'Packages subscriptions',
	'model_name' => 'companies_packages_subscriptions_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/packages_subscriptions',
	'display_field' => 'institution_name',
	'instructions' => 'Manage packages subscriptions',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/packages_subscriptions',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_qualifications'] = array(
	'module_name' => 'Qualifications',
	'model_name' => 'companies_qualifications_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/qualifications',
	'display_field' => 'name',
	'instructions' => 'Manage qualifications',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/qualifications',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_institutions'] = array(
	'module_name' => 'Institution Profiles',
	'model_name' => 'companies_institutions_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/institutions',
	'display_field' => 'institution_name',
	'instructions' => 'Manage institution profiles',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/institutions',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_international_universities'] = array(
	'module_name' => 'International Universities Profiles',
	'model_name' => 'companies_international_universities_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/international_universities',
	'display_field' => 'institution_name',
	'instructions' => 'Manage international universities profiles',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/international_universities',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);

$config['modules']['companies_campuses'] = array(
	'module_name' => 'Campuses',
	'model_name' => 'companies_campuses_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/campuses',
	'permission' => 'companies_campuses',
	'display_field' => 'campus_name',
	'instructions' => 'Manage institution campuses',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/campuses',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);

$config['modules']['companies_courses'] = array(
	'module_name' => 'Courses',
	'model_name' => 'companies_courses_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/courses',
	'display_field' => 'course_title',
	'instructions' => 'Manage courses',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/courses',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);

$config['modules']['companies_top_banners'] = array(
	'module_name' => 'Top banners',
	'model_name' => 'companies_top_banners_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/top_banners',
	'display_field' => 'title',
	'instructions' => 'Manage top banners',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/top_banners',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_hot_courses'] = array(
	'module_name' => 'Hot Courses',
	'model_name' => 'companies_hot_courses_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/hot_courses',
	'display_field' => 'institution_name',
	'instructions' => 'Manage hot Courses',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/hot_courses',
	'exportable' => TRUE,
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_quick_downloads'] = array(
	'module_name' => 'Quick Downloads',
	'model_name' => 'companies_quick_downloads_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/quick_downloads',
	'display_field' => 'file_name',
	'instructions' => 'Manage quick downloads',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/quick_downloads',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_home_sliders'] = array(
	'module_name' => 'Home Sliders',
	'model_name' => 'companies_home_sliders_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/home_sliders',
	'display_field' => 'header',
	'instructions' => 'Manage home sliders',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/home_sliders',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_clicks'] = array(
	'module_name' => 'Site Clicks',
	'model_name' => 'companies_clicks_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/clicks',
	'display_field' => 'item',
	'archivable' => FALSE,
	'item_actions' => array(),
	'table_actions' => array(),
	'rows_selectable' => FALSE,
	'clear_cache_on_save' => FALSE,
	'instructions' => 'Site Clicks',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/clicks',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_quick_downloads_log'] = array(
	'module_name' => 'Quick Downloads Log',
	'model_name' => 'companies_quick_downloads_log_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/quick_downloads_log',
	'display_field' => 'file_name',
	'archivable' => FALSE,
	'item_actions' => array(),
	'table_actions' => array(),
	'rows_selectable' => FALSE,
	'clear_cache_on_save' => FALSE,
	'instructions' => 'Quick Download Forms',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/quick_downloads_log',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);
$config['modules']['companies_form_downloads'] = array(
	'module_name' => 'Form Downloads',
	'model_name' => 'companies_form_downloads_model',
	'model_location' => 'companies',
	'module_uri' => 'companies/form_downloads',
	'display_field' => 'names',
	'archivable' => FALSE,
	'item_actions' => array(),
	'table_actions' => array(),
	'rows_selectable' => FALSE,
	'clear_cache_on_save' => FALSE,
	'instructions' => 'Form Downloads',
	'configuration' => array('companies' => 'companies'),
	'nav_selected' => 'companies/form_downloads',
	'exportable' => TRUE,
	'advanced_search' => TRUE,	
	'sanitize_input' => array('template','php')
);*/