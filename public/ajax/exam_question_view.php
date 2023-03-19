<?php
require_once '../../bootstrap.php';

use CT275\Labs\exam;

$exam = new exam($PDO);
$exams = $exam->all();

use CT275\Labs\subject;

$subject = new subject($PDO);
$subjects = $subject->all();
$subjects1 = $subject->all();

use CT275\Labs\study_class;

$study_class = new study_class($PDO);


$table =' ';
$table .= ' <thead>
<tr>
    <th>Exam_id</th>
    <th>Tên kỳ thi</th>
    <th>Thêm câu hỏi</th>
    
</tr>
</thead>
<tbody>';
foreach ($exams as $exam){
$table.=
    '<tr>
        <td>'.htmlspecialchars($exam->get_Exam_Id()) .'</td>
        <td>'.htmlspecialchars($exam->exam_title) .'</td>
      

        <td>
        <a href="exam_question_add.php?id='.$exam->get_Exam_Id().'"><button type="button" class="btn btn-xs btn-primary fs-6" data_exam_id_delete="'.$exam->get_Exam_Id().'">
                    <i alt="Delete" class="far fa-arrow-alt-circle-right"></i>
            </button></a>

        </td>
    </tr>';
}
$table .= '</tbody>';

echo json_encode($table);

?>
