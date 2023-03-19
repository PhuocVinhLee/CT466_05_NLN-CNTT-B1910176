
<?php
require_once '../../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\exam;

$exam = new exam($PDO); // khoi tao de sd cac ham
if (isset($_POST['data_exam_id_edit']) && $exam->find($_POST['data_exam_id_edit'])) {
    $exam_data['exam_id'] = $exam->get_Exam_Id();
    $exam_data['exam_title'] = $exam->exam_title;
    $exam_data['exam_status'] = $exam->exam_status;
    $exam_data['total_question'] = $exam->total_question;
    $exam_data['marks_right'] = $exam->marks_right;
    $exam_data['marks_wrong'] = $exam->marks_wrong;
    $exam_data['teacher_id'] = $exam->teacher_id;
    $exam_data['subject_id'] = $exam->subject_id;
    $exam_data['study_class_id'] = $exam->study_class_id;
    
    $exam_data['exam_datetime'] =  $exam->exam_datetime;
    $exam_data['exam_duration'] = $exam->exam_duration;
    echo json_encode($exam_data);
}
if (isset($_POST['data_exam_id_delete']) && $exam->find($_POST['data_exam_id_delete'])) {
    $exam_data['exam_id'] = $exam->get_Exam_Id();
    $exam_data['exam_title'] = $exam->exam_title;
    $exam_data['exam_status'] = $exam->exam_status;
    $exam_data['total_question'] = $exam->total_question;
    $exam_data['marks_right'] = $exam->marks_right;
    $exam_data['marks_wrong'] = $exam->marks_wrong;
    $exam_data['teacher_id'] = $exam->teacher_id;
    $exam_data['subject_id'] = $exam->subject_id;
    $exam_data['study_class_id'] = $exam->study_class_id;
    echo json_encode($exam_data);
}