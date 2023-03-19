<?php include('../../partials/header_user.php');
include('../../partials/nav_student.php');
//unset($_SESSION['user']);
include('../../partials/check_user.php');
 ?>
<?php
require_once '../../bootstrap.php';
 
use CT275\Labs\user_question_option;
$user_question_option = new user_question_option($PDO);
$user_question_options = $user_question_option->find_all_exam_user_id($_SESSION['user_id']);

use CT275\Labs\exam;
$exam = new exam($PDO);

?>

<aside id="aside" class="px-4 mt-4 mb-4" style="width:100%">
<table id="contacts" class="table table-bordered table-responsive table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Tên kỳ thi</th>
                                <th>Tên giáo viên</th>
                                <th>Tên môn học</th>
                                <th>Xem chi tiết</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($user_question_options as $user_question_option) : ?>			
                                <tr>
									<td><?= htmlspecialchars($user_question_option->exam_id) ?></td>
									<td><?= htmlspecialchars($exam->find($user_question_option->exam_id)->exam_title) ?></td>
                                    <td><?= htmlspecialchars($exam->teacher_id) ?></td>
                                    <td><?= htmlspecialchars($exam->subject_id) ?></td>
									<td>
                                    <a href="exam_completed_detail.php?exam_id=<?= $exam->get_Exam_Id()?>"><button type="button" class="btn btn-primary">Xem</button></a>
									</td>
								</tr>

							<?php endforeach ?>

						</tbody>
					</table>

</aside>
</main>

<?php include('../../partials/footer.php') ?>
<script src="../js/wow.min.js"></script>

</html>