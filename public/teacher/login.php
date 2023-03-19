<?php

require_once '../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['admin_email']) && !empty($_POST['admin_password']) && $admin->find($_POST['admin_email'])) {

		if ((strtolower($_POST['admin_email']) == $admin->admin_email) && ($_POST['admin_password'] == $admin->admin_password)) {
			$_SESSION['admin'] = 'me';
            $_SESSION['admin_id'] = $admin->getId();

		} else {
			$error_message = 'Địa chỉ email or mật khẩu không khớp!';
           // echo($error_message);
		}
	} else {
		$error_message = 'Tài khoản chưa được cấp';
        //echo($error_message);
	}
}