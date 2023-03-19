<?php
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



$table =' ';
$table .= ' <thead>
<tr>
    <th class="text-start">Tên câu hỏi</th>
    <th>Môn học</th>
    <th>Mức độ</th>
    <th>Hiệu chỉnh</th>
    
</tr>
</thead>
<tbody>';
foreach ($questions as $question){
$table.=
    '<tr>
        <td class="text-start">'.htmlspecialchars($question->question_title) .' ?. </td>
        <td>'.htmlspecialchars($subject->find($question->subject_id)->subject_title) .'</td>
        <td>'.htmlspecialchars($level_question->find($question->level_id)->level_question) .'</td>
        <td>
            <button class="btn btn-xs btn-warning fs-6" data_exam_id_edit="'.$question->getId().'"  data-bs-toggle="modal" data-bs-target="#exam_edit" id="btn-exam_edit">
                <i alt="Edit" class="fa fa-pencil"></i>
            </button>
           
            <button type="button" class="btn btn-xs btn-danger fs-6" data_exam_id_delete="'.$question->getId().'"  data-bs-toggle="modal" data-bs-target="#exam_delete"  id="btn-exam_delete">
                    <i alt="Delete" class="fa fa-trash"></i>
            </button>

        </td>
    </tr>
    <tr>

    <th colspan="4">
    <div class="alert alert-success mb-0" role="alert">
    <form class="was-validated text-start">
        <div class="form-check">
            <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked "'; if($question->answer_option == 1){$table.=' checked ';} else{$table.=' disabled ';} $table.= '>
            <label class="form-check-label" for="validationFormCheck2"><span>A. </span>'.htmlspecialchars($option->find($question->getId(),1)->option_title).'</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked "'; if($question->answer_option == 2){$table.=' checked ';} else{$table.=' disabled ';} $table.= '>

            <label class="form-check-label" for="validationFormCheck3"> <span>B. </span>'.htmlspecialchars($option->find($question->getId(),2)->option_title).'</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="validationFormCheck2" name="radio-stacked" '; if($question->answer_option == 3){$table.=' checked ';} else{$table.=' disabled ';} $table.= '    >
            <label class="form-check-label" for="validationFormCheck2"><span>C. </span>'.htmlspecialchars($option->find($question->getId(),3)->option_title).'</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="validationFormCheck3" name="radio-stacked "'; if($question->answer_option == 4){$table.=' checked ';} else{$table.=' disabled ';} $table.= '>
            <label class="form-check-label" for="validationFormCheck3"> <span>D. </span>'.htmlspecialchars($option->find($question->getId(),4)->option_title).'</label>
        </div>

       </div>
    </form>
    </div>
</th>
    </tr>';
}
$table .= '</tbody>';

echo json_encode($table);
