<?php
// include 'DbException.php';
//该类代表数据库，负责对数据库进行操作
class DB{

    public $pdo;
    public $statement;
    public function __construct(){  //连接数据库方法
        // $dbconnection = @mysqli_connect('localhost','root','root','testwebtwo');
        $driver_options = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try{
            $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=testwebtwo','root','root',$driver_options);
        }catch(PDOException $p){
            echo '数据库连接出错，错误原因是:' , $p->getMessage();
            exit;
        }
        // if(mysqli_connect_errno() != 0){
        //     throw new DbException('连接数据库出错');
        // }
        echo '数据库连接成功','<br/>';
    }

    //发送查询语句给数据库
    private function query($sql){
        //这种处理错误的办法在PDO的错误处理方法是PDO::ERRMODE_EXCEPTION情况下可行
        try{
            $this->statement = $this->pdo->query($sql);
        }catch(PDOException $e){
            echo '查询出错，错误原因是:',$this->pdo->errorInfo()[2],'<br/>';  
            echo '查询出错，错误代号是:',$this->pdo->errorCode(),'<br/>'; 
            exit;
        }


        //这种处理错误的办法在PDO的错误处理方法是PDO::ERRMODE_SILENT情况下可行
        // $this->statement = $this->pdo->query($sql);
        // if($this->statement == false){
        //     echo '查询出错，错误原因是:',$this->pdo->errorInfo()[2],'<br/>';  
        //     echo '查询出错，错误代号是:',$this->pdo->errorCode(),'<br/>'; 
        //     exit; 
        // }
    }

    //方法二：创建一个方法
    /*
        $only参数是一个标记，决定着返回的数据是一条还是多条
     */
    public function get_results($sql,$only = true,$fetch_style = PDO::FETCH_ASSOC){
        $this->query($sql);
        if($only){
            //从数据库执行结果获取一条数据
            return $this->statement->fetch($fetch_style);
        }else{
            //从数据库执行结果获取所有数据
            return $this->statement->fetchAll($fetch_style);
        }
    }


    //对数据库进行增、删、改操作的函数
    public function exec($sql){
        //这种处理错误的办法在PDO的错误处理方法是PDO::ERRMODE_EXCEPTION情况下可行
        try{
            $r = $this->pdo->exec($sql);
        }catch(PDOException $P){
            echo '错误编码是: ' . $this->pdo->errorCode(),'<br/>';
            echo '错误原因是: ' . $this->pdo->errorInfo()[2],'<br/>';
            exit;
        }
        // echo '操作成功！','<br/>';
        // echo '受影响的行数是: '. $r . '行','<br/>';
        return $r;
        //这种处理错误的办法在PDO的错误处理方法是PDO::ERRMODE_SILENT情况下可行
        // $r = $this->pdo->exec($sql);
        // if($r === false){
        //     echo '错误编码是: ' . $this->pdo->errorCode(),'<br/>';
        //     echo '错误原因是: ' . $this->pdo->errorInfo()[2],'<br/>';
        // }else{
        //     echo '操作成功！','<br/>';
        //     echo '受影响的行数是: '. $r . '行','<br/>';
        // }
    }
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

}
