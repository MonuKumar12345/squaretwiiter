<?php
namespace DB;
class DatabaseConnection{
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';
    private const DB_DATABASENAME = 'square';
    public $oConnection;
    public function __construct(){
       $this->oConnection = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_DATABASENAME); 
    }
}
?>