<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "index";
$route['404_override'] = '';

$route['admin/forgotpassword'] = "admin/index/forgotpassword";
$route['profile'] = "profile/index";
$route['admin'] = "admin/index";
$route['contactus'] = "index/contact";
$route['aboutus'] = "index/about";
$route['profile/addstamp/(:any)'] = "userstamp/edit/$1";
$route['profile/addstamp'] = "userstamp/add";

$route['tags/(:any)'] = "index/index/$1";
$route['user/(:any)'] = "index/index/$1";
$route['getstamps'] = "index/getStamp";
$route['getstamps/(:any)'] = "index/getStamp/$1";

$route['album'] = "index/album";

$route['signup'] = "index/signup";
$route['login'] = "index/login";
$route['forgotpassword'] = "index/forgotpassword";
#$route['profile/myalbum/(:any)'] = "useralbum/edit/$1";

##$route['profile/album/(:any)'] = "profile/album/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
