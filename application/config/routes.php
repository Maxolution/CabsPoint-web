<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['fc67acb6f59ebc033d412b614f82ecd4'] = 'Super_admin/dashboard';
$route['67a86d29dd2494711a0d032fd62e0ec7'] = 'Super_admin/index/login';
$route['849172a0dba90114a06e1921528cedf2'] = 'Super_admin/index/logout';
$route['d40a5a0980d046b205fab493a6c78941'] = 'Super_admin/index/profile_setting';
$route['4902a77a081a80ef0e8b1940076dc67e'] = 'Super_admin/index/update_profile_setting';

/*profile_seting*/

$route['aec1fbaa98a4c342c64e1b6b83e45844'] = 'Super_admin/Offerjobs';
$route['e6a46816fc7498371daa68d5870a2dbc/(:any)'] = 'Super_admin/Offerjobs/addeditofferjobs/$1';
$route['a0784cc46e660bb7e1d35b49ae1e451e'] = 'Super_admin/CarTypeController';
$route['92a18ebfa7b2226dcdcbf2ebc13b5697'] = 'Super_admin/CarTypeController/savecartype';

/*==========Driver Section=========*/
$route['b3a3a48e959abffb5894f1d9577dc34c'] = 'Super_admin/DriverController/on_boarding_driver';
$route['c78c863c8df705ed4219c05d9aef69e1'] = 'Super_admin/DriverController/driver_document';
$route['c78c863c8df705ed4219c05d9aef69e1/(:any)'] = 'Super_admin/DriverController/driver_document/$1';

