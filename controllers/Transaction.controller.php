<?php

class Transaction extends Controller
{
    public function index($data)
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect();
            exit;
        }
        $date = (isset($data["date"])) ? $data["date"] : date('Y-m-d');
        $data['title'] = 'Transaksi';
        $data['transactions'] = $this->model('Transaction_model')->getTransactionsByDate($date);
        $data['instances'] = $this->model('Instance_model')->getInstances();
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('transaction/header');
        $this->view('transaction/transactions', $data);
        $this->view('templates/footer');
    }
    public function sales($data)
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect();
            exit;
        }
        $month = (isset($data["month"])) ? $data["month"] : date('Y-m');
        $data['title'] = 'Penjualan';
        $data['sales'] = $this->model('Fuel_model')->getSalesByMonth($month);

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('transaction/header');
        $this->view('transaction/sales', $data);
        $this->view('templates/footer');
    }
    public function record()
    {
        if (!App::CheckUser("admin", 'petugas')) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Referer();
            exit;
        }

        $data['title'] = 'Catat Transaksi';
        $data['fuels'] = $this->model('Fuel_model')->getFormatedfuels();
        $data['instances'] = $this->model('Instance_model')->getInstances();
        $data['payings']    = $this->model('Paying_model')->getPayingMethods();
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        if (App::CheckUser('admin')) $this->view('transaction/header');
        $this->view('transaction/record', $data);
        $this->view('templates/footer');
    }
    public function update($data)
    {
        if (!App::CheckUser('petugas', 'admin') || !isset($data['id'])) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Referer();
            exit;
        }

        $data['transaction'] = $this->model('Transaction_model')->getTransactionsById($data['id']);

        if (
            date('Y-m-d', strtotime($data['transaction']['timestamp'])) != date('Y-m-d')
            && ($data['transaction']['petugas'] != $_SESSION['user']['username']) && !App::CheckUser('admin')
        ) {
            $_SESSION['alert'] = array('danger', 'Transaksi hanya dapat diubah pada hari yang sama!!!');
            App::Referer();
            exit;
        }

        $data['title'] = 'Update Transaksi';
        $data['fuels'] = $this->model('Fuel_model')->getFormatedfuels();

        $data['instances'] = $this->model('Instance_model')->getInstances();
        $data['payings']    = $this->model('Paying_model')->getPayingMethods();
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('transaction/record', $data);
        $this->view('transaction/updateAddon', $data);
        $this->view('templates/footer');
    }
    public function submit()
    {
        if (!App::CheckUser("admin", 'petugas')) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Referer();
            exit;
        }

        if (!isset($_POST['record'])) App::Referer();

        try {

            $insert = (isset($_POST['record']) && !isset($_POST['id'])) ?
                $this->model('Transaction_model')->insertTransaction($_POST)
                : $this->model('Transaction_model')->updateTransaction($_POST);
            if ($insert > 0) {
                $_SESSION['alert'] = array('success', 'Operasi Berhasil');
                App::Referer('/Transaction/record/');
                exit;
            } else {
                $_SESSION['alert'] = array('danger', 'Operasi Gagal');
                App::Referer('/Transaction/record/');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['alert'] = ['danger', $e->getMessage()];
            App::Referer('/Transaction/record/');
            exit;
        }
    }
    public function getRecap()
    {
        header('Content-Type: application/json');
        echo json_encode($this->model('Transaction_model')->getRecapByMonthAndInstance($_POST));
    }
    public function getBill()
    {
        if (!App::CheckUser('admin', 'bag. teknik', 'bag. keuangan')) return;
        $data['instances'] = $this->model('Instance_model')->getInstancesById($_POST['id_instansi']);
        $data['transactions'] = $this->model('Transaction_model')->getTransactionsByMonthAndInstance($_POST);
        $excel = $this->model('ExportExcel');

        $excel->addSheet($data['instances']['nama_instansi']);
        $excel->setHeader($data['instances']);
        $excel->generateTable($data);
        $excel->setPeriod();

        $excel->setFooter(SIGNATURE);
        setlocale(LC_ALL, 'id-ID', 'id_ID');
        $this->setCookieToken('DownloadCookie', 'Rekap' . $_POST['id_instansi'], false);
        $excel->download("Rekap Tagihan " . $data['instances']['nama_instansi'] . ' ' . strftime("%B %Y", strtotime($_POST['month'] ?? '0000-00')),);
    }
    public function getBills()
    {
        if (!App::CheckUser('admin', 'bag. teknik', 'bag. keuangan')) return;
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '2048M');


        $excel = $this->model('ExportExcel');
        $instances = $this->model('Instance_model')->getInstances();
        foreach ($instances as $instance) {
            $data['transactions'] = $this->model('Transaction_model')->getTransactionsByMonthAndInstance(['month' => $_POST['month'], 'id_instansi' => $instance['id_instansi']]);
            $excel->addSheet($instance['nama_instansi']);
            $excel->setHeader($instance);
            $excel->generateTable($data);
            $excel->setPeriod();
            $excel->setFooter(SIGNATURE);
        }

        setlocale(LC_ALL, 'id-ID', 'id_ID');
        $this->setCookieToken('DownloadCookie', 'RekapBulanan', false);
        $excel->download("Rekap Tagihan " . strftime("%B %Y", strtotime($_POST['month'] ?? '0000-00')));
    }
    public function getDaily()
    {
        if (!App::CheckUser('admin', 'bag. teknik')) return;
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '2048M');


        $excel = $this->model('ExportExcel');
        $payments = $this->model('Paying_model')->getPayingMethods();
        foreach ($payments as $paying) {
            $data['transactions'] = $this->model('Transaction_model')->getTransactionsByDateAndPaying($_POST['date'], $paying['id']);
            $excel->addSheet($paying['metode_pembayaran']);
            $excel->generateSalesTable($data);
        }

        setlocale(LC_ALL, 'id-ID', 'id_ID');
        $this->setCookieToken('DownloadCookie', 'RekapHarian', false);
        $excel->download("Rekap Penjualan " . strftime("%d %B %Y", strtotime($_POST['date'])));
    }
}
