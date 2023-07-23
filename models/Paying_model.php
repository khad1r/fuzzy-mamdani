<?php
class Paying_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getPayingMethods()
    {
        $this->db->query('SELECT * FROM metode_pembayaran');
        return $this->db->resultSet();
    }
    public function getPayingMethodById($id)
    {
        $query = 'SELECT * FROM metode_pembayaran WHERE id=:id';
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->resultSingle();
    }
    public function deletePayingMethod($id)
    {
        if ($id <= 2) throw new Exception("Metode pembayaran ini tidak boleh dihapus!!");

        $query = 'DELETE FROM metode_pembayaran WHERE id=:id';
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->affectedRows();
    }
    public function updatePayingMethod($data)
    {

        foreach ($data as &$input) $input = htmlspecialchars($input);

        if ($data['id'] <= 2) throw new Exception("Metode pembayaran ini tidak boleh diubah!!");

        if (empty($data['metode_pembayaran'])) throw new Exception("Metode Pembayaran Tidak Boleh Kosong!!");

        if (strlen($data['metode_pembayaran']) > 31) throw new Exception("Maksimal Metode Pembayaran Adalah 31 Karakter!!");

        $query = 'UPDATE metode_pembayaran SET metode_pembayaran=:metode_pembayaran, keterangan=:keterangan WHERE id=:id';
        $this->db->query($query);
        $this->db->bind('metode_pembayaran', htmlspecialchars($data['metode_pembayaran']));
        $this->db->bind('keterangan', htmlspecialchars($data['keterangan']));
        $this->db->bind('id', htmlspecialchars($data['id']));
        $this->db->execute();
        return $this->db->affectedRows();
    }
    public function insertPayingMethod($data)
    {

        foreach ($data as &$input) $input = htmlspecialchars($input);

        if (empty($data['metode_pembayaran'])) throw new Exception("Metode Pembayaran Tidak Boleh Kosong!!");

        if (strlen($data['metode_pembayaran']) > 31) throw new Exception("Maksimal Metode Pembayaran Adalah 31 Karakter!!");
        $query = 'INSERT INTO metode_pembayaran VALUE("",:metode_pembayaran,:keterangan)';
        $this->db->query($query);
        $this->db->bind('metode_pembayaran', htmlspecialchars($data['metode_pembayaran']));
        $this->db->bind('keterangan', htmlspecialchars($data['keterangan']));
        $this->db->execute();
        return $this->db->affectedRows();
    }
}
