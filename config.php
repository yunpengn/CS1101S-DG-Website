<?php
// Settings that is required for connecting to the database server.
define('DB_TYPE', 'mysql', true);
define('DB_HOST', 'localhost', true);
define('DB_NAME', 'cs1101s', true);
define('DB_UNAME', 'cs1101s', true);
define('DB_PWORD', '123456', true);

// Gets the DSN to help create connection to the database.
$dsn = DB_TYPE . ":host=" . DB_HOST . ";db_name=" . DB_NAME;
define('DSN', $dsn, true);
?>
