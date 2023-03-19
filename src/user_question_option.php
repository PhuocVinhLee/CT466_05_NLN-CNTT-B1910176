<?php

namespace CT275\Labs;

class user_question_option
{
	private $db;

	public $user_id;
	public $exam_id;
	public $question_id;
	public $user_answer_option;
	public $marks;
	private $errors = [];

	public function get_user_id()
	{
		return $this->user_id;
	}
    
	public function get_exam_id()
	{
		return $this->exam_id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['user_id'])) {
			$this->user_id = trim($data['user_id']);
		}
        if (isset($data['exam_id'])) {
			$this->exam_id = trim($data['exam_id']);
		}
        if (isset($data['question_id'])) {
			$this->question_id = trim($data['question_id']);
		}
		if (isset($data['user_answer_option'])) {
			$this->user_answer_option = preg_replace('/\D+/', '', $data['user_answer_option']);
		}

		if (isset($data['marks'])) {
			$this->marks = ($data['marks']);
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
		$user_question_options = [];
		$stmt = $this->db->prepare('select * from user_question_option');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$user_question_option = new user_question_option($this->db);
			$user_question_option->fillFromDB($row);
			$user_question_options[] = $user_question_option;
		}
		return $user_question_options;
	}
	protected function fillFromDB(array $row)
	{
		[
			'user_id' => $this->user_id,
			'exam_id' => $this->exam_id,
			'question_id' => $this->question_id,
			'user_answer_option' => $this->user_answer_option,
			'marks' => $this->marks			
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
    public function save_user_question_option()
	{
		$result = false;
		
			$stmt = $this->db->prepare(
				'insert into user_question_option (user_id, exam_id, question_id, user_answer_option, marks)
values (:user_id, :exam_id, :question_id, :user_answer_option, :marks)'
			);
			$result = $stmt->execute([
				'user_id' => $this->user_id,
				'exam_id' => $this->exam_id,
				'question_id' => $this->question_id,
                'user_answer_option' => $this->user_answer_option,
                'marks' => $this->marks

			]);					
		return $result;
	}
    public function update_user_question_option()
	{
		$result = false;
		
			$stmt = $this->db->prepare(
				'update user_question_option set user_answer_option = :user_answer_option, marks = :marks
                 where user_id = :user_id and exam_id = :exam_id and question_id = :question_id '
			);
			$result = $stmt->execute([
				'user_id' => $this->user_id,
				'exam_id' => $this->exam_id,
				'question_id' => $this->question_id,
                'user_answer_option' => $this->user_answer_option,
				'marks' => $this->marks
			]);					
		return $result;
	}

	public function find($user_id,$exam_id,$question_id)
	{
		$stmt = $this->db->prepare('select * from user_question_option where user_id = :user_id and exam_id = :exam_id and question_id = :question_id ');
		$stmt->execute([
			    'user_id' => $user_id,
				'exam_id' => $exam_id,
				'question_id' =>$question_id,
		]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}

	public function find_all_exam_user_id($user_id)
	{
		$user_question_options = [];
		$stmt = $this->db->prepare('select * from user_question_option where user_id = :user_id GROUP BY exam_id');
		$stmt->execute(['user_id'=>$user_id]);
		while ($row = $stmt->fetch()) {
			$user_question_option = new user_question_option($this->db);
			$user_question_option->fillFromDB($row);
			$user_question_options[] = $user_question_option;
		}
		return $user_question_options;
	}

	public function count_marks($user_id, $exam_id, $marks)
	{
		$stmt = $this->db->prepare('SELECT COUNT(question_id)
		FROM user_question_option where user_id = :user_id and exam_id = :exam_id and marks = :marks');
		$stmt->execute([
			'user_id' =>$user_id,
			'exam_id' =>$exam_id,
			'marks' =>$marks,

		]);
	    $row = $stmt->fetch();
		return $row[0];
	}
	public function update(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from contacts where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
