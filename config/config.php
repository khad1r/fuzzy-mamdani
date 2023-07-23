<?php

if ($_SERVER['SERVER_NAME'] === "localhost") {
    define('BASEURL', 'https://' . $_SERVER['HTTP_HOST'] . '/fuzzy-mamdani');
} else {
    define('BASEURL', 'https://' . $_SERVER['HTTP_HOST']);
}
// define('BASEURL', 'https://' . $_SERVER['HTTP_HOST']);
define('WEB_TITLE', 'Fuzzy Mamdani');
define('FIRST_DATE', '2022-09-06');

//DB
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fuzzy-interference');
// //DB
// define('DB_HOST', 'localhost');
// define('DB_USER', 'wwwgresi_pertashop5P61116');
// define('DB_PASS', 'KvdqNhC6uLjtQsb');
// define('DB_NAME', 'wwwgresi_pertashop_5P.611.16');