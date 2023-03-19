<?php
require_once '../../bootstrap.php';
use CT275\Labs\exam;

$exam = new exam($PDO);

use CT275\Labs\question;

$question = new question($PDO);
$questions = $question->all_subject($exam->find($_POST['id'])->subject_id);

use CT275\Labs\subject;

$subject = new subject($PDO);

use CT275\Labs\level_question;

$level_question = new level_question($PDO);


use CT275\Labs\list_exam_question;

$list_exam_question = new list_exam_question($PDO);

$count = $list_exam_question->count_question($_POST['id']);
if($count == null){
    $count = 0;
}
$table =' ';
$table .= ' <thead>
<tr>
    <th>  <a id="btn_exam_question_add" class="btn btn-primary mt-3 mb-3 " data-bs-toggle="modal" data-bs-target="#exam_question_add">
    Auto </a></th>
    <th></th>
    <th></th>
    <th><select class="form-select fs-6" aria-label="Default select example">
    <option selected>Dễ</option>
    <option value="1">Trung Bình</option>
    <option value="2">Khó</option>
    <option value="3">Three</option>
  </select></th>
    
</tr>
<tr>
    <th>Đã chọn <span class="fs-5"> '.$count.'/'.$exam->total_question.'</span></th>
    <th>ID</th>
    <th class="text-start">Tên câu hỏi</th>
    <th>Mức độ</th>
    
</tr>
</thead>
<tbody>';
foreach ($questions as $question){
$table.=
    '<tr>
    <td class="text-center>
    <form>
    
    <div class="form-check">
<input class="form-check-input fs-3" type="checkbox" value="'.$question->getId().'" id="flexCheckChecked" ';
if($list_exam_question->find($_POST['id'],$question->getId())){$table.= " checked ";}
else{
    if($count == $exam->total_question){
        $table.= ' disabled';
    }

}
$table.=' >
</div>

<input hidden type="text" id="form_exam_question_add_1"  name="form_exam_question_add_1" value="form_exam_question_add_1">
  </form>

  </td>
  <td class="text-center">'.htmlspecialchars($question->question_id) .'</td>
        <td class="text-start">'.htmlspecialchars($question->question_title) .' ?. </td>
        <td>'.htmlspecialchars($level_question->find($question->level_id)->level_question) .'</td>
    </tr>';
}
$table .= '</tbody>';

echo json_encode($table);
