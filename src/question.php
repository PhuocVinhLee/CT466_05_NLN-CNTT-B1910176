<?php

namespace CT275\Labs;

class question
{
	private $db;
	public $question_id;
	public $question_title;
	public $answer_option;
	public $level_id;
	public $subject_id;
    public $question_img;
	private $errors = [];

	public function getId()
	{
		return $this->question_id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
        if (isset($data['question_id'])) {
			$this->question_id = preg_replace('/\D+/', '', $data['question_id']);
		}

		if (isset($data['question_title'])) {
			$this->question_title = trim($data['question_title']);
		}

		if (isset($data['answer_option'])) {
			$this->answer_option = preg_replace('/\D+/', '', $data['answer_option']);
		}

		if (isset($data['level_id'])) {
			$this->level_id = trim($data['level_id']);
		}
		if (isset($data['subject_id'])) {
			$this->subject_id = trim($data['subject_id']);
		}
        if(isset($data['question_img'])){
            $this->question_img = trim($data['question_img']);
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
		$questions = [];
		$stmt = $this->db->prepare('select * from question');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$question = new question($this->db);
			$question->fillFromDB($row);
			$questions[] = $question;
		}
		return $questions;
	}

	public function all_subject($subject_id)
	{
		$questions = [];
		$stmt = $this->db->prepare('select * from question where subject_id = :subject_id');
		$stmt->execute(['subject_id' => $subject_id]);
		while ($row = $stmt->fetch()) {
			$question = new question($this->db);
			$question->fillFromDB($row);
			$questions[] = $question;
		}
		return $questions;
	}
	protected function fillFromDB(array $row)
	{
		[
			'question_id' => $this->question_id,
			'question_title' => $this->question_title,
			'answer_option' => $this->answer_option,
			'level_id' => $this->level_id,
			'subject_id' => $this->subject_id,
			'question_img' => $this->question_img//gan gia tri tu mang qua doi tuong Contact
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
				$this->id = $this->db->lastInsertId();// lay id giao dich cuoi cung
			}
		}
		return $result;
	}
    public function save_question()
	{
		$result = false;
        $stmt = $this->db->prepare(
            'insert into question (question_title, answer_option, level_id, subject_id, question_img)
values (:question_title, :answer_option, :level_id, :subject_id, :question_img)'
        );
        $result = $stmt->execute([
            'question_title' => $this->question_title,
            'answer_option' => $this->answer_option,
            'level_id' => $this->level_id,
            'subject_id' => $this->subject_id,
            'question_img' => $this->question_img,

        ]);
		if ($result) {
			$this->question_id = $this->db->lastInsertId();// lay id giao dich cuoi cung
		}
		return $result;
	}
	public function find($question_id)
	{
		$stmt = $this->db->prepare('select * from question where question_id = :question_id');
		$stmt->execute(['question_id' => $question_id]);
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

    public function get_auto_id_question($number_question,$level_id, $subject_id){
		$questions = [];
		$stmt = $this->db->prepare('select  * FROM question where level_id = :level_id and subject_id =:subject_id  ORDER BY RAND()
		limit ' .$number_question.'');
		$stmt->execute(
			['level_id' => $level_id,
			'subject_id' => $subject_id]
			);
		while ($row = $stmt->fetch()) {
			$question = new question($this->db);
			$question->fillFromDB($row);
			$questions[] = $question;
		}
		return $questions;
	
	}
}
