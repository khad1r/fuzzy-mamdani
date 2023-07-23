<?php
class Kuisioner_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getKuisioner()
    {
        $this->db->query('SELECT * FROM kuisioner');
        return $this->db->resultSet();
    }
    public function insert($data)
    {
        $error = [];
        foreach ($data as $key => $val) {
            if (($key == 'id_instansi' && $val == '0') || $key == 'keterangan') continue;
            if (empty($val)) $error[$key] = 'Input Ini Tidak Boleh Kosong!!!';
        }
        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Input Belum terisi!!");
        }

        foreach ($data as &$input) $input = htmlspecialchars($input);

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }

        require_once './models/Pertanyaan_model.php';
        $kodePertanyaan = (new Pertanyaan_model)->getKodePertanyaan();
        // if ($id == 0) throw new Exception("Instansi ini tidak boleh dihapus!!");
        $query = "INSERT INTO kuisioner VALUES (null,:email,:nama,:program_studi,:" . implode(',:', $kodePertanyaan) . ")";
        $this->db->query($query);
        foreach ($data as $key => $input) {
            $this->db->bind($key, $input);
        }
        $this->db->execute();

        require_once './models/Skor_model.php';
        require_once './models/Fuzzy_model.php';
        (new Skor_model)->resetScore();
        (new Fuzzy_model)->resetMaturity();
        return $this->db->affectedRows();
    }
    public function getScoreSubcriteria()
    {
        require_once './models/Iso_model.php';
        $checklist = (new Iso_model)->getChecklist();
        $select = [];
        foreach ($checklist as $kriteria) foreach ($kriteria['sub-kriteria'] as $sub_kriteria) {
            $i = 1;
            $select[] = "(((" . implode('+', array_column($sub_kriteria['pertanyaan'], 'kode')) . ")/" . count($sub_kriteria['pertanyaan']) * 100 . ")*{$sub_kriteria['skor']})" . " AS {$sub_kriteria['kode']}";
        }
        $this->db->query('SELECT ' . implode(', ', $select) . ' FROM kuisioner');
        return $this->db->resultSet();
    }
}
