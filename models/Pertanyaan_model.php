<?php
class Pertanyaan_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getPertanyaan()
    {
        $this->db->query('SELECT * FROM pertanyaan');
        $result = [];
        foreach ($this->db->resultSet() as $value) {
            $result[$value['kode']] = $value;
        }
        return $result;
    }
    public function getKodePertanyaan()
    {
        $this->db->query('SELECT * FROM pertanyaan');
        $result = $this->db->resultSet();
        $result =  array_column($result, 'kode');
        return $result;
    }
}
