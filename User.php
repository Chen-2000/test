<?php
//改文件作用是实现用户类的注册、登陆等业务功能
// include 'DB.php'; 
// include 'UserException.php';
class User{
    public $name='';
    public $password;
    public $intro;
    public $db;
    public function __construct($name,$password,$intro){
        $this->setName($name);
        $this->setPassword($password);
        $this->setIntro($intro);
        $this->db = new DB();  //1.连接数据库
    }
    //修改名字
    public function setName($name){
        $this->name = $name;
    }
    //修改密码
    public function setPassword($password){
        $this->password = $password;
    }
    //修改个人介绍
    public function setIntro($intro){
        $this->intro = $intro;
    }

    public function signup(){    //注册
        try{
            //验证用户名
            $validated = $this->validateName();
            if($validated){
                //把用户数据保存到数据库，即把用户提交的数据插入到数据库
                $this->save();
            }else{
                //告诉用户名已经被使用
                $msg= '用户名'.$this->name.'已经被使用,请使用别的名字';
                echo $msg;
                // $signup_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/signup.php';
                // include('assets/util.php');
                // alert($msg,$signup_url);
            }
        }catch(DbException $e){
            //此处编写错误处理的代码
            echo $e->getMessage(),',请与网站管理员联系','<br/>';
            echo $e->getFile(),'<br/>';
            echo $e->getLine(),'<br/>';
        }catch(UserException $e){
            echo $e->getMessage(),',请检查用户名','<br/>';
            echo $e->getFile(),'<br/>';
            echo $e->getLine(),'<br/>';
        }finally{
        //无论是否发生异常，都会执行的代码，例如关闭数据库连接，退出程序
            exit;
        }
    }

    public function validateName(){ //函数名字最好是见名知意，验证用户名
        //验证用户名长度
        if(strlen($this->name)>12){
            throw new UserException('用户名太长');
        }
        if(strlen($this->name)<6){
            throw new UserException('用户名太短');
        }
        

        //验证用户名是否存在
        $sql = 'select id from users where name = "'.$this->name.'"';
        $r = $this->db->get_results($sql);
        if($r == false){
            return true; //名字可以使用
        }else{
            return false; //名字被占用
        }
    }

    //保存用户数据到数据库
    public function save(){
        $sql = 'insert into users (name,password,intro) values ("'.$this->name.'","'.$this->password.'","'.$this->intro.'")';
        $r = $this->db->exec($sql);
        if($r === 1){
            $msg='注册成功，请点击前往首页！';
            $index_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
            include('assets/util.php');
            alert($msg,$index_url);
        }else{
            $signup_url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/signup.php';
            include('assets/util.php');
            alert('注册失败，请重新注册！',$signup_url);
        }
    }

}
