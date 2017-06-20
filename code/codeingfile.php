<?php
class CodeingFile{
    
    private static $_DbHandle = null;
    
    /**
     *加密替代符，目前只有8个字符，所以加密时转换规则为十进制转换为八进制
     */
    private static $key = array(
        '0' => 'L',
        '1' => 'l',
        '2' => 'I',
        '3' => 'i',
        '4' => 'O',
        '5' => 'o',
        '6' => 'J',
        '7' => 'j',
    );
    
    /**
     *需要过滤的变量
     */
    private static $filter = array(
        '$this','$_COOKIE','$_ENV','$_FILES','$_GET','$_POST','$_REQUEST','$_SERVER','$_SESSION',
    );
    
    public function __construct(DbHandle $db){
        self::$_DbHandle = $db;
    }
    
    function __get($_name){}
    function __set($_name, $value){}
    function __call($_method, array $arguments){}
    function __clone(){}
    
    /**
     *给指定目录下的文件加密
     */
    public function codeToFile($dir){
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (($file = readdir($handle)) !== false) {
                    if ($file == "." || $file == "..") {
                        continue;
                    }
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                        $this->codeToFile($dir . DIRECTORY_SEPARATOR . $file);
                    } else {
                        $this->encrypt($dir . DIRECTORY_SEPARATOR . $file);
                    }
                }
            }
        } else {
            $this->encrypt($dir);
        }
    }
    
    /**
     *文件加密
     */
    private function encrypt($file){
        if (!file_exists($file)) {
            Log::Info("文件加密时，检测到文件不存在:'$file'");
            return false;
        }
        if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) != 'php') {
            return true;
        }
        $codestr = file_get_contents($file);
        $codestr = preg_replace_callback('/(\$+[\_\da-zA-Z]+)|(\-\>\s*([\da-zA-Z\_]+)\s*)(?![\(a-zA-Z\d\s])/', array(&$this, 'replaceCode'), $codestr);
        if ($codestr) {
            file_put_contents($file, $this->toCompress($codestr));
        }
        return true;
    }
    
    /**
     *替换规则
     */
    private function replaceCode($param){
        //过滤
        if ($this->toFilter($param[1])) {//过滤
            return $param[1]; //过滤
        }
        $old_code = $param[0];
        $code_name = '';
        if (isset($param[2])) { //类变量调用
            $code_name = str_replace(array('$', '->'), '', $param[3]);
        } else { //带$的变量
            $code_name = str_replace(array('$', '->'), '', $param[1]);
        }
        
        $sql = sprintf("select * from code_dictionary where code_name = '%s'", $code_name);
        if ($data = self::$_DbHandle->query($sql, true)) {
            return str_replace($code_name, $data['code_value'], $old_code);
        }
        $sql = "SELECT MAX(id) as id FROM `code_dictionary`";
        $index = self::$_DbHandle->query($sql, true);
        
        $index['id'] || $index['id'] = 0;
        $index['id'] ++;
        /*十进制转八进制并替换*/
        $code_value = str_pad(str_replace(array_flip(self::$key), self::$key, decoct($index['id'])), 15, 'L', STR_PAD_LEFT);
        $sql = sprintf("INSERT INTO `code_dictionary` (code_name,code_value,code_type) VALUES('%s','%s','%s')", $code_name, $code_value, 1);
        if (self::$_DbHandle->execute($sql)) {
            return str_replace($code_name, $code_value, $old_code);
        } else {
            Log::Info("插入数据失败:$sql");
            return $param[1];
        }
    }
    /**
     *压缩加密后的文件
     */
    private function toCompress($str) {
        return $str;
        //return str_replace('<?php', '<?php ', preg_replace(array('/\/\*{2}[\s\S]*?\*\//','/\/\*[\s\S]*?\*\//', '/(?<=\;|\s|\{)(\/{2}.*)/', '/\s{2}|\r\n/'), '', $str));
    }
    
    private function toFilter($key){
        if (preg_match('/^[LlIiJjOo]{15}$/', str_replace(array('$', '->'), '', $key))) {
            return $key;
        }
        return in_array($key, self::$filter) ? true : false;
    }
}