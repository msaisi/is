<?php 
$gradstate_controllers = array('sectors','institution_types','class_types','course_levels','course_types','faculties','features','countries','counties','packages','qualifications','institutions','campuses','courses','packages_subscriptions','features_subscriptions','package_pricing','top_banners','hot_courses','home_sliders','clicks','international_universities','quick_downloads','quick_downloads_log','form_downloads');
foreach($gradstate_controllers as $c)
{
	$route[FUEL_ROUTE.'gradstate/'.$c] = FUEL_FOLDER.'/module';
	$route[FUEL_ROUTE.'gradstate/'.$c.'/(.*)'] = FUEL_FOLDER.'/module/$1';
}
$route[FUEL_ROUTE.'gradstate/settings'] = GRADSTATE_FOLDER.'/settings';