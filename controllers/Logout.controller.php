<?php

class Logout extends Controller
{
    public function index()
    {
        if (isset($_SESSION['alert'])) $err = $_SESSION['alert'];
        session_destroy();
        if (isset($err)) {
            session_cache_expire(5);
            session_start();
            $_SESSION['alert'] = $err;
        }
        unset($_SESSION['user']);
        header('Location: ' . BASEURL);
    }
}
