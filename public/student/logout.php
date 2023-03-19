<?php include('../../partials/header_user.php');
include('../../partials/nav_student.php');
//unset($_SESSION['user']);
include('../../partials/check_user.php');
require_once '../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
if (1) {
    unset($_SESSION['user']);
    unset($_SESSION['user_id']);
    echo '
	<aside style="width: 100%;" class="p-3 mt-5">
	<h2 class="text-center text-success" > Bạn đã đang xuất thành công!</h2>
	</aside>';
    exit();
}
