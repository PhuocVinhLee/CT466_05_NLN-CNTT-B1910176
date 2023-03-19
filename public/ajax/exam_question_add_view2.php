<?php
require_once '../../bootstrap.php';
use CT275\Labs\exam;

$exam = new exam($PDO);
$exam->find($_POST['id']);// tong so cau hoi cua ky thi 

use CT275\Labs\question;

use CT275\Labs\subject;

$subject = new subject($PDO);

use CT275\Labs\level_question;

$level_question = new level_question($PDO);


use CT275\Labs\list_exam_question;

$list_exam_question = new list_exam_question($PDO);

$count = $list_exam_question->count_question($_POST['id']);// tong so cau hoi da chon
if($count == null){
    $count = 0;
}

$list_exam_question1 = new list_exam_question($PDO);
$list_exam_question1s = $list_exam_question1->find_all_question_exam_id($_POST['id']);
$question = new question($PDO);
$de = 0;
$trungbinh = 0;
$kho = 0;
foreach($list_exam_question1s as $list_exam_question){
    if($question->find($list_exam_question->question_id)){
        if($question->level_id == 1){
            $de ++;
        }else if($question->level_id == 2){
            $trungbinh ++;
        }else if($question->level_id == 3){
            $kho ++;
        }

    }

}

$table =' ';
$table.='<div class="modal-body">
<div id="message_select">
    <div class="alert alert-primary" role="alert">
        Đã chọn <span id = "count"> '.$count.'</span>/<span id = "total_question">'.$exam->total_question.'</span> câu hỏi
    </div>
</div>
<div id="message_auto">
</div>
<form class="row g-3 " method="post" id="form_exam_question_add">
    <div class="col-md-8">
        <input name="total_question" id="total_question" type="text" value="Số lượng câu hỏi Dễ"  class="form-control is-valid" disabled>

    </div>
    <div class="col-md-4">
        <input type="number" id="de" name ="de" class="form-control" value="'.$de.'" min=0>
        <div class="invalid-feedback">Số lượng tối đa có thể chọn là <span></span> </div>
    </div>
    <div class="col-md-8">
        <input name="total_question" id="total_question" type="text" value="Số lượng câu hỏi Trung Bình" class="form-control is-valid" disabled>

    </div>
    <div class="col-md-4">
        <input type="number" id="trungbinh" name="trungbinh" class="form-control" value="'.$trungbinh.'" min=0  >
        <div class="invalid-feedback">Số lượng tối đa có thể chọn là <span></span> </div>
    </div>
    <div class="col-md-8">
        <input name="total_question" id="total_question" type="text" value="Số lượng câu hỏi Khó" class="form-control is-valid" disabled>

    </div>
    <div class="col-md-4">
        <input type="number" id="kho" name="kho" class="form-control" value="'.$kho.'" min=0 >
        <div class="invalid-feedback">Số lượng tối đa có thể chọn là <span></span> </div>
    </div>


    <input hidden type="number" id="form_exam_question_add" name="form_exam_question_add" value="form_exam_question_add">
    <input hidden type="number" id="subject_id" name="subject_id" value="'.$exam->subject_id.'">

    <div class="mb-3">
        <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
    </div>

</form>
</div>';



echo json_encode($table);
