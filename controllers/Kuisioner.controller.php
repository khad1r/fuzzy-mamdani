<?php

class Kuisioner extends Controller
{
    public function index()
    {

        $gayabelajar_model = $this->model('gayabelajar_model');
        $data = [];
        $data['kriteria'] = $gayabelajar_model->getCriteria();
        $data['sub-kriteria'] = $gayabelajar_model->getSubCriteria();
        $data['pertanyaan'] = $this->model('Pertanyaan_model')->getPertanyaan();

        $this->view('templates/header', array('title' => 'Kuisioner'));
        $this->view('templates/navbar');
        $this->view('kuisioner/index', $data);
        $this->view('templates/footer');
    }
    public function done()
    {
        if (!isset($_POST['kuisioner'])) App::Referer();
        unset($_POST['kuisioner']);
        [$skor_v, $skor_a, $skor_k, $hasil] = $this->model('Kuisioner_model')->insert($_POST);
        $deskripsi_V = '';
        $deskripsi_A = '';
        $deskripsi_K = '';

        if ($hasil[0] <= 10) {
            $deskripsi_V = 'Kurang Direkomendasikan';
        } elseif (10 < $hasil[0] && $hasil[0] <= 70) {
            $deskripsi_V = 'Direkomendasikan';
        } elseif ($hasil[0] > 70) {
            $deskripsi_V = 'Sangat Direkomendasikan';
        }

        if ($hasil[1] <= 10) {
            $deskripsi_A = 'Kurang Direkomendasikan';
        } elseif (10 < $hasil[1] && $hasil[1] <= 70) {
            $deskripsi_A = 'Direkomendasikan';
        } elseif ($hasil[1] > 70) {
            $deskripsi_A = 'Sangat Direkomendasikan';
        }

        if ($hasil[2] <= 10) {
            $deskripsi_K = 'Kurang Direkomendasikan';
        } elseif (10 < $hasil[2] && $hasil[0] <= 70) {
            $deskripsi_K = 'Direkomendasikan';
        } elseif ($hasil[2] > 70) {
            $deskripsi_K = 'Sangat Direkomendasikan';
        }

        $data['HASIL_V'] = $deskripsi_V;
        $data['HASIL_A'] = $deskripsi_A;
        $data['HASIL_K'] = $deskripsi_K;

        $this->view('templates/header', array('title' => 'Kuisioner'));
        $this->view('templates/navbar');
        $this->view('kuisioner/done', $data);
        $this->view('templates/footer');
    }
    public function rekap()
    {

        $gayabelajar_model = $this->model('gayabelajar_model');
        $data['checklist'] = $gayabelajar_model->getCriteria();
        $data['sub-kriteria'] = $gayabelajar_model->getSubCriteria();
        $data['pertanyaan'] = $this->model('Pertanyaan_model')->getPertanyaan();

        foreach ($data['checklist'] as &$kriteria) {
            $i = 1;
            while (isset($data['pertanyaan'][$kriteria['kode'] . "_" . $i])) {
                $pertanyaan = &$data['pertanyaan'][$kriteria['kode'] . "_" . $i];
                $kriteria['pertanyaan'][$kriteria['kode'] . "_" . $i++] = $pertanyaan;
            }
        }
        $data['Kuisioner'] = $this->model('Kuisioner_model')->getKuisioner();
        $data['title'] = 'Kuisioner';
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('kuisioner/rekap', $data);
        $this->view('templates/footer');
    }
}
