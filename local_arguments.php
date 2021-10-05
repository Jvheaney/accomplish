<?php
//This is a file that contains our connection to the database.
//This file _MUST_ be kept out of public directories.

//Static variables
$DB_ADDRESS="";                        //Our database server address.
$DB_PORT="";                                //Our database server ports.
$DB_NON_SU_USER="";                       //Our non-superuser for our database. This should be the same as the one you used in setupDatabases.php.
$DB_NON_SU_USER_PASSWORD="";       //Our non-superuser password.

//Our connection string that will work after our setupDatabases.php script is run.
$con = pg_connect("host=$DB_ADDRESS port=$DB_PORT dbname=accomplish user=$DB_NON_SU_USER password=$DB_NON_SU_USER_PASSWORD");
?>
