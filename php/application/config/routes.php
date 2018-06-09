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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['api/v1/projects']['POST'] = 'api/v1/projects/post';
$route['api/v1/projects/(:num)']['GET'] = 'api/v1/projects/get/$1';
$route['api/v1/projects/(:num)']['PUT'] = 'api/v1/projects/put/$1';
$route['api/v1/projects/(:num)']['DELETE'] = 'api/v1/projects/delete/$1';

$route['api/v1/apis']['POST'] = 'api/v1/apis/post';
$route['api/v1/apis/(:num)']['GET'] = 'api/v1/apis/get/$1';
$route['api/v1/apis/(:num)']['PUT'] = 'api/v1/apis/put/$1';
$route['api/v1/apis/(:num)']['DELETE'] = 'api/v1/apis/delete/$1';

$route['api/v1/envs']['POST'] = 'api/v1/envs/post';
$route['api/v1/envs/(:num)']['GET'] = 'api/v1/envs/get/$1';
$route['api/v1/envs/(:num)']['PUT'] = 'api/v1/envs/put/$1';
$route['api/v1/envs/(:num)']['DELETE'] = 'api/v1/envs/delete/$1';

$route['api/v1/envs/(:num)/benchmarks']['POST'] = 'api/v1/benchmarks/post/$1';
$route['api/v1/envs/(:num)/benchmarks/(:num)']['GET'] = 'api/v1/benchmarks/get/$1/$2';

$route['api/v1/scenarios']['POST'] = 'api/v1/scenarios/post';
$route['api/v1/scenarios/(:num)']['GET'] = 'api/v1/scenarios/get/$1';
$route['api/v1/scenarios/(:num)']['PUT'] = 'api/v1/scenarios/put/$1';
$route['api/v1/scenarios/(:num)']['DELETE'] = 'api/v1/scenarios/delete/$1';

$route['api/v1/categories']['POST'] = 'api/v1/categories/post';
$route['api/v1/categories/(:num)']['GET'] = 'api/v1/categories/get/$1';
$route['api/v1/categories/(:num)']['PUT'] = 'api/v1/categories/put/$1';
$route['api/v1/categories/(:num)']['DELETE'] = 'api/v1/categories/delete/$1';