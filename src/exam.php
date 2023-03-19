<?php

namespace CT275\Labs;

class exam
{
    private $db;

    private $exam_id = -1;
    public $exam_title;
    public $exam_status;
    public $exam_datetime;
    public $exam_duration;
    public $total_question;
    public $marks_right;
    public $marks_wrong;
    public $teacher_id;
    public $subject_id;
    public $study_class_id;
    private $errors = [];

    public function get_Exam_Id()
    {
        return $this->exam_id;
    }

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fill(array $data)
    {
        if (isset($data['exam_title'])) {
            $this->exam_title = trim($data['exam_title']);
        }

        if (isset($data['exam_status'])) {
            $this->exam_status = trim($data['exam_status']);
        }

        if (isset($data['total_question'])) {
            $this->total_question = trim($data['total_question']);
        }

        if (isset($data['marks_right'])) {
            $this->marks_right = trim($data['marks_right']);
        }

        if (isset($data['exam_datetime'])) {
            $this->exam_datetime = trim($data['exam_datetime']);
        }

        if (isset($data['exam_duration'])) {
            $this->exam_duration = trim($data['exam_duration']);
        }

        if (isset($data['marks_wrong'])) {
            $this->marks_wrong = trim($data['marks_wrong']);
        }

        if (isset($data['teacher_id'])) {
            $this->teacher_id = trim($data['teacher_id']);
        }

        if (isset($data['subject_id'])) {
            $this->subject_id = trim($data['subject_id']);
        }

        if (isset($data['study_class_id'])) {
            $this->study_class_id = trim($data['study_class_id']);
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
        $exams = [];
        $stmt = $this->db->prepare('select * from exam ORDER BY exam_id DESC');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $exam = new exam($this->db);
            $exam->fillFromDB($row);
            $exams[] = $exam;
        }
        return $exams;
    }
    public function all_exam_admin_id($teacher_id)
    {
        $exams = [];
        $stmt = $this->db->prepare('select * from exam where teacher_id = :teacher_id');
        $stmt->execute([
            'teacher_id' => $teacher_id,
    ]);
        while ($row = $stmt->fetch()) {
            $exam = new exam($this->db);
            $exam->fillFromDB($row);
            $exams[] = $exam;
        }
        return $exams;
    }


    public function all_teacher_id_study_class_id($teacher_id, $study_class_id)
    {
        $exams = [];
        $stmt = $this->db->prepare('select * from exam where teacher_id = :teacher_id and study_class_id = :study_class_id and NOT exam_status = :exam_status');
        $stmt->execute([
            'teacher_id' => $teacher_id,
            'study_class_id' => $study_class_id,
            'exam_status'=> 'Khởi tạo'
    ]);
        while ($row = $stmt->fetch()) {
            $exam = new exam($this->db);
            $exam->fillFromDB($row);
            $exams[] = $exam;
        }
        return $exams;
    }

    public function find_teacher_id_study_class_id($teacher_id, $study_class_id)
    {
        $stmt = $this->db->prepare('select * from exam where teacher_id = :teacher_id and study_class_id = :study_class_id and exam_status = :exam_status');
        $stmt->execute([
            'teacher_id' => $teacher_id,
            'study_class_id' => $study_class_id,
            'exam_status'=> 'Công bố',
    ]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }
    protected function fillFromDB(array $row)
    {
        [
            'exam_id' => $this->exam_id,
            'exam_title' => $this->exam_title,
            'exam_status' => $this->exam_status,
            'total_question' => $this->total_question,
            'exam_datetime' =>$this->exam_datetime,
            'exam_duration' =>$this->exam_duration,
            'marks_right' => $this->marks_right,
            'marks_wrong' => $this->marks_wrong, //gan gia tri tu mang qua doi tuong Contact
            'teacher_id' => $this->teacher_id,
            'subject_id' => $this->subject_id, //gan gia tri tu mang qua doi tuong Contact
            'study_class_id' => $this->study_class_id //gan gia tri tu mang qua doi tuong Contact
        ] = $row;
        return $this;
    }
    public function get_exam_status()
    {
        $exams = [];
        $stmt = $this->db->prepare('select * from exam GROUP BY exam_status');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $exam = new exam($this->db);
            $exam->fillFromDB($row);
            $exams[] = $exam;
        }
        return $exams;
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
    public function save_exam()
    {
        $result = false;

        $stmt = $this->db->prepare(
            'insert into exam (exam_title, exam_status, exam_datetime, exam_duration, total_question, marks_right, marks_wrong, teacher_id, subject_id, study_class_id )
values (:exam_title, :exam_status, :exam_datetime, :exam_duration, :total_question, :marks_right, :marks_wrong, :teacher_id, :subject_id, :study_class_id)'
        );
        $result = $stmt->execute([
            'exam_title' => $this->exam_title,
            'exam_status' => $this->exam_status,
            'total_question' => $this->total_question,
            'marks_right' => $this->marks_right,
            'marks_wrong' => $this->marks_wrong,
            'teacher_id' => $this->teacher_id,
            'subject_id' => $this->subject_id,
            'study_class_id' => $this->study_class_id,
            'exam_datetime' => $this->exam_datetime,
            'exam_duration' => $this->exam_duration
        ]);

        return $result;
    }
    public function update_exam()
    {
        $result = false;
        if ($this->exam_id >= 0) {
            $stmt = $this->db->prepare(
                'update exam set exam_title = :exam_title, exam_status = :exam_status, exam_duration = :exam_duration,exam_datetime =:exam_datetime, total_question = :total_question,
                 marks_right = :marks_right, marks_wrong = :marks_wrong, teacher_id = :teacher_id, subject_id = :subject_id, study_class_id = :study_class_id
    where exam_id = :exam_id'
            );
            $result = $stmt->execute([
                'exam_id' => $this->exam_id,
                'exam_title' => $this->exam_title,
                'exam_status' => $this->exam_status,
                'total_question' => $this->total_question,
                'marks_right' => $this->marks_right,
                'marks_wrong' => $this->marks_wrong,
                'teacher_id' => $this->teacher_id,
                'subject_id' => $this->subject_id,
                'study_class_id' => $this->study_class_id,
                'exam_datetime' => $this->exam_datetime,
                'exam_duration' => $this->exam_duration
            ]);
        }
        return $result;
    }

    public function find($exam_id)
    {
        $stmt = $this->db->prepare('select * from exam where exam_id = :exam_id');
        $stmt->execute(['exam_id' => $exam_id]);
        if ($row = $stmt->fetch()) {
            $this->fillFromDB($row);
            return $this;
        }
        return null;
    }

    public function update(array $data)
    {
        $this->fill($data);
        if ($this->validate()) {
            return $this->save();
        }
        return false;
    }
    public function delete_exam()
    {
        $stmt = $this->db->prepare('delete from exam where exam_id = :exam_id');
        return $stmt->execute(['exam_id' => $this->exam_id]);
    }
}
