<?php

namespace CT275\Labs;

class list_exam_question
{
    private $db;

    public $exam_id;
    public $question_id;
    private $errors = [];

    public function getExam_id()
    {

        return $this->exam_id;
    }
    public function getQueston_id()
    {
        return $this->question_id;
    }

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fill(array $data)
    {
        if (isset($data['exam_id'])) {
            $this->exam_id = preg_replace('/\D+/', '', $data['exam_id']);
        }

        if (isset($data['question_id'])) {
            $this->question_id = preg_replace('/\D+/', '', $data['question_id']);
        }
        return $this;
    }

    public function getValidationErrors()
    {
        return $this->errors;
    }

    public function validate()
    {
        if (!$this->name) {
            $this->errors['name'] = 'Invalid name.';
        }

        if (strlen($this->phone) < 10 || strlen($this->phone) > 11) {
            $this->errors['phone'] = 'Invalid phone number.';
        }

        if (strlen($this->notes) > 255) {
            $this->errors['notes'] = 'Notes must be at most 255 characters.';
        }

        return empty($this->errors);
    }

    public function all()
    {
        $list_exam_questions = [];
        $stmt = $this->db->prepare('select * from list_exam_question');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $list_exam_question = new list_exam_question($this->db);
            $list_exam_question->fillFromDB($row);
            $list_exam_questions[] = $list_exam_question;
        }
        return $list_exam_questions;
    }
    protected function fillFromDB(array $row)
    {
        [
            'exam_id' => $this->exam_id,
            'question_id' => $this->question_id,
        ] = $row;
        return $this;
    }

    public function save()
    {
        $result = false;
        if ($this->id >= 0) {
            $stmt = $this->db->prepare('update contacts set name = :name,
phone = :phone, notes = :notes, updated_at = now()
where id = :id');
            $result = $stmt->execute([
                'name' => $this->name,
                'phone' => $this->phone,
                'notes' => $this->notes,
                'id' => $this->id
            ]);
        } else {
            $stmt = $this->db->prepare(
                'insert into contacts (name, phone, notes, created_at, updated_at)
values (:name, :phone, :notes, now(), now())'
            );
            $result = $stmt->execute([
                'name' => $this->name,
                'phone' => $this->phone,
                'notes' => $this->notes
            ]);
            if ($result) {
                $this->id = $this->db->lastInsertId(); // lay id giao dich cuoi cung
            }
        }
        return $result;
    }
    public function save_list_exam_question()
    {
        $result = false;

        $stmt = $this->db->prepare(
            'insert into list_exam_question (exam_id, question_id)
values (:exam_id, :question_id)'
        );
        $result = $stmt->execute([
            'exam_id' => $this->exam_id,
            'question_id' => $this->question_id,
        ]);

        return $result;
    }
    public function find($exam_id, $question_id)
    {
        $stmt = $this->db->prepare('select * from list_exam_question where exam_id = :exam_id and question_id = :question_id');
        $stmt->execute([
            'exam_id' => $exam_id,
            'question_id' => $question_id
        ]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }
    public function find_exam_id($exam_id)
    {
        $stmt = $this->db->prepare('select * from list_exam_question where exam_id = :exam_id');
        $stmt->execute([
            'exam_id' => $exam_id,
        ]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function find_all_question_exam_id($exam_id)
    {
        $list_exam_questions = [];
        $stmt = $this->db->prepare('select * from list_exam_question where exam_id = :exam_id');
        $stmt->execute([
            'exam_id' => $exam_id,
        ]);
        while ($row = $stmt->fetch()) {
            $list_exam_question = new list_exam_question($this->db);
            $list_exam_question->fillFromDB($row);
            $list_exam_questions[] = $list_exam_question;
        }
        return $list_exam_questions;
    }


    public function update_list_exam_question()
    {
        $result = false;
        if ($this->exam_id >= 0 && $this->question_id >= 0) {
            $stmt = $this->db->prepare(
                'insert into list_exam_question (exam_id, question_id)
    values (:exam_id, :question_id)'
            );
            $result = $stmt->execute([
                'exam_id' => $this->exam_id,
                'question_id' => $this->question_id,
            ]);
        }

        return $result;
    }
    public function delete()
    {
        $stmt = $this->db->prepare('delete from list_exam_question where exam_id = :exam_id and question_id = :question_id');
        return $stmt->execute([
            'exam_id' => $this->exam_id,
            'question_id' => $this->question_id
        ]);
    }

    public function delete_all_questions($exam_id)
    {
        $stmt = $this->db->prepare('delete from list_exam_question where exam_id = :exam_id');
        return $stmt->execute([
            'exam_id' => $exam_id,
        ]);
    }

    public function count_question($exam_id)
    {
        $stmt = $this->db->prepare('select COUNT(question_id) from list_exam_question where exam_id = :exam_id');
        $stmt->execute([
            'exam_id' => $exam_id,
        ]);
        if ($row = $stmt->fetchColumn()) {
            return $row;
        }
        return null;
    }

    public function add_auto_question($exam_id, array $questions){
        $list_exam_question = new list_exam_question($this->db);
        //$list_exam_question->delete_all_questions($exam_id);
        foreach($questions as $question){
           // $list_exam_question->$exam_id = $question.id;
           // $list_exam_question->save();        
           $list_exam_question->exam_id = $exam_id;
           $list_exam_question->question_id = $question->question_id;
            $list_exam_question->save_list_exam_question();   
        }

    }
}
