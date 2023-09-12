<?php
use Monolog\Level;

defined('BASE_PATH')        or define('BASE_PATH', '/cardeal');
defined('APP_NAME')         or define('APP_NAME', 'Quinta Cardeal');
defined('APP_DESCRIPTION')  or define('APP_DESCRIPTION', 'Quinta Cardeal');
defined('APP_LANG')         or define('APP_LANG', 'en');
defined('APP_KEYWORDS')         or define('APP_KEYWORDS', 'Quinta Cardeal');


// SLIM
// Should be set to false in production
defined('DISPLAY_ERRORS')   or define('DISPLAY_ERRORS', true);

// logger
defined('LOGGER_REGISTER_ERRORS')           or define('LOGGER_REGISTER_ERRORS', true);
defined('LOGGER_REGISTER_ERRORS_DETAILS')   or define('LOGGER_REGISTER_ERRORS_DETAILS', true);
defined('LOGGER_INTERNAL_CONFIGS')          or define('LOGGER_INTERNAL_CONFIGS', [
    'name' => str_replace(' ','',APP_NAME),
    'path' => '/tmp/app.log',
    'level' => Level::Debug,
]);

// db
defined('DATABASE_HOST')		    or define('DATABASE_HOST', '127.0.0.1');
defined('DATABASE_NAME')		    or define('DATABASE_NAME', 'cardeal');
defined('DATABASE_USER')		    or define('DATABASE_USER', 'xarevision');
defined('DATABASE_PASSWORD')		or define('DATABASE_PASSWORD', '123.123.');
defined('DATABASE_PORT')		    or define('DATABASE_PORT', 3306);

// JWT
defined('ALGORITHM') 			    or define('ALGORITHM', 'HS256');
defined('TYPE') 			        or define('TYPE', 'JWT');
defined('ISSUER') 			        or define('ISSUER', '127.0.0.1');
defined('AUDIENCE') 			    or define('AUDIENCE', [ISSUER]);
defined('SECRET') 			        or define('SECRET', 'LetsGoBusy');
defined('EXPIRATION_TIME_SECONDS') or define('EXPIRATION_TIME_SECONDS', 2 * 60 * 60); // 2h
defined('NOT_BEFORE_SECONDS') 		or define('NOT_BEFORE_SECONDS', 0);

// PHP MAILER
defined('MAIL_FROM')            or define('MAIL_FROM', 'system@maurofilipemaia.dev');
defined('MAIL_FROM_PASSWORD')   or define('MAIL_FROM_PASSWORD', 'f4PbBGm694HxXrTV');
defined('MAIL_SERVER')          or define('MAIL_SERVER', 'mail.maurofilipemaia.dev');
defined('MAIL_PORT')            or define('MAIL_PORT', 587);


function rand_string( $length ): string
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}
