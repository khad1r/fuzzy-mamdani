<?php


class Transaction_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getAllTransactions()
    {
        // $this->db->query("SELECT * FROM v_transaksi");
        $this->db->query(Database::QUERY_TRANSACTION);
        return $this->db->resultSet();
    }
    public function getTransactionsByMonth($month)
    {
        // $query = "SELECT * FROM user WHERE username=:username AND password=MD5(:password)";
        $query = Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m') = :month";
        $this->db->query($query);
        $this->db->bind('month', $month);
        return $this->db->resultSet();
    }
    public function getTransactionsById($id)
    {
        // $query = "SELECT * FROM user WHERE username=:username AND password=MD5(:password)";
        $query = Database::QUERY_TRANSACTION . " WHERE `transaksi`.`id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->resultSingle();
    }
    public function getTransactionsByDate($date)
    {
        $query = Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m-%d') = :date";
        $this->db->query($query);
        $this->db->bind('date', $date);
        return $this->db->resultSet();
    }
    public function getTransactionsByDateFuelAndInstance($date, $instance, $fuel)
    {

        $query = Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m-%d') = :date AND id_instansi = :id_instansi AND jenis_bbm=:jenis_bbm";
        $this->db->query($query);
        $this->db->bind('date', $date);
        $this->db->bind('id_instansi', $instance);
        $this->db->bind('jenis_bbm', $fuel);
        return $this->db->resultSet();
    }
    public function getTransactionsByDateAndInstance($date, $instance)
    {

        $query = Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m-%d') = :date AND id_instansi = :id_instansi";
        $this->db->query($query);
        $this->db->bind('date', $date);
        $this->db->bind('id_instansi', $instance);
        return $this->db->resultSet();
    }
    public function getTransactionsByDateAndPaying($date, $paying)
    {
        if ($paying == 'deleted') {
            return $this->db->query(Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m-%d') = :date AND metode_pembayaran.metode_pembayaran is null")
                // return $this->db->query("SELECT * FROM v_transaksi WHERE DATE_FORMAT(timestamp, '%Y-%m-%d') = :date AND metode_pembayaran is null")
                ->bind('date', $date)
                ->resultSet();
        }
        $query = Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m-%d') = :date AND `metode_pembayaran`.`id` = :id_metode_pembayaran";
        $this->db->query($query);
        $this->db->bind('date', $date);
        $this->db->bind('id_metode_pembayaran', $paying);
        return $this->db->resultSet();
    }
    public function getTransactionsByMonthAndInstance($data)
    {
        if ($data['id_instansi'] == 'deleted') {
            return $this->db->query(Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m') = :month AND instansi.nama_instansi is null")
                // return $this->db->query("SELECT * FROM v_transaksi WHERE DATE_FORMAT(timestamp, '%Y-%m') = :month AND instansi is null")
                ->bind('month', $data['month'])
                ->resultSet();
        }
        $query = Database::QUERY_TRANSACTION . " WHERE DATE_FORMAT(timestamp, '%Y-%m') = :month AND id_instansi = :id_instansi";
        $this->db->query($query);
        $this->db->bind('month', $data['month']);
        $this->db->bind('id_instansi', $data['id_instansi']);
        return $this->db->resultSet();
    }
    public function getRecapByMonthAndInstance($data)
    {
        $dateTime = new DateTime($data['month']);

        $this->db->query('CALL `rekap_harian`(:month,:instansi)')
            ->bind('month', $data['month'])
            ->bind('instansi', $data['instansi']);
        $rekap = [];
        foreach ($this->db->resultSet() as $result) {
            $rekap[$result['jenis_bbm']][] = $result;
        }
        return $rekap;
    }
    public function insertTransaction($data)
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

        $data['total'] = intval($data['total']);

        $instance = $this->db->query("SELECT * FROM instansi")->resultSet();
        if (!in_array($data['id_instansi'], array_column($instance, 'id_instansi'))) $error['instansi'] = 'Ada Kesalahan Pada Input Instansi';

        $fuel = $this->db->query("SELECT * FROM `v_bahan_bakar` WHERE `jenis_bbm` =:jenis_bbm")->bind('jenis_bbm', $data['jenis_bbm'])->resultSingle();

        if (empty($fuel)) $error['jenis_bbm'] = 'Ada Kesalahan Pada Input Jenis Bahan Bakar';

        if (!empty($fuel)) {
            $data['harga'] = $fuel['harga'];
            $data['qty'] = $data['total'] / $data['harga'];
        }

        $notaTransaction = $this->db->query("SELECT `jenis_bbm` FROM transaksi WHERE nota = :nota and `jenis_bbm` =:jenis_bbm")
            ->bind('nota', $data['nota'])
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->resultSingle();

        if (!empty($notaTransaction)) $error['nota'] = "Nomor Nota {$data['nota']} Double Pada Transaksi {$data['jenis_bbm']}";


        if (isset($data['timestamp'])) {
            $timestamp = $data['timestamp'];
        } elseif (isset($data['time'])) {
            $timestamp = date('Y-m-d');
            $timestamp .= ' ' . $data['time'];
        } else {
            $timestamp = date('Y-m-d h:m:s');
        }

        if ($data['total'] <= 0) $error['total'] = 'Ada Kesalahan Pada Total Pembayaran <br> Total Tidak Dapat Kurang Dari 0';

        if ($data['id_instansi'] == 0 && $data['metode_pembayaran'] == '2') $error['metode_pembayaran'] = $instance[0]['nama_instansi'] . ' Tidak Dapat Menggunakan Kupon';

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }
        if (preg_match("/([a-zA-Z]{1,10})([ ]?[0-9]{1,10})([ ]?[a-zA-Z]{1,10})/", $data['plat_nomor'], $matches)) {
            $data['plat_nomor'] = strtoupper($matches[1] . " " . $matches[2] . " " . $matches[3]);
        }

        if ($data['id_instansi'] != 0) $data['metode_pembayaran'] = '2';

        $this->db->query('INSERT INTO transaksi 
                            VALUE("",
                                :timestamp,
                                :instansi,
                                :plat_nomor,
                                :nota,
                                :jenis_bbm,
                                :total,
                                :metode_pembayaran,
                                :keterangan,
                                :petugas)')
            ->bind('timestamp', $timestamp)
            ->bind('instansi', $data['id_instansi'])
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->bind('plat_nomor', $data['plat_nomor'])
            ->bind('nota', $data['nota'])
            ->bind('total', $data['total'])
            ->bind('metode_pembayaran', $data['metode_pembayaran'])
            ->bind('keterangan', $data['keterangan'])
            ->bind('petugas', $_SESSION['user']['username'])
            ->execute();
        return $this->db->affectedRows();
    }
    public function updateTransaction($data)
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

        $prevData = $this->getTransactionsById($data['id']);

        if (empty($prevData)) throw new Exception("Data Transaksi Tidak Ada!!");

        $data['total'] = intval($data['total']);
        $data['harga'] = intval($data['harga']);
        $prevData['qty'] = floatval($prevData['qty']);

        $instance = $this->db->query("SELECT * FROM instansi")->resultSet();
        if (!in_array($data['id_instansi'], array_column($instance, 'id_instansi'))) $error['instansi'] = 'Ada Kesalahan Pada Input Instansi';

        $fuel = $this->db->query("SELECT * FROM `v_bahan_bakar` WHERE `jenis_bbm` =:jenis_bbm")->bind('jenis_bbm', $data['jenis_bbm'])->resultSingle();

        if (empty($fuel)) $error['jenis_bbm'] = 'Ada Kesalahan Pada Input Jenis Bahan Bakar';

        if (!empty($fuel)) {
            $data['harga'] = $fuel['harga'];
            $data['qty'] = $data['total'] / $data['harga'];
        }

        $notaTransaction = $this->db->query("SELECT `jenis_bbm` FROM transaksi WHERE nota = :nota and `jenis_bbm` =:jenis_bbm AND id <> :id")
            ->bind('nota', $data['nota'])
            ->bind('id', $data['id'])
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->resultSingle();

        if (!empty($notaTransaction)) $error['nota'] = "Nomor Nota {$data['nota']} Double Pada Transaksi {$data['jenis_bbm']}";

        if (isset($data['timestamp'])) {
            $timestamp = $data['timestamp'];
        } elseif (isset($data['time'])) {
            $timestamp = date('Y-m-d');
            $timestamp .= ' ' . $data['time'];
        } else {
            $timestamp = date('Y-m-d h:m:s');
        }

        if ($data['total'] <= 0) $error['total'] = 'Ada Kesalahan Pada Total Pembayaran <br> Total Tidak Dapat Kurang Dari 0';

        if ($data['id_instansi'] == 0 && $data['metode_pembayaran'] == '2') $error['metode_pembayaran'] = $instance[0]['nama_instansi'] . ' Tidak Dapat Menggunakan Kupon';

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }
        if (preg_match("/([a-zA-Z]{1,10})([ ]?[0-9]{1,10})([ ]?[a-zA-Z]{1,10})/", $data['plat_nomor'], $matches)) {
            $data['plat_nomor'] = strtoupper($matches[1] . " " . $matches[2] . " " . $matches[3]);
        }

        if ($data['id_instansi'] != 0) $data['metode_pembayaran'] = '2';

        $query = "UPDATE transaksi SET 
                    timestamp=:timestamp, 
                    instansi=:instansi,
                    plat_nomor=:plat_nomor,
                    nota=:nota,
                    jenis_bbm=:jenis_bbm,
                    total=:total,
                    metode_pembayaran=:metode_pembayaran,
                    keterangan=:keterangan 
                WHERE id=:id";
        $this->db->query($query)
            ->bind('timestamp', $timestamp)
            ->bind('instansi', $data['id_instansi'])
            ->bind('plat_nomor', $data['plat_nomor'])
            ->bind('nota', $data['nota'])
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->bind('total', $data['total'])
            ->bind('metode_pembayaran', $data['metode_pembayaran'])
            ->bind('keterangan', $data['keterangan'])
            ->bind('id', $data['id'])
            ->execute();
        return $this->db->affectedRows();
    }
}
