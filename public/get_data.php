
<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\user;

$user = new user($PDO); // khoi tao de sd cac ham
if(isset($_POST['id'])){
    
$user->find($_POST['id']);
$ten = $user->ten;
$ho  = $user->ho;
$id = $user->getId();
//echo($ten.$ho.$id);
//data_user = "";
$data_user[0] = $ten;
$data_user[1] = $ho;
$data_user[2] = $id;
echo json_encode($data_user);
}
