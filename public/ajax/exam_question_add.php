<?php
require_once '../../bootstrap.php';

use CT275\Labs\question;

$question = new question($PDO);

use CT275\Labs\list_exam_question;

$list_exam_question = new list_exam_question($PDO);

$result = false;


if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_id']) && isset($_POST['form_exam_question_add_1'])
) {
    if (!$list_exam_question->find($_POST['exam_id'], $_POST['question_id'])) {
        $list_exam_question->fill($_POST);
        $list_exam_question->save_list_exam_question();
        echo json_encode('<div class="alert alert-primary" role="alert">
    Bạn đã them dữ liệu thành công !
   </div>');
    } else {
        $list_exam_question->delete();
        echo json_encode('<div class="alert alert-primary" role="alert">
        Bạn đã xóa dữ liệu thành công !
       </div>');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_id']) && isset($_POST['form_exam_question_add'])) {
    $list_exam_question->delete_all_questions($_POST['exam_id']);

    if (isset($_POST['de']) && $_POST['de'] != 0) {
        $questions = $question->get_auto_id_question($_POST['de'], 1, $_POST['subject_id']);
        // echo json_encode($questions);
        $list_exam_question->add_auto_question($_POST['exam_id'], $questions);
        // echo json_encode( $list_exam_question->add_auto_question($_POST['exam_id'],$questions));
    }
    if (isset($_POST['de']) && $_POST['trungbinh'] != 0) {
        $questions = $question->get_auto_id_question($_POST['trungbinh'], 2, $_POST['subject_id']);
        $list_exam_question->add_auto_question($_POST['exam_id'], $questions);
    }
    if (isset($_POST['de']) && $_POST['kho'] != 0) {
        $questions = $question->get_auto_id_question($_POST['kho'], 3, $_POST['subject_id']);
        $list_exam_question->add_auto_question($_POST['exam_id'], $questions);
    }
    echo json_encode('<div class="alert alert-primary" role="alert">
     Bạn đã cập nhật dữ liệu thành công !
    </div>');
}
