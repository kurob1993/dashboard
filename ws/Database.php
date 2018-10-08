<?php
require 'MysqliDb.php';
require 'config.php';
/*
$ini_array = parse_ini_file("config.ini", true);
*/
define("hostname", $hostname);
define("username", $username);
define("password", $password);
define("database", $dbname);

class Database extends MysqliDb
{
    protected $database = database;
    protected $username = username;
    protected $password = password;
    protected $hostname = hostname;
    protected $port = 3306;

    public function __construct()
    {
        parent::__construct(
        $this->hostname, 
        $this->username, 
        $this->password, 
        $this->database, 
        $this->port);
    }
}