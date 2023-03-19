<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\user;

$user = new user($PDO); // khoi tao de sd cac ham

if (isset($_POST['id'])) {
   if($user->find($_POST['id'])){
    $user->delete();
}
}
