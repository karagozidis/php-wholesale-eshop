<?php
// HTTP
define('HTTP_SERVER', 'http://ikr.gr/access/');

// HTTPS
define('HTTPS_SERVER', 'http://ikr.gr/access/');

// DIR
define('DIR_APPLICATION', '/var/www/vhosts/ikr.gr/httpdocs/access/catalog/');
define('DIR_SYSTEM', '/var/www/vhosts/ikr.gr/httpdocs/access/system/');
define('DIR_IMAGE', '/var/www/vhosts/ikr.gr/httpdocs/access/image/');
define('DIR_STORAGE', '/var/www/vhosts/ikr.gr/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'nwusr1');
define('DB_PASSWORD', '1qaz2wsx3edc!');
define('DB_DATABASE', 'accessdb');
define('DB_PORT', '3306');
define('DB_PREFIX', 'avepf_');