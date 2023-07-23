<?php

class Fuzzy_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getMaturity()
    {
        $this->db->query('SELECT maturity FROM fuzzy');
        return $this->db->resultSet();
    }
    public function setMaturity($data)
    {
        $this->db->query('INSERT INTO fuzzy VALUE (:maturity)')
            ->bind('maturity', $data)
            ->execute()
            ->affectedRows();
        return $data;
    }
    public function resetMaturity()
    {
        return $this->db->query('DELETE FROM fuzzy')->execute()->affectedRows();
    }
    public function calculateFuzzy($a, $b, $c)
    {
        $maturity = exec("python models/fuzzy.py " . escapeshellarg($a) . " " . escapeshellarg($b) . " " . escapeshellarg($c));
        return $this->setMaturity($maturity);
    }
}
