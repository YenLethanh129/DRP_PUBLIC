<?php

/*
  Here is define connect to MySQL server in localhost
  ----------------------------------------------------------------------------------
    !!! Note to RUNNING SERVER  !!!
    
    =>DB_NAME, DB_USER, DB_PASSWORD need to replace with settings in DataBase Table

    =>DB_SOCKET can other PATH
  ----------------------------------------------------------------------------------

*/

// define connection
define('DB_CONNECTION', 'mysql');
define('DB_HOST', 'mysql-db');
define('DB_NAME', 'ct07_db');
define('DB_USER', 'ad_db_ct07');
define('DB_PASSWORD', 'admin');
define('DB_PORT', '3306');
define('DB_SOCKET', "/var/lib/mysql/mysql.sock");
?>