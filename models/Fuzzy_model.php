<?php

class Fuzzy_model
{
    // private $db;

    // public function __construct()
    // {
    //     $this->db = new Database;
    // }
    // public function getHasil()
    // {
    //     $this->db->query('SELECT hasil FROM fuzzy');
    //     return $this->db->resultSet();
    // }
    // public function setHasil($data)
    // {
    //     $this->db->query('INSERT INTO fuzzy VALUE (:hasil)')
    //         ->bind('hasil', $data)
    //         ->execute()
    //         ->affectedRows();
    //     return $data;
    // }
    // public function resetHasil()
    // {
    //     return $this->db->query('DELETE FROM fuzzy')->execute()->affectedRows();
    // }
    public function calculateFuzzy($a, $b, $c)
    {
        $hasil = exec("python models/fuzzy.py " . escapeshellarg($a) . " " . escapeshellarg($b) . " " . escapeshellarg($c));
        return explode(" ", $hasil);;
    }
}
