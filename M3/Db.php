<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__,'LoginDatenbank.env');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
$remoteConnection = mysqli_connect(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME'),
    (int) getenv('DB_PORT')
);

Class Db
{
    private $user;
    private $host;
    private $pass;
    private $db;
    private $port;

    public function __construct()
    {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "";
        $this->db = "db3137339";
        $this->port = (int)"3306";

    }

    public function connect()
    {
        global $remoteConnection;
        $dotenv = Dotenv\Dotenv::create(__DIR__,'LoginDatenbank.env');
        $dotenv->load();
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
        $remoteConnection = mysqli_connect(
            getenv('DB_HOST'),
            getenv('DB_USER'),
            getenv('DB_PASS'),
            getenv('DB_NAME'),
            (int) getenv('DB_PORT')
        );



        return $remoteConnection;
        /*global $link;
        $link = mysqli_connect('149.201.88.110', 's_lb8544s', 'I8BI8PY2.GS', 'db3208535', 3306);
        return $link;*/
    }
}