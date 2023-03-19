<?php
require_once '../../bootstrap.php';

use CT275\Labs\exam;

$exam = new exam($PDO);
$result = false;
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['exam_title']) && isset($_POST['exam_add_form'] )
) {
   
    $exam->fill($_POST);
    if($exam->save_exam()){
       // redirect("/teacher/exam.php");
       $result = true;
      //echo ($result);
       echo json_encode('<div class="alert alert-primary" role="alert">
      Bạn đã thêm dữ liệu thành công !
     </div>');
    }
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['exam_id']) && isset($_POST['exam_edit_form']) &&  $exam->find($_POST['exam_id'])
) {
    $exam->fill($_POST);
    if( $exam->update_exam()){
       $result = true;
      //echo ($result);
       echo json_encode('<div class="alert alert-primary" role="alert">
      Bạn đã cập nhật dữ liệu thành công !
     </div>');
    }
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['exam_id']) && isset($_POST['exam_delete_form']) &&  $exam->find($_POST['exam_id'])
) {
    if( $exam->delete_exam()){
       $result = true;
      //echo ($result);
       echo json_encode('<div class="alert alert-primary" role="alert">
      Bạn đã xóa dữ liệu thành công !
     </div>');
    }
}

