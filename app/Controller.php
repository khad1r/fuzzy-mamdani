<?php

class Controller
{
    public function view($view, $data = [], $return = false)
    {
        if ($return) {
            ob_start();
            require_once './views/' . $view . '.view.php';
            return ob_get_clean();
        } else {
            require_once './views/' . $view . '.view.php';
        }
    }
    public function model($model)
    {
        require_once './models/' . $model . '.php';
        return new $model;
    }
    public function setCookieToken(
        $cookieName,
        $cookieValue,
        $httpOnly = true,
        $secure = false,
        $expire = 0
    ) {
        // if (empty($expire)) $expire = strtotime("+1 day", time());
        // See: http://stackoverflow.com/a/1459794/59087
        // See: http://shiflett.org/blog/2006/mar/server-name-versus-http-host
        // See: http://stackoverflow.com/a/3290474/59087
        setcookie(
            $cookieName,
            $cookieValue,
            $expire,                // NextYear
            "/",                   // your path
            // $_SERVER["HTTP_HOST"], // your domain
            $secure,               // Use true over HTTPS
            $httpOnly              // Set true for $AUTH_COOKIE_NAME
        );
    }
}
