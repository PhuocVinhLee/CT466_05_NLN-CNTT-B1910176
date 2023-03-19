
<?php
include('../../partials/header.php');
include('../../partials/nav_teacher.php') ;
require_once '../../bootstrap.php';
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
if (1) {
    unset($_SESSION['admin']);
    unset($_SESSION['admin_id']);
    echo '
	<aside style="width: 100%;" class="p-3 mt-5">
	<h2 class="text-center text-success" > Bạn đã đang xuất thành công!</h2>
	</aside>';
    exit();
}
