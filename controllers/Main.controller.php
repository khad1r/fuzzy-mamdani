<?php

class Main extends Controller
{
    public function index()
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect('/Logout');
            exit;
        }
        $Iso_model = $this->model('Iso_model');
        $data['checklist'] = $Iso_model->getCriteria();
        $data['sub-kriteria'] = $Iso_model->getSubCriteria();
        $data['pertanyaan'] = $this->model('Pertanyaan_model')->getPertanyaan();
        $data['colspan'] = [];

        foreach ($data['checklist'] as &$kriteria) {
            $i = 1;
            $kriteria['sub-kriteria'] = [];
            $data['colspan'][$kriteria['kode']] = 0;
            while (isset($data['sub-kriteria'][$kriteria['kode'] . "_" . $i])) {
                $sub_kriteria = &$data['sub-kriteria'][$kriteria['kode'] . "_" . $i];
                $j = 1;
                $sub_kriteria['pertanyaan'] = [];
                while (isset($data['pertanyaan'][$sub_kriteria['kode'] . "_" . $j])) {
                    $pertanyaan = &$data['pertanyaan'][$sub_kriteria['kode'] . "_" . $j];
                    $sub_kriteria['pertanyaan'][$sub_kriteria['kode'] . "_" . $j++] = $pertanyaan;
                }
                $data['colspan'][$sub_kriteria['kode']] = $j - 1;
                $data['colspan'][$kriteria['kode']] += ($j - 1);
                $kriteria['sub-kriteria'][$kriteria['kode'] . "_" . $i++] = $sub_kriteria;
            }
        }


        $data['Kuisioner'] = $this->model('Kuisioner_model')->getKuisioner();
        $data['title'] = 'Kuisioner';
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('main/index', $data);
        $this->view('main/kuisioner', $data);
        $this->view('templates/footer');
    }
    public function ringkasan()
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect('/Logout');
            exit;
        }

        $data['checklist'] = $this->model('Iso_model')->getChecklist();
        $subScore = $this->model('Kuisioner_model')->getScoreSubcriteria();
        $score = [];
        foreach ($subScore as &$subscore) {
            $sumScore = [];
            foreach ($data['checklist'] as $key => $value) {
                $sumScore[$key] = 0;
                foreach ($value['sub-kriteria'] as $sub) {
                    $sumScore[$key] += $subscore[$sub['kode']];
                }
            }
            $score[] = $sumScore;
        }
        $data['averageScore'] = $this->model('Skor_model')->setScore($score);

        foreach ($data['checklist'] as &$kriteria) {
            $kriteria['skorKuisioner'] = array_column($score, $kriteria['kode']);
            $kriteria['total'] = $data['averageScore'][$kriteria['kode']];
            foreach ($kriteria['sub-kriteria'] as &$sub) {
                $sub['skorKuisioner'] = array_column($subScore, $sub['kode']);
            }
        }

        $data['title'] = 'Ringkasan';

        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('main/index', $data);
        $this->view('main/ringkasan', $data);
        $this->view('templates/footer');
    }
    public function analisis()
    {
        if (!App::CheckUser()) {
            $_SESSION['alert'] = array('warning', 'Akses Ditolak');
            App::Redirect('/Logout');
            exit;
        }
        $score = $this->model('Skor_model')->getScore();
        if (empty($score)) {
            $_SESSION['alert'] = array('info', 'Skor Belum Terhitung');
            App::Redirect('/Main/ringkasan');
            exit;
        }
        $fuzzy_model = $this->model('Fuzzy_model');
        $maturity = $fuzzy_model->getMaturity()[0]['maturity'] ?? '';
        if (empty($maturity)) {
            $maturity = $fuzzy_model->calculateFuzzy($score['FS'], $score['R'], $score['U']);
        }

        $data['maturity'] = $maturity;
        $data['score'] = $score;
        $data['kriteria'] = $this->model('Iso_model')->getCriteria();

        $data['membership_activity'] = '\assets\export\membership_activity.png';
        $data['membership_function'] = '\assets\export\membership_function.png';
        $data['result_mom'] = '\assets\export\result_mom.png';

        $data['title'] = 'Analisis';
        $this->view('templates/header', $data);
        $this->view('templates/navbar');
        $this->view('main/index', $data);
        $this->view('main/analisis', $data);
        $this->view('templates/footer');
    }
}
