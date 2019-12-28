<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
defined('EBAYTOKEN')   OR define('EBAYTOKEN', 'v^1.1#i^1#p^3#f^0#r^0#I^3#t^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'); // ebay access token
defined('EBAYAPIURL')   OR define('EBAYAPIURL', 'https://api.sandbox.ebay.com/'); // ebay API URL