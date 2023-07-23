<?php

class Iso_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getCriteria()
    {
        $this->db->query('SELECT * FROM iso WHERE `sub-kriteria` IS NULL');
        $result = [];
        foreach ($this->db->resultSet() as $value) {
            $result[$value['kode']] = $value;
        }
        return $result;
    }
    public function getSubCriteria()
    {
        $this->db->query('SELECT * FROM iso WHERE `sub-kriteria` IS NOT NULL');
        $result = [];
        foreach ($this->db->resultSet() as $value) {
            $result[$value['kode']] = $value;
        }
        return $result;
    }
    public function getChecklist()
    {

        $checklist = $this->getCriteria();
        $subKriteria = $this->getSubCriteria();

        require_once './models/Pertanyaan_model.php';

        $pertanyaan2 = (new Pertanyaan_model)->getPertanyaan();

        foreach ($checklist as &$kriteria) {
            $i = 1;
            $kriteria['sub-kriteria'] = [];
            while (isset($subKriteria[$kriteria['kode'] . "_" . $i])) {
                $sub_kriteria = &$subKriteria[$kriteria['kode'] . "_" . $i];
                $j = 1;
                $sub_kriteria['pertanyaan'] = [];
                while (isset($pertanyaan2[$sub_kriteria['kode'] . "_" . $j])) {
                    $pertanyaan = &$pertanyaan2[$sub_kriteria['kode'] . "_" . $j];
                    $sub_kriteria['pertanyaan'][$sub_kriteria['kode'] . "_" . $j++] = &$pertanyaan;
                }
                $kriteria['sub-kriteria'][$kriteria['kode'] . "_" . $i++] = &$sub_kriteria;
            }
        }
        return $checklist;
    }
}
