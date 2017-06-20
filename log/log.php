<?php
class Log{
    
    public static function Info($log, $level = 0){
        if ($level == 0) {
            self::toFile($log);
            self::toShow($log);
        } elseif ($level == 1) {
            self::toFile($log);
        } else {
            self::toShow($log);
        }
    }
    
    private static function toFile($log){
        $log = date('Y-m-d H:i:s')."\t\t".$log."\n";
        file_put_contents(__ROOT__ . DIRECTORY_SEPARATOR . "error.log", $log, FILE_APPEND);
    }
    
    private static function toShow($log){
        echo "$log\r\n";
    }
    
}