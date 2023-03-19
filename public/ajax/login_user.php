<?php

require_once '../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}

use CT275\Labs\user;
$user= new user($PDO);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
  //  $_POST['user_email'] = 'thay1234@gmail.com';
   // $_POST['user_password'] = 'thay1234';
	if (!empty($_POST['user_email']) && !empty($_POST['user_password']) && $user->find($_POST['user_email'])) {

		if ((strtolower($_POST['user_email']) == $user->user_email) && ($_POST['user_password'] == $user->user_password)) {
			$_SESSION['user'] = 'me';
            $_SESSION['user_id'] = $user->getId();
           $error_message = false;
		} else {
			$error_message = 'Mật khẩu không chính xác!';
		}
	} else {
		$error_message = 'Tài khoản này chưa được cấp';
	}

   echo json_encode($error_message);
}