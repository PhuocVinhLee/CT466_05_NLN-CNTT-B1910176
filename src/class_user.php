<?php

namespace CT275\Labs;

class class_user
{
	private $db;

	public $class_id = -1;
	public $user_id;
	private $errors = [];

	public function getId()
	{
		return $this->class_id;
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
		$class_users = [];
		$stmt = $this->db->prepare('select * from class_user');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$class_user = new class_user($this->db);
			$class_user->fillFromDB($row);
			$class_users[] = $class_user;
		}
		return $class_users;
	}
	public function all_user_id($user_id)
	{
		$class_users = [];
		$stmt = $this->db->prepare('select * from class_user where user_id = :user_id ');
		$stmt->execute(['user_id' => $user_id]);
		while ($row = $stmt->fetch()) {
			$class_user = new class_user($this->db);
			$class_user->fillFromDB($row);
			$class_users[] = $class_user;
		}
		return $class_users;
	}
	protected function fillFromDB(array $row)
	{
		[
			'class_id' => $this->class_id,
			'user_id' => $this->user_id,
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
	public function find($class_id,$user_id)
	{
		$stmt = $this->db->prepare('select * from class_user where class_id = :class_id and user_id = :user_id');
		$stmt->execute([
			'class_id' => $class_id,
			'user_id' => $user_id
	]);
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

	public function count_class_user($user_id)
    {
        $stmt = $this->db->prepare('select COUNT(class_id) from class_user where user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);
        if ($row = $stmt->fetchColumn()) {
            return $row;
        }
        return 0;
    }
}
