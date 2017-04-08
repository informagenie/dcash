<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/**** USER DEFINED CONSTANTS **********/

define('ROLE_ADMIN',                            '1');
define('ROLE_MANAGER',                         	'2');
define('ROLE_EMPLOYEE',                         '3');
define('ROLE_VENDOR',                           '4');
define('ROLE_LIVREUR',                          '5');

define('SEGMENT',								2);
define('BEGIN_KEY','Sikoyo, na tuna nanu, ozo luka nini vraiment ??? Que cherches tu vraiment ? à nuire ???');
define('END_KEY', 'Même si je ne te vois pas, sache que Dieu te vois. En plus, ça n\'ira pas pour longtemps tout va changer');
define('VODACOM', 1);
define('ORANGE', 2);
define('AIRTEL', 3);

define('DEVISE_USD', 1);
define('DEVISE_CDF', 2);
define('DEVISE_DEFAULT', DEVISE_USD);

define('STATUS_WAIT', 1);
define('STATUS_PROCESS', 2);
define('STATUS_SUCCESS', 3);
define('STATUS_MISSING', 4);
define('STATUS_END', 5);
define('STATUS_UNKNOW', 0);
define('STATUS_READY', 6);

define('SERVER_TIMEZONE', 'UTC');
define('SERVER_DATEFORMAT', 'Y-m-d H:i:s');

define('E_COMMERCE_HOST', 'https://localhost/wordpress/');
define('SEPARATOR', ' - ');
define('SITE_NAME', 'DIGABLO CASH');
define('SITE_DESCRIPTION', 'Permet de faire des paiements mobiles supportant MPESA, Airtel Money et Orange Money');
/* End of file constants.php */
/* Location: ./application/config/constants.php */