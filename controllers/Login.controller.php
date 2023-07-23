<?php

class Login extends Controller
{
    public function index()
    {

        if (isset($_POST['login'])) {
            $user = $this->model('User_model')->getUser($_POST);
            if (!empty($user)) {
                $_SESSION['user'] = $user;
                App::Redirect('/Main');
            } else {
                header("Refresh:0");
                $_SESSION['alert'] = ['danger', 'Username atau Password Salah'];
            }
        }

        $this->view('templates/header', array('title' => 'Login'));
        $this->view('login/login');
        $this->view('templates/footer');

        if (App::CheckUser()) {
            App::Redirect('/Main');
            exit;
        }
    }
}
