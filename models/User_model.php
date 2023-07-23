<?php

class User_model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllUser()
    {
        $query = 'SELECT * FROM user ORDER BY level_user';
        $this->db->query($query);
        return $this->db->resultSet();
    }
    public function getUser($data)
    {
        $query = "SELECT * FROM user WHERE username=:username AND password=MD5(:password)";
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        return $this->db->resultSingle();
    }
    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM user WHERE username=:username";
        $this->db->query($query);
        $this->db->bind('username', $username);
        return $this->db->resultSingle();
    }
    public function deleteUser($username)
    {
        $user = $this->getUserByUsername($username);
        if ($user['level_user'] == 'admin') throw new Exception("Admin Tidak Dapat Dihapus");
        $query = 'DELETE FROM user WHERE username=:username';
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->execute();
        return $this->db->affectedRows();
    }
    public function updateUser($data)
    {
        $error = [];
        foreach ($data as $key => $val) {
            if (empty($val)) $error[$key] = 'Input Ini Tidak Boleh Kosong!!!';
        }
        if (!empty($error)) throw new Exception("Input Belum terisi!!");
        foreach ($data as &$input) $input = htmlspecialchars($input);
        $allowedLevel = ['petugas', 'bag. teknik', 'bag. keuangan'];
        if (!in_array($data['level'], $allowedLevel)) throw new Exception("Level User Tidak Valid!!");

        if ($data['prevUsername'] != $data['username']) {
            if (
                $this->db
                ->query('SELECT username FROM user WHERE username = :username')
                ->bind('username', $data['username'])
                ->execute()->affectedRows() > 0
            ) throw new Exception("Username telah digunakan");
        }
        $password = empty($data['password']) ? $data['prevPassword'] : md5($data['password']);
        $query = 'UPDATE user SET username=:username, password=:password, name=:name, level_user=:level WHERE username=:prevUsername';
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('prevUsername', $data['prevUsername']);
        $this->db->bind('password', $password);
        $this->db->bind('name', $data['name']);
        $this->db->bind('level', $data['level']);
        $this->db->execute();
        return $this->db->affectedRows();
    }
    public function insertUser($data)
    {
        $error = [];
        foreach ($data as $key => $val) {
            if (empty($val)) $error[$key] = 'Input Ini Tidak Boleh Kosong!!!';
        }
        if (!empty($error)) throw new Exception("Input Belum terisi!!");
        foreach ($data as &$input) $input = htmlspecialchars($input);
        $allowedLevel = ['petugas', 'bag. teknik', 'bag. keuangan', 'monitor'];
        if (!in_array($data['level'], $allowedLevel)) throw new Exception("Level User Tidak Valid!!");

        if (
            $this->db
            ->query('SELECT username FROM user WHERE username = :username')
            ->bind('username', $data['username'])
            ->execute()->affectedRows() > 0
        ) throw new Exception("Username telah digunakan");

        $password = md5($data['password']);
        $query = 'INSERT INTO user VALUE(:username,:password,:name,:level)';
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $password);
        $this->db->bind('name', $data['name']);
        $this->db->bind('level', $data['level']);
        $this->db->execute();
        return $this->db->affectedRows();
    }
}
