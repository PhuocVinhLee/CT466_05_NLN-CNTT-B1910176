<?php

require_once '../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}

use CT275\Labs\admin;
$admin= new admin($PDO);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
  //  $_POST['admin_email'] = 'thay1234@gmail.com';
   // $_POST['admin_password'] = 'thay1234';
	if (!empty($_POST['admin_email']) && !empty($_POST['admin_password']) && $admin->find($_POST['admin_email'])) {

		if ((strtolower($_POST['admin_email']) == $admin->admin_email) && ($_POST['admin_password'] == $admin->admin_password)) {
			$_SESSION['admin'] = 'me';
            $_SESSION['admin_id'] = $admin->getId();
           $error_message = false;
		} else {
			$error_message = 'Mật khẩu không chính xác!';
		}
	} else {
		$error_message = 'Tài khoản này chưa được cấp';
	}

   echo json_encode($error_message);
}