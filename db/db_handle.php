<?php
class DbHandle{
    
    static $_instance = null;
    
    private $connection = null;
    
    function __get($_name){}
    function __set($_name, $value){}
    function __call($_method, array $arguments){}
    function __clone(){}
    
    public static function getInstance(){
        if (! self::$_instance instanceof DbHandle) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
    private function __construct(){
        try {
            $this->connection = new PDO("mysql:dbname=code_jiami;host=127.0.0.1", "root", "123456");
        } catch (PDOException $e) {
            Log::Info( "数据库连接失败:".$e->getMessage());
        }
    }
    
    public function query($sql, $type = false){
        $data = array();
        $fetchAll = $this->connection->query($sql)->fetchAll(PDO::FETCH_CLASS);
        if (! $fetchAll) {
            return $data;
        }
        if (true === $type) {
            $data = get_object_vars(end($fetchAll));
        } else {
            foreach ($fetchAll as $row) {
                $data[] = empty($row) ? array() : get_object_vars($row);
            }
        }
        return $data;
    }
    
    public function execute($sql){
        return $this->connection->exec($sql);
    }
    
}