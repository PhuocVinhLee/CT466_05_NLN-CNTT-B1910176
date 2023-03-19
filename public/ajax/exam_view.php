<?php

if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
require_once '../../bootstrap.php';

use CT275\Labs\exam;

$exam = new exam($PDO);
$exams = $exam->all_exam_admin_id($_SESSION['admin_id']);

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
    <th>Trạng thái kỳ thi</th>
    <th>Thời gian thi</th>
    <th>Thời gian làm bài</th>
    <th>Tổng số câu hỏi</th>
    <th>Điểm đúng</th>
    <th>Điểm sai</th>
    <th>Giáo viên</th>
    <th>Môn học</th>
    <th>Lớp học</th>
    <th>Hiệu chỉnh</th>
    
</tr>
</thead>
<tbody>';
foreach ($exams as $exam){
$table.=
    '<tr>
        <td>'.htmlspecialchars($exam->get_Exam_Id()) .'</td>
        <td>'.htmlspecialchars($exam->exam_title) .'</td>
        <td>      

        
            <button id="btn_status" type="button" class="btn ';
            if($exam->exam_status == "Khởi tạo"){$table.='btn-primary ';}
            if($exam->exam_status == "Công bố"){$table.='btn-info ';}
            if($exam->exam_status == "Đang diễn ra"){$table.='btn-warning ';}
            if($exam->exam_status == "Hoàn thành"){$table.='btn-success ';}        
             ;
            $table.= 'fs-6" data-bs-toggle="modal" data-bs-target="#exampleModalEnableUser">'.htmlspecialchars($exam->exam_status) .'</button>
        </td>
        <td>'.$exam->exam_datetime.'</td>
        <td>'.htmlspecialchars($exam->exam_duration).' phút </td>
        <td>'.htmlspecialchars($exam->total_question).'</td>
        <td>'.htmlspecialchars($exam->marks_right).'</td>
        <td>'.htmlspecialchars($exam->marks_wrong).'</td>
        <td>'.htmlspecialchars($exam->teacher_id).'</td>
        <td>'.htmlspecialchars($subject->find(htmlspecialchars($exam->subject_id))->subject_title).'</td>
        <td>'.htmlspecialchars($study_class->find(htmlspecialchars($exam->study_class_id))->study_class_name).'</td>
        

        <td>
            <button class="btn btn-xs btn-warning fs-6" data_exam_id_edit="'.$exam->get_Exam_Id().'"  data-bs-toggle="modal" data-bs-target="#exam_edit" id="btn-exam_edit">
                <i alt="Edit" class="fa fa-pencil"> Edit</i>
            </button>
           
            <button type="button" class="btn btn-xs btn-danger fs-6" data_exam_id_delete="'.$exam->get_Exam_Id().'"  data-bs-toggle="modal" data-bs-target="#exam_delete"  id="btn-exam_delete">
                    <i alt="Delete" class="fa fa-trash"> Delete</i>
            </button>

        </td>
    </tr>';
}
$table .= '</tbody>';

echo json_encode($table);

?>
