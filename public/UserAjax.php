<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\user;

$user = new user($PDO); // khoi tao de sd cac ham
// them submit
if (isset($_POST['ten']) && isset($_POST['submit'])) {
    $user->fill($_POST);
    $user->save_user();
}
// sua
if (isset($_POST['ten']) && isset($_POST['edit_User']) && $user->find($_POST['id'])) {
    $user->fill($_POST);
    echo($user->getId());
    if($user->edit_user()){
      echo("oke roi");
    }
    echo("oke");
}
//xoa
if (isset($_POST['id']) && isset($_POST['form_delete_User']) ) {
    if($user->find($_POST['id'])){
     $user->delete();
 }
 }