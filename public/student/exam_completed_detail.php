<?php include('../../partials/header_user.php');
include('../../partials/nav_student.php');
//unset($_SESSION['user']);
include('../../partials/check_user.php');
 ?>
<?php
require_once '../../bootstrap.php';

use CT275\Labs\exam;
$exam= new exam($PDO);
$exam->find($_GET['exam_id']); 

use CT275\Labs\user_question_option;
$user_question_option = new user_question_option($PDO);
$number_right = $user_question_option->count_marks($_SESSION['user_id'],$_GET['exam_id'],1); 
$number_false = $user_question_option->count_marks($_SESSION['user_id'],$_GET['exam_id'],0); 
$marks = $number_right * $exam->marks_right - $number_false * $exam->marks_wrong;


?>

<aside id="aside" class="px-4 mt-4 mb-4" style="width:100%">
<table id="contacts" class="table table-bordered table-responsive table-striped">
						<thead>
							<tr>
								
								<th>Tên kỳ thi</th>
                                <th>Ngày thi</th>
                                <th>Thời gian thi</th>
                                <th>Tổng số câu hỏi</th>
                                <th>Số câu đúng (+ <?= $exam->marks_right?>đ/câu)</th>
                                <th>Số câu sai (- <?= $exam->marks_wrong?>đ/câu)</th>
                                <th>Điểm tổng kết</th>
							</tr>
						</thead>
						<tbody>	
                                <tr>
									
									<td><?= htmlspecialchars($exam->exam_title)?></td>
                                    <td><?= htmlspecialchars($exam->exam_datetime) ?></td>
                                    <td><?= htmlspecialchars($exam->exam_duration) ?> phút</td>
                                    <td><?= htmlspecialchars($exam->total_question) ?> câu</td>
                                    <td><?= htmlspecialchars($number_right) ?> câu </td>
                                    <td><?= htmlspecialchars($number_false) ?> câu </td>
                                    <td><?= $marks?> điểm</td>
								</tr>
						</tbody>
					</table>

</aside>
</main>

<?php include('../../partials/footer.php') ?>
<script src="../js/wow.min.js"></script>

</html>