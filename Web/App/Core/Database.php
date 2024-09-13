<?php
namespace App\Core;

require_once('init.php');
require_once(__DIR__ . '/../../Config/db_config.php');

class Database
{
    // Delcare Propertys of Database
    private $DB_CONNECTION;
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASSWORD;
    private $DB_PORT;
    private $DB_SOCKET;


    // Constructor Method
    public function __construct(
            $DB_CONNECTION = DB_CONNECTION,
            $DB_HOST = DB_HOST,
            $DB_NAME = DB_NAME,
            $DB_USER = DB_USER,
            $DB_PASSWORD = DB_PASSWORD,
            $DB_PORT = DB_PORT,
            $DB_SOCKET = DB_SOCKET
        ){
        $this->DB_CONNECTION = $DB_CONNECTION;
        $this->DB_HOST = $DB_HOST;
        $this->DB_NAME = $DB_NAME;
        $this->DB_USER = $DB_USER;  
        $this->DB_PASSWORD = $DB_PASSWORD;
        $this->DB_PORT = $DB_PORT;
        $this->DB_SOCKET = $DB_SOCKET;
    }
    

    // Connection Method
    public function getConnection()
    {
        // Create Data Source Name
        $dsn = $this->DB_CONNECTION . ":host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME . ";port=" . $this->DB_PORT . ";unix_socket=" . $this->DB_SOCKET . ";charset=utf8";
        // Using Method Connect \PDO
        try {
            $connection = new \PDO(
                $dsn,
                $this->DB_USER,
                $this->DB_PASSWORD
            );
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (\PDOException $e) {
            handlePDOException($e);
        } catch (\Throwable $e) {
            handleError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine()) ;
        }
        return false;
    }
}