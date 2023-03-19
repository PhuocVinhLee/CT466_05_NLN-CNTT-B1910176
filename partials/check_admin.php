<?php

if (!is_administrator()) {
	echo '
	<aside style="width: 100%;" class="p-3 mt-5">
	<h2 class="text-center text-danger" >Lỗi!. Bạn không có quyền truy xuất trang này!</h2>
	</aside>';
	exit();
}
