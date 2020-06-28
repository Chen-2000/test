<?php
include 'User.php'; //或者写： require 'User.php'
$u = new User('张三丰');
$u->signup();