<?php

/**

    Class Database
    A PDO database connection class.
    PHP version 7.3.0 or higher
    @category Database
    @package Database_Connection
    @author Author
    @license http://opensource.org/licenses/gpl-license.php GNU Public License
    @link http://url.com
 */

class Database
{

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $conn;
    public $stmt;

    public function __construct($check = false)
    {
        if ($check) return $this->checkDatabase();
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $this->conn = new PDO($dsn, $this->user, $this->pass, $option);
    }
    public function query($query)
    {
        $this->stmt = $this->conn->prepare($query);
        return $this;
    }
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            if (is_int($value))
                $type = PDO::PARAM_INT;
            elseif (is_bool($value))
                $type = PDO::PARAM_BOOL;
            elseif (is_null($value))
                $type = PDO::PARAM_NULL;
            else
                $type = PDO::PARAM_STR;
        }
        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }
    public function execute()
    {
        try {
            $this->stmt->execute();
        } catch (PDOException $e) {
            if ($this->conn->inTransaction()) {
                $this->rollback();
            }
            throw $e;
        }
        return $this;
    }
    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }
    public function rollback()
    {
        $this->conn->rollback();
    }
    public function commit()
    {
        $this->conn->commit();
    }
    public function resultSet()
    {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function resultSingle()
    {
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function affectedRows()
    {
        return $this->stmt->rowCount();
    }
    private function checkDatabase()
    {

        $dsn = 'mysql:host=' . $this->host;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $pdo = new PDO($dsn, $this->user, $this->pass, $option);
        // Check if the database exists
        $stmt = $pdo->query("SHOW DATABASES LIKE '{$this->db_name}'");
        if ($stmt->rowCount() === 0) {
            return $this->importDatabase($pdo);
        }
    }
    private function importDatabase($pdo)
    {
        $result = true;
        try {
            $sqlFile = 'database/database.sql';
            $sql = file_get_contents($sqlFile);
            $pdo->exec($sql);
            $_SESSION['alert'] = array('success', 'Database Imported');
        } catch (PDOException $e) {
            $result = false;
            $_SESSION['alert'] = array('danger', "Error importing database: " . $e->getMessage());
        }
        return $result;
    }
}
