<?php
require_once '../../bootstrap.php';

use CT275\Labs\question;

$question = new question($PDO);


use CT275\Labs\options;

$option = new options($PDO);

$result = false;
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_title']) && isset($_POST['question_add_form'] )
) {
   
    $question->fill($_POST);
    if($question->save_question() &&
    $option->save_options($question->getId(),$_POST['option_title_1'],1) && 
    $option->save_options($question->getId(),$_POST['option_title_2'],2) && 
    $option->save_options($question->getId(),$_POST['option_title_3'],3) && 
    $option->save_options($question->getId(),$_POST['option_title_4'],4)){

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

