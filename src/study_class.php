<?php

namespace CT275\Labs;

class study_class
{
	private $db;

	public $study_class_id = -1;
	public $study_class_name;
	public $teacher_id;
	private $errors = [];

	public function getId()
	{
		return $this->study_class_id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['study_class_id'])) {
			$this->study_class_id = trim($data['study_class_id']);
		}

		if (isset($data['class_name'])) {
			$this->study_class_name =trim($data['study_class_name']);
		}
		if (isset($data['teacher_id'])) {
			$this->teacher_id =trim($data['teacher_id']);
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
		$study_classes = [];
		$stmt = $this->db->prepare('select * from study_class');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$study_class = new study_class($this->db);
			$study_class->fillFromDB($row);
			$study_classes[] = $study_class;
		}
		return $study_classes;
	}

	public function all_teacher_id($teacher_id)
	{
		$study_classes = [];
		$stmt = $this->db->prepare('select * from study_class where teacher_id = :teacher_id');
		$stmt->execute(['teacher_id' =>$teacher_id]);
		while ($row = $stmt->fetch()) {
			$study_class = new study_class($this->db);
			$study_class->fillFromDB($row);
			$study_classes[] = $study_class;
		}
		return $study_classes;
	}
	protected function fillFromDB(array $row)
	{
		[
			'study_class_id' => $this->study_class_id,
			'study_class_name' => $this->study_class_name,
			'teacher_id' => $this->teacher_id,
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
	public function find($study_class_id)
	{
		$stmt = $this->db->prepare('select * from study_class where study_class_id = :study_class_id');
		$stmt->execute(['study_class_id' => $study_class_id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function find_user_id_class_id($study_class_id)
	{
		$stmt = $this->db->prepare('select * from study_class where study_class_id = :study_class_id');
		$stmt->execute(['study_class_id' => $study_class_id]);
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

	public function count_study_class()
    {
        $stmt = $this->db->prepare('select COUNT(study_class_id) from study_class');
        $stmt->execute();
        if ($row = $stmt->fetchColumn()) {
            return $row;
        }
        return 0;
    }
}
