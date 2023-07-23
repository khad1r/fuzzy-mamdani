<?php

class Kuisioner extends Controller
{
    public function index()
    {
        if (isset($_POST['kuisioner'])) {
            $this->hanldePost();
            return;
        }
        $Iso_model = $this->model('Iso_model');
        $data = [];
        $data['kriteria'] = $Iso_model->getCriteria();
        $data['sub-kriteria'] = $Iso_model->getSubCriteria();
        $data['pertanyaan'] = $this->model('Pertanyaan_model')->getPertanyaan();

        $this->view('templates/header', array('title' => 'Kuisioner'));
        $this->view('templates/navbar');
        $this->view('kuisioner/index', $data);
        $this->view('templates/footer');
    }
    public function done()
    {
        $this->view('templates/header', array('title' => 'Kuisioner'));
        $this->view('templates/navbar');
        $this->view('kuisioner/done');
        $this->view('templates/footer');
    }
    private function hanldePost()
    {
        if (isset($_POST['kuisioner'])) {
            unset($_POST['kuisioner']);
            try {
                if ($this->model('Kuisioner_model')->insert($_POST) > 0) {
                    $_SESSION['alert'] = array('success', 'Berhasil Submit Kuisioner');
                    App::Redirect('/kuisioner/done');
                    exit;
                } else {
                    $_SESSION['alert'] = array('danger', 'Gagal Submit Kuisioner');
                    App::Referer('/kuisioner');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION['alert'] = ['danger', $e->getMessage()];
                App::Referer('/kuisioner');
                exit;
            }
        }
        App::Referer();
    }
}
