<?php

class Setting extends Controller
{
    public function index($data)
    {
        $this->instance($data);
    }
    public function instance($data)
    {
        if (!App::CheckUser("admin", "bag. teknik")) {
            App::Referer();
            exit;
        }
        $data['title']      = 'Pengaturan';
        $data['instances']  = $this->model('Instance_model')->getInstances();
        if (isset($data['editInstansi']))
            $data['editInstansi'] = $this->model('Instance_model')->getInstancesById($data['editInstansi']);

        $data['page'] = $this->view('setting/instance', $data, TRUE);

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('setting/setting', $data);
        $this->view('templates/footer');
    }
    public function user($data)
    {
        if (!App::CheckUser("admin")) {
            App::Referer();
            exit;
        }
        $data['title']      = 'Pengaturan';
        $data['users']      = $this->model('User_model')->getAllUser();
        if (isset($data['editUser']))
            $data['editUser'] = $this->model('User_model')->getUserByUsername($data['editUser']);

        $data['page'] = $this->view('setting/user', $data, TRUE);

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('setting/setting', $data);
        $this->view('templates/footer');
    }
    public function paying($data)
    {
        if (!App::CheckUser("admin", "bag. teknik")) {
            App::Referer();
            exit;
        }
        $data['title']      = 'Pengaturan';
        $data['payings']    = $this->model('Paying_model')->getPayingMethods();
        if (isset($data['editPembayaran']))
            $data['editPembayaran'] = $this->model('Paying_model')->getPayingMethodById($data['editPembayaran']);

        $data['page'] = $this->view('setting/paying', $data, TRUE);

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('setting/setting', $data);
        $this->view('templates/footer');
    }
    public function refresh($data)
    {
        if (!App::CheckUser("admin", "bag. teknik")) {
            App::Referer();
            exit;
        }
        if (isset($_POST['refresh'])) {

            ini_set('max_execution_time', 600);
            ini_set('memory_limit', '2048M');

            try {
                $this->model('Fuel_model')->refresh();
                $_SESSION['alert'] = array('success', 'Operasi Berhasil');
                App::Redirect('/Setting/refresh');
                exit;
            } catch (Exception $e) {
                $_SESSION['alert'] = ['danger', $e->getMessage()];
                App::Referer('/Setting/refresh');
                exit;
            }
        }
        $data['title']      = 'Pengaturan';
        $data['page']       = $this->view('setting/refresh', $data, TRUE);

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('setting/setting', $data);
        $this->view('templates/footer');
    }
}
