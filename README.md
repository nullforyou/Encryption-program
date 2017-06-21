# Encryption-program
php写的一个简单的加密代码的程序


##加密规则

  用特定字符代替原有字符，具体规则为数据库记录下字符串并给一个自动增量值，如变量$abc，会把abc存入数据库，自增量为1，按照十进制转八进制的规则转换成15位长度的数，并按键值获取对应字符；如000000000000001转换后为LLLLLLLLLLLLLLl;以极低可读性达到类似加密效果。

>可替换字符如下:
    	
    '0' ='L',
    '1' ='l',
    '2' ='I',
    '3' ='i',
    '4' ='O',
    '5' ='o',
    '6' ='J',
    '7' ='j',




###需要过滤的变量

目前不需要加密的变量有$this,$_COOKIE,$_ENV,$_FILES,$_GET,$_POST,$_REQUEST,$_SERVER,$_SESSION


##加密代码片段示例

      public function getDataList($model, $where, $order = "id desc", $page = 0, $listRows = 0, $fields = "", $templateName = 'list', $fnName = 'dataList'){
          if (empty($listRows)) {
                  $listRows = $this->rows;
              }
          if (empty($page)) {
            $page = empty($_REQUEST['p']) ? 0 : $_REQUEST['p'];
          }
          $return = array();
          $tempObj = $model->where($where)->order($order);
          if ($fields) {
            $tempObj = $model->field($fields);
          }
              $list = $tempObj->where($where)->page($page, $listRows)->select();

          $count = $model->where($where)->count();
          if (method_exists($this, "_after_".$fnName)) {
                  $fnName = "_after_".$fnName;
            $this->$fnName($list);
          }
              return ['list'=>$list, 'count'=>$count];
        }

混淆后

        public function getDataList($LLLLLLLLLLLLLOi, $LLLLLLLLLLLLlLo, $LLLLLLLLLLLLlLJ = "id desc", $LLLLLLLLLLLLlLj = 0, $LLLLLLLLLLLLllL = 0, $LLLLLLLLLLLLlll = "", $LLLLLLLLLLLLllI = 'list', $LLLLLLLLLLLLlli = 'dataList'){
            if (empty($LLLLLLLLLLLLllL)) {
                    $LLLLLLLLLLLLllL = $this->LLLLLLLLLLLLLJo;
                }
            if (empty($LLLLLLLLLLLLlLj)) {
              $LLLLLLLLLLLLlLj = empty($_REQUEST['p']) ? 0 : $_REQUEST['p'];
            }
            $LLLLLLLLLLLLllO = array();
            $LLLLLLLLLLLLllo = $LLLLLLLLLLLLLOi->where($LLLLLLLLLLLLlLo)->order($LLLLLLLLLLLLlLJ);
            if ($LLLLLLLLLLLLlll) {
              $LLLLLLLLLLLLllo = $LLLLLLLLLLLLLOi->field($LLLLLLLLLLLLlll);
            }
                $LLLLLLLLLLLLLOI = $LLLLLLLLLLLLllo->where($LLLLLLLLLLLLlLo)->page($LLLLLLLLLLLLlLj, $LLLLLLLLLLLLllL)->select();

            $LLLLLLLLLLLLllJ = $LLLLLLLLLLLLLOi->where($LLLLLLLLLLLLlLo)->count();
            if (method_exists($this, "_after_".$LLLLLLLLLLLLlli)) {
                    $LLLLLLLLLLLLlli = "_after_".$LLLLLLLLLLLLlli;
              $this->$LLLLLLLLLLLLlli($LLLLLLLLLLLLLOI);
            }
                return ['list'=>$LLLLLLLLLLLLLOI, 'count'=>$LLLLLLLLLLLLllJ];
          }
