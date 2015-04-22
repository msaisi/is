<?php 
$companies_controllers = array('accounts','users','departments');
foreach($companies_controllers as $c)
{
	$route[FUEL_ROUTE.'companies/'.$c] = FUEL_FOLDER.'/module';
	$route[FUEL_ROUTE.'companies/'.$c.'/(.*)'] = FUEL_FOLDER.'/module/$1';
}
$route[FUEL_ROUTE.'companies/settings'] = COMPANIES_FOLDER.'/settings';