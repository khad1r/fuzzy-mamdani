<?php

class Skor_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getScore()
    {
        $this->db->query('SELECT * FROM skor WHERE skor IS NOT NULL');
        return array_column($this->db->resultSet(), 'skor', 'kode');
    }
    public function setScore($data)
    {
        $total_score = $data[0];
        foreach ($total_score as $key => &$value) {
            $value = array_sum(array_column($data, $key)) / count($data);
            $this->db->query('UPDATE skor SET skor =:skor WHERE kode=:kode')
                ->bind('skor', $value)
                ->bind('kode', $key)
                ->execute()
                ->affectedRows();
        }
        return $total_score;
    }
    public function resetScore()
    {
        return $this->db->query('UPDATE skor SET skor = null')->execute()->affectedRows();
    }
}
