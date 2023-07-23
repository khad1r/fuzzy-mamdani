<?php

class App
{
    protected $controller = 'Kuisioner';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        if (!(new Database(TRUE))) {
            $this->controller = 'Error';
        };
        // var_dump($url);
        if (isset($url['controller']) && file_exists('./controllers/' . $url['controller'] . '.controller.php')) {
            $this->controller = $url['controller'];
            // unset($url[0]);
        }
        require_once './controllers/' . $this->controller . '.controller.php';

        if (isset($url['method']) && method_exists($this->controller, $url['method'])) {
            $this->method = $url['method'];
            // unset($url[1]);
        }
        $this->params = $url['params'];
        call_user_func_array([new $this->controller, $this->method], [$this->params]);
    }

    public function parseURL()
    {
        $url = array_map(fn ($str) => filter_var($str, FILTER_SANITIZE_URL), $_GET);
        if (isset($url['controller']))
            $app['controller'] = $url['controller'];
        if (isset($url['method']))
            $app['method'] = $url['method'];
        unset($url['controller']);
        unset($url['method']);
        $app['params'] = $url;
        return $app;
        // if (isset($_GET['page'])) {
        //     $url = rtrim($_GET['page'], '/');
        //     $url = filter_var($url, FILTER_SANITIZE_URL);
        //     $url = explode('/', $url);
        //     return $url;
        //     } 
    }
    public static function Alert()
    {
        if (isset($_SESSION['alert'])) {
?>
            <div class="alert alert-<?= $_SESSION['alert'][0] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['alert'][1] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        <?php
            unset($_SESSION['alert']);
        }
    }
    public static function CheckUser(...$level)
    {
        if (empty($level)) return isset($_SESSION['user']);
        return isset($_SESSION['user']) && in_array($_SESSION['user']['level_user'], $level);
    }
    public static function InputValidator($input)
    {
        if (isset($_SESSION['InputError'][$input])) {
        ?>
            <br>
            <i class="notice" style="color: red"><?= $_SESSION['InputError'][$input] ?> </i>
<?php
            unset($_SESSION['InputError'][$input]);
        }
    }
    public static function Referer($path = '')
    {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            header('Location:  ' . BASEURL . $path);
        }
    }
    public static function Redirect($path = '')
    {
        header('Location:  ' . BASEURL . $path);
    }
}
