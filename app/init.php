<?php
if (session_status() === PHP_SESSION_NONE) {
    session_cache_expire(5);
    session_start();
}
setlocale(LC_TIME, 'id_ID.UTF-8');

require_once './config/config.php';
require_once './app/App.php';
require_once './app/Controller.php';
require_once './app/Database.php';
