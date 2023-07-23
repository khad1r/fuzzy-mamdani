<?php
class Instance_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getInstances()
    {
        $this->db->query('SELECT * FROM instansi');
        return $this->db->resultSet();
    }
    public function deleteInstance($id)
    {
        if ($id == 0) throw new Exception("Instansi ini tidak boleh dihapus!!");

        $query = 'DELETE FROM instansi WHERE id_instansi=:id_instansi';
        $this->db->query($query);
        $this->db->bind('id_instansi', $id);
        $this->db->execute();
        return $this->db->affectedRows();
    }
    public function getInstancesById($id)
    {
        $query = 'SELECT * FROM instansi WHERE id_instansi=:id_instansi';
        $this->db->query($query);
        $this->db->bind('id_instansi', $id);
        return $this->db->resultSingle();
    }

    public function updateInstance($data)
    {
        foreach ($data as &$input) $input = htmlspecialchars($input);

        if ($data['id_instansi'] == 0) throw new Exception("Instansi ini tidak boleh diubah!!");
        if (empty($data['nama_instansi'])) throw new Exception("Nama Instansi Tidak Boleh Kosong!!");
        if (
            $this->db
            ->query('SELECT nama_instansi FROM instansi WHERE nama_instansi = :nama_instansi AND id_instansi != :id_instansi')
            ->bind('nama_instansi', $data['nama_instansi'])
            ->bind('id_instansi', $data['id_instansi'])
            ->execute()->affectedRows() > 0
        ) throw new Exception("Tidak Dapat Menggunakan Nama Instansi Yang Sudah Ada");
        if (strlen($data['nama_instansi']) > 31) throw new Exception("Maksimal Nama Instansi Adalah 31 Karakter!!");

        $query = 'UPDATE instansi SET nama_instansi=:nama_instansi, keterangan=:keterangan WHERE id_instansi=:id_instansi';
        $this->db->query($query);
        $this->db->bind('nama_instansi', $data['nama_instansi']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('id_instansi', $data['id_instansi']);
        $this->db->execute();
        return $this->db->affectedRows();
    }
    public function insertInstance($data)
    {
        foreach ($data as &$input) $input = htmlspecialchars($input);

        if (empty($data['nama_instansi'])) throw new Exception("Nama Instansi Tidak Boleh Kosong!!");

        if (
            $this->db
            ->query('SELECT nama_instansi FROM instansi WHERE nama_instansi = :nama_instansi')
            ->bind('nama_instansi', $data['nama_instansi'])
            ->execute()->affectedRows() > 0
        ) throw new Exception("Tidak Dapat Menggunakan Nama Instansi Yang Sudah Ada");

        if (strlen($data['nama_instansi']) > 31) throw new Exception("Maksimal Nama Instansi Adalah 31 Karakter!!");
        $query = 'INSERT INTO instansi VALUE("",:nama_instansi,:keterangan)';
        $this->db->query($query);
        $this->db->bind('nama_instansi', $data['nama_instansi']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->execute();
        return $this->db->affectedRows();
    }
}
