<?php
class Fuel_model
{

    private $db;
    private $fuels;

    public function __construct()
    {
        $this->db = new Database;
        $this->db->query('SELECT * FROM v_bahan_bakar ORDER BY jenis_bbm DESC');
        $this->fuels = $this->db->resultSet();
    }
    public function getfuels()
    {
        return $this->fuels;
    }
    public function refresh()
    {
        $this->db->query('CALL `refresh_rekap_stok`()')->execute();
    }
    public function getFormatedfuels()
    {
        $fuels = [];
        foreach ($this->fuels as $fuel) {
            $fuels[$fuel['jenis_bbm']] = [
                'jenis_bbm' => $fuel['jenis_bbm'],
                'in_use_id' => $fuel['in_use_id'],
                'in_use_stok' => $fuel['in_use_stok'],
                'harga' => $fuel['harga'],
                'stok' => floatval($fuel['stok']),
            ];
        };
        return $fuels;
    }
    public function getStickfuels()
    {
        $fuels = $this->getFormatedfuels();
        foreach ($fuels as $fuel) {
            $fuels[$fuel['jenis_bbm']]['stick'] = $this->db->query('SELECT * FROM pengukuran_stok WHERE jenis_bbm=:jenis_bbm ORDER BY timestamp DESC LIMIT 1')
                ->bind('jenis_bbm', $fuel['jenis_bbm'])
                ->resultSingle();
        }
        return $fuels;
    }
    public function getFullDescfuels()
    {
        $fuels = $this->getFormatedfuels();
        foreach ($fuels as $key => $fuel) {
            // $lastUpdateStok = $this->db->query('SELECT waktu_pembelian FROM stok WHERE status="pending" AND jenis_bbm=:jenis_bbm ORDER BY waktu_pembelian DESC LIMIT 1')
            $lastUpdateStok = $this->db->query('SELECT waktu_pembelian FROM stok WHERE jenis_bbm=:jenis_bbm ORDER BY waktu_pembelian DESC LIMIT 1')
                ->bind('jenis_bbm', $key)
                ->resultSingle();
            $fuels[$key]['lastUpdateStok'] = $lastUpdateStok;
        }
        return $fuels;
    }
    public function getStockByMonth($month)
    {
        return $this->db->query(Database::QUERY_STOCK . " WHERE DATE_FORMAT(`s`.`waktu_pembelian`, '%Y-%m') = :month")
            ->bind('month', $month)
            ->resultSet();
    }
    public function getSalesByMonth($month)
    {
        return $this->db->query(Database::QUERY_SALES)
            ->bind('month', $month)
            ->resultSet();
    }
    public function getStickByMonth($month)
    {
        return $this->db->query("SELECT * FROM pengukuran_stok WHERE DATE_FORMAT(timestamp, '%Y-%m') = :month ORDER BY jenis_bbm DESC,timestamp DESC")
            ->bind('month', $month)
            ->resultSet();
    }
    public function getStickRecapByMonth($month)
    {
        $dateTime = new DateTime($month);
        $firstDay = $dateTime->format("Y-m-01");
        $lastDay = min($dateTime->format("Y-m-t"), date("Y-m-d"));
        return $this->db->query(Database::WITH_DATES .
            " SELECT 
                DATE_FORMAT(`dates`.`dt`, '%d/%m') AS `tgl`,
                `b`.`jenis_bbm` AS `jenis_bbm`,
                `t`.`liter` 
            FROM dates 
            JOIN `v_bahan_bakar` `b` ON(1 = 1)
            LEFT JOIN `pengukuran_stok` `t` 
            ON CAST(`t`.`timestamp` AS DATE) = `dates`.`dt`
            AND `t`.`jenis_bbm` = `b`.`jenis_bbm`  
            ORDER BY `b`.`jenis_bbm` DESC,`dates`.`dt`")
            ->bind('firstDay', $firstDay)
            ->bind('lastDay', $lastDay)
            ->bind('month', $month)
            ->resultSet();
    }
    public function getFuelRecapByMonth($month)
    {
        return $this->db->query("SELECT * FROM rekap_stok_harian WHERE DATE_FORMAT(tgl, '%Y-%m') = :month ORDER BY jenis_bbm DESC,tgl DESC")
            ->bind('month', $month)
            ->resultSet();
    }
    public function getFormatedRecapByMonth($month)
    {
        $dateTime = new DateTime($month);
        $firstDay = $dateTime->format("Y-m-01");
        $lastDay = min($dateTime->format("Y-m-t"), date("Y-m-d"));
        return $this->db->query(Database::WITH_DATES .
            " SELECT  
                DATE_FORMAT(`dates`.`dt`, '%d/%m') AS `tgl`,
                `b`.`jenis_bbm` AS `jenis_bbm`,
                coalesce(`t`.`qty_jual`,0) AS `qty_jual`,
                `t`.`stok`
            FROM dates 
            JOIN `v_bahan_bakar` `b` ON(1 = 1)
            LEFT JOIN `rekap_stok_harian` `t` 
                ON DATE(`t`.`tgl`) = `dates`.`dt`
                AND `t`.`jenis_bbm` = `b`.`jenis_bbm`  
            ORDER BY `b`.`jenis_bbm` DESC,`dates`.`dt`")
            ->bind('firstDay', $firstDay)
            ->bind('lastDay', $lastDay)
            ->bind('month', $month)
            ->resultSet();
    }

    public function getFuelByTimestamp($data)
    {
        return $this->db->query(<<<SQL
                SELECT 
                    `a`.*
                FROM `harga_bbm_history` `a`
                INNER JOIN (
                    SELECT `jenis_bbm`, MAX(`tgl`) AS `latest_timestamp`
                    FROM `rekap_stok_harian`
                    WHERE `tgl` <= :timestamp
                    GROUP BY `jenis_bbm`
                ) `b` ON `a`.`jenis_bbm` = `b`.`jenis_bbm` AND `a`.`waktu_diterapkan` = `b`.`latest_timestamp`    
            SQL)->bind('timestamp', $data['timestamp'])
            ->resultSet();
    }
    public function getPrices()
    {
        return $this->db->query("SELECT * FROM harga_bbm_history")->resultSet();
    }
    public function getPricesByMonth($month)
    {
        return $this->db->query("SELECT * FROM harga_bbm_history WHERE DATE_FORMAT(waktu_diterapkan, '%Y-%m') = :month ORDER BY jenis_bbm DESC,waktu_diterapkan")
            ->bind('month', $month)
            ->resultSet();
    }
    public function insertPriceFuel($data)
    {
        $error = [];

        foreach ($data as $key => $val) {
            if (empty($val)) $error[$key] = 'Input Ini Tidak Boleh Kosong!!!';
        }
        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Input Belum terisi!!");
        }

        foreach ($data as &$input) $input = htmlspecialchars($input);

        $data['harga'] = intval($data['harga']);

        if ($data['harga'] <= 0) throw new Exception("Format Harga Salah!!");

        if (!in_array($data['jenis_bbm'], FUELTYPE))  $error['jenis_bbm'] = 'Jenis BBM Tidak Sesuai Dengan Sistem';

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }

        $this->db->query("INSERT INTO harga_bbm_history VALUES (null,:jenis_bbm,:harga,:waktu_diterapkan)")
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->bind('harga', $data['harga'])
            ->bind('waktu_diterapkan', $data['waktu_diterapkan'])
            ->execute();
        return $this->db->affectedRows();
    }
    public function deletePriceFuel($id)
    {

        $id = htmlspecialchars(urldecode($id));
        return $this->db->query("DELETE FROM harga_bbm_history WHERE id =:id")->bind('id', $id)->execute()->affectedRows();
    }
    public function deleteStik($id)
    {

        $id = htmlspecialchars(urldecode($id));
        return $this->db->query("DELETE FROM pengukuran_stok WHERE id =:id")->bind('id', $id)->execute()->affectedRows();
    }
    public function updateStok($data)
    {
        $error = [];

        foreach ($data as $key => $val) {
            if ($key == 'keterangan') continue;
            if (empty($val)) $error[$key] = 'Input Ini Tidak Boleh Kosong!!!';
        }
        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Input Belum terisi!!");
        }

        foreach ($data as &$input) $input = htmlspecialchars($input);

        $data['harga'] = intval($data['harga']);

        if ($data['harga'] <= 0) throw new Exception("Format Harga Salah!!");

        if (!in_array($data['jenis_bbm'], FUELTYPE))  $error['jenis_bbm'] = 'Jenis BBM Tidak Sesuai Dengan Sistem';

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }

        $id = substr($data['jenis_bbm'], 0, 3) . '-' . date('ymd', strtotime($data['timestamp']));

        $stok = $this->db->query("SELECT * FROM stok WHERE id_stok =:id_stok")->bind('id_stok', $id)->resultSingle();
        if (!empty($stok)) throw new Exception("Id Stok Double Dikarenakan Adanya Pembelian Stok Di hari Yang Sama");

        $this->db->query("INSERT INTO stok VALUES (:id,:jenis_bbm,:timestamp,:harga,:pembelian,:keterangan)")
            ->bind('id', $id)
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->bind('timestamp', $data['timestamp'])
            ->bind('harga', $data['harga'])
            ->bind('keterangan', $data['keterangan'])
            ->bind('pembelian', $data['stok'])
            ->execute();
        return $this->db->affectedRows();
    }
    public function deleteStok($id)
    {
        $id = htmlspecialchars(urldecode($id));
        return $this->db->query("DELETE FROM stok WHERE id_stok =:id_stok")->bind('id_stok', $id)->execute()->affectedRows();
    }
    public function recordStick($data)
    {
        $error = [];

        foreach ($data as $key => $val) {
            if ($key == 'cm' && $val == '0') continue;
            if ($key == 'keterangan') continue;
            if (empty($val)) $error[$key] = 'Input Ini Tidak Boleh Kosong!!!';
        }
        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Input Belum terisi!!");
        }

        foreach ($data as &$input) $input = htmlspecialchars($input);

        $data['cm'] = floatval($data['cm']);
        if ($data['cm'] > 160 || $data['cm'] < 0)  $error['cm'] = 'Pengukuran Dalam Rentang 0 cm s/d 160 cm';

        if (!in_array($data['jenis_bbm'], FUELTYPE))  $error['jenis_bbm'] = 'Jenis BBM Tidak Sesuai Dengan Sistem';

        if (!empty($error)) {
            $_SESSION['InputError'] = $error;
            throw new Exception("Error Data!!");
        }
        $tableConversion = [
            0,
            21, 42, 63, 84, 105, 125, 146, 167, 188, 209, 230, 251, 272, 293, 314, 335, 356, 376, 397,
            418, 439, 460, 481, 502, 523, 544, 565, 586, 607, 627, 648, 669, 690, 711, 732, 753, 774, 795,
            816, 837, 858, 878, 899, 920, 941, 962, 983, 1004, 1025, 1046, 1067, 1088, 1109, 1129, 1150, 1171,
            1192, 1213, 1234, 1255, 1276, 1297, 1318, 1339, 1360, 1380, 1401, 1422, 1443, 1464, 1485, 1506, 1527,
            1548, 1569, 1590, 1610, 1631, 1652, 1673, 1694, 1715, 1736, 1757, 1778, 1799, 1820, 1841, 1861, 1882,
            1903, 1924, 1945, 1966, 1987, 2008, 2029, 2050, 2071, 2092, 2112, 2133, 2154, 2175, 2196, 2217, 2238,
            2259, 2280, 2301, 2322, 2343, 2363, 2384, 2405, 2426, 2447, 2468, 2489, 2510, 2531, 2552, 2573, 2594,
            2614, 2635, 2656, 2677, 2698, 2719, 2740, 2761, 2782, 2803, 2824, 2845, 2865, 2886, 2907, 2928, 2949,
            2970, 2991, 3012, 3033, 3054, 3075, 3096, 3116, 3137, 3158, 3179, 3200, 3221, 3242, 3263, 3284, 3305,
            3326, 3346
        ];
        $decimalValue = intval($data['cm']);
        $data['stok'] =
            ($data['cm'] == 160) ?
            $tableConversion[$decimalValue] :
            $tableConversion[$decimalValue] +
            (
                (($tableConversion[$decimalValue + 1] - $tableConversion[$decimalValue]) / 10) *
                (number_format(($data['cm'] - $decimalValue), 2) * 10)
            );
        $this->db->query("INSERT INTO pengukuran_stok VALUES ('',:jenis_bbm,:timestamp,:tinggi_cm,:liter,:keterangan,null,:petugas)")
            ->bind('jenis_bbm', $data['jenis_bbm'])
            ->bind('timestamp', $data['timestamp'])
            ->bind('tinggi_cm', $data['cm'])
            ->bind('liter', $data['stok'])
            ->bind('keterangan', $data['keterangan'])
            ->bind('petugas', $_SESSION['user']['username'])
            ->execute();
        return $this->db->affectedRows();
    }
    public function getFuelMutationByMonth($data)
    {
        $recap = $this->db->query("CALL `stock_card`(:month)")
            ->bind('month', $data['month'] ?? '')
            ->resultSet();
        $recap = array_reduce($recap, function ($types, $row) {
            $types[$row['jenis_bbm']][] = $row;
            return $types;
        }, array());

        $mutations = [];

        foreach ($this->fuels as $fuel) {

            $opname = (!isset($data['month']))
                ? $this->db->query("SELECT * FROM pengukuran_stok WHERE jenis_bbm = :jenis_bbm")
                ->bind('jenis_bbm', $fuel['jenis_bbm'])
                ->resultSet()
                : $this->db->query("SELECT * FROM pengukuran_stok WHERE jenis_bbm = :jenis_bbm AND DATE_FORMAT(timestamp, '%Y-%m') = :month")
                ->bind('jenis_bbm', $fuel['jenis_bbm'])
                ->bind('month', $data['month'])
                ->resultSet();
            array_push($mutations, [
                'month' =>  $data['month'] ?? '0000-00',
                'jenis_bbm' =>  $fuel['jenis_bbm'],
                'rekap' => $recap[$fuel['jenis_bbm']],
                'opname' => $opname
            ]);
        };
        return $mutations;
    }
}
