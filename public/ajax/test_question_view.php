<?php
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
	session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
require_once '../../bootstrap.php';

use CT275\Labs\question;

$question = new question($PDO);
$questions = $question->all();

use CT275\Labs\subject;

$subject = new subject($PDO);

use CT275\Labs\level_question;

$level_question = new level_question($PDO);

use CT275\Labs\options;

$option = new options($PDO);

use CT275\Labs\list_exam_question;

$list_exam_question = new list_exam_question($PDO);

use CT275\Labs\user_question_option;

$user_question_option = new user_question_option($PDO);

use CT275\Labs\exam;

$exam = new exam($PDO);

$table = ' ';
$i = 1;
foreach ($questions as $question) {
    if ($list_exam_question->find($_POST['exam_id'], $question->getId())) {
        $table .= ' <div class="col-9">
<div class="border border-secondary rounded p-3">

    <div class="alert alert-secondary" role="alert">
        <span>Câu ' . $i++ . ':</span> '.htmlspecialchars($question->question_title) .'
    </div>
    <div class="alert alert-success" role="alert">
    <form class=" text-secondary">
    <div class="form-check">
        <input type="radio" name="question" class="form-check-input" id="question_option" name="radio-stacked " data_question_id="'.$question->getId().'" value="1"';
        if($user_question_option->find($_SESSION['user_id'],$_POST['exam_id'],$question->getId()) && $user_question_option->user_answer_option ==1){$table.=' checked ';}
        $table.= ' > <label class="form-check-label" for="validationFormCheck2"><span>A. </span>' . htmlspecialchars($option->find($question->getId(), 1)->option_title) . '</label>
    </div>
    <div class="form-check">
        <input type="radio" name="question" class="form-check-input" id="question_option" name="radio-stacked " data_question_id="'.$question->getId().'" value="2"
        ';
        if($user_question_option->find($_SESSION['user_id'],$_POST['exam_id'],$question->getId()) && $user_question_option->user_answer_option ==2){$table.=' checked ';}
        $table.= ' 
        > <label class="form-check-label" for="validationFormCheck3"> <span>B. </span>' . htmlspecialchars($option->find($question->getId(), 2)->option_title) . '</label>
    </div>
    <div class="form-check">
        <input type="radio" name="question" class="form-check-input" id="question_option" name="radio-stacked" data_question_id="'.$question->getId().'" value="3"
        ';
        if($user_question_option->find($_SESSION['user_id'],$_POST['exam_id'],$question->getId()) && $user_question_option->user_answer_option ==3){$table.=' checked ';}
        $table.= ' >
        <label class="form-check-label" for="validationFormCheck2"><span>C. </span>' . htmlspecialchars($option->find($question->getId(), 3)->option_title) . '</label>
    </div>
    <div class="form-check">
        <input type="radio" name="question" class="form-check-input" id="question_option" name="radio-stacked " data_question_id="'.$question->getId().'" value="4"
        ';
        if($user_question_option->find($_SESSION['user_id'],$_POST['exam_id'],$question->getId()) && $user_question_option->user_answer_option ==4){$table.=' checked ';}
        $table.= ' >
        <label class="form-check-label" for="validationFormCheck3"> <span>D. </span>' . htmlspecialchars($option->find($question->getId(), 4)->option_title) . '</label>
    </div>

    </form>
    </div>

</div>
</div>';
    }
}
$table .= '   <div class="col-3" style="position: fixed;
top: 70; right:0%; ">
          <div class="border border-secondary rounded p-3 mb-4">
              <h4 class="text-center">Thi Công Nghệ Web HK2</h4>
          </div>
         <div class="borderary rounded p-1 mb-4">
              <div class="text-center"><button class=" btn"> <span class="badge  fs-6"> <input hidden  id="time_duration" value="'.$exam->find($_POST['exam_id'])->exam_duration.'"> <span id=""> </span>  </span></button></div>
          </div>
          <div class="border border-secondary rounded p-3 text-center mb-4">';
$i = 1;
foreach ($questions as $question) {
    if ($list_exam_question->find($_POST['exam_id'], $question->getId())) {
        $table .= '  <button type="button" class="btn';
        if($user_question_option->find($_SESSION['user_id'],$_POST['exam_id'],$question->getId())){ $table.= ' btn-primary '; }
         else{
            $table.= ' btn-outline-secondary ';

         }
         $table.= ' mb-1 p-2" style="width: 35px;">' . $i++ . '</button>';
    }
}

$table .= '
          </div>
          <div>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalNopbai">Nộp Bài</button>

          </div>
      </div>';
echo json_encode($table);
