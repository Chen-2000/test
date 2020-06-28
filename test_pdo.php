<?php
include 'spl_autoload.php';
$db = new DB();  //创建数据库类对象,连接数据库
$sql ='select * from users';

$r = $db->get_results($sql,true,PDO::FETCH_BOTH);  //从查询结果获取数据

// $sql ='select * from users where id = 30';

// $r = $db->get_results($sql,true,PDO::FETCH_BOTH);
/*没有必要再调用1该函数，没有必要不代表不会调用，依旧可以调用。

为了防止调用，应该把该函数由public改为private，以此保护代码的安全性 
*/
//$db->query($sql) 

var_dump($r);
echo '<br/>';
echo '名字是：',$r['name'];
echo '<hr/>';
echo '修改数据库表： <br/>';

$sql = 'delete from users where id = 9';
$db->exec($sql);


// $name = $_POST['name'];
// $password = $_POST['password'];
// $intro = $_POST['intro'];

$name = '小弟2';
$password = '123';
$intro = '打粑';

$user = new User($name,$password,$intro);
$user->signup();





// $sql = 'select * from users where name = "abc"';
// $statement = $pdo->query($sql);
// var_dump($statement);
// echo '<hr/>';

// //把数据取出来
// $r =$statement->fetch();
// var_dump($r);
// // echo $r['password'];



// echo '<hr/>';
// echo '测试数据库的插入语句','<br/>';
// $db = new DB();
// $db->connect();
// $sql = 'insert into users (name,password,intro) values ("萧十一郎","abc","作家")';
// $db->exec($sql);

