<?php

namespace CT275\Labs;

class options
{
	private $db;

	private $question_id = -1;
	public $option_title;
	public $option_number;
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
			$this->question_id = trim($data['question_id']);
		}

		if (isset($data['option_title'])) {
			$this->option_title = preg_replace('/\D+/', '', $data['option_title']);
		}

		if (isset($data['option_number'])) {
			$this->option_number = trim($data['option_number']);
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
		$contacts = [];
		$stmt = $this->db->prepare('select * from contacts');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$contact = new Contact($this->db);
			$contact->fillFromDB($row);
			$contacts[] = $contact;
		}
		return $contacts;
	}
	protected function fillFromDB(array $row)
	{
		[
			'question_id' => $this->question_id,
			'option_title' => $this->option_title,
			'option_number' => $this->option_number
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

	public function save_options($question_id,$option_title,$option_number)
	{
		$result = false;
	
			$stmt = $this->db->prepare(
				'insert into options (question_id, option_title, option_number)
values (:question_id, :option_title, :option_number)'
			);
			$result = $stmt->execute([
				'question_id' => $question_id,
				'option_title' => $option_title,
				'option_number' => $option_number
			]);
		
		
		return $result;
	}
	public function find($question_id,$option_number)
	{
		$stmt = $this->db->prepare('select * from options where question_id = :question_id and option_number = :option_number');
		$stmt->execute(['question_id' => $question_id,
                        'option_number' => $option_number]);
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
	public function delete()
	{
		$stmt = $this->db->prepare('delete from contacts where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
