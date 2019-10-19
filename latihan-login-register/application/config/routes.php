<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['profile']    = 'user/profile';
 
$route['register']   = 'auth/register';
$route['login']      = 'auth/login';
$route['logout']     = 'auth/logout';
$route['verify/(:any)/(:any)'] = 'auth/verify_register/$1/$2';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
