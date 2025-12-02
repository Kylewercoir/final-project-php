<?php
require 'includes/config.php'; // include your config.php with DB constants

class Database {
    private static $instance = null;
    private $pdo;

    // Constructor
    private function __construct() {
    global $host, $dbname, $username, $password; // use variables from config.php
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $this->pdo = new PDO($dsn, $username, $password, $options);
}

    // Singleton: get instance
    public static function getInstance() {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get PDO connection
    public function getConnection() {
        return $this->pdo;
    }
}
