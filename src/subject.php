<?php

namespace CT275\Labs;

class subject{
	private $db;

	private $subject_id = -1;
	public $subject_title;
	private $errors = [];

	public function get_Subject_Id()
	{
		return $this->subject_id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['subject_id'])) {
			$this->subject_id = preg_replace('/\D+/', '', $data['subject_id']);
		}

		if (isset($data['notes'])) {
			$this->subject_title = trim($data['subject_title']);
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
		$subjects = [];
		$stmt = $this->db->prepare('select * from subject');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$subject = new subject($this->db);
			$subject->fillFromDB($row);
			$subjects[] = $subject;
		}
		return $subjects;
	}
	protected function fillFromDB(array $row)
	{
		[
			'subject_id' => $this->subject_id,
			'subject_title' => $this->subject_title,			
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
	public function find($subject_id)
	{
		$stmt = $this->db->prepare('select * from subject where  subject_id= :subject_id');
		$stmt->execute(['subject_id' => $subject_id]);
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
