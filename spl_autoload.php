<?php

function model_load($classname){
    if(!class_exists($classname)){  //如果要加载的类不存在（不在内存）
        //下面是加载项目根目录的代码
        $file = $classname . '.php';
        if(file_exists($file)){
            include $file;
            echo '成功加载文件:',$file,'<br/>';
            return true;   //终止函数执行
        }
    }
}

function dorm_load($classname){
    //下面是加载项目dorm子目录的代码
    $file = 'dorm/' . $classname . '.php';
    if(file_exists($file)){
        include $file;
        echo '成功加载文件:',$file,'<br/>';
        return true;
    }
}

function teaching_load($classname){
    $file = 'teaching/' . $classname . '.php';
    if(file_exists($file)){
        include $file;
        echo '成功加载文件:',$file,'<br/>';
        return true;
    }
}

spl_autoload_register('model_load');
spl_autoload_register('dorm_load');
spl_autoload_register('teaching_load');

