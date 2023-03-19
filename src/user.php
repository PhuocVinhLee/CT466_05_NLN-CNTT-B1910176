<?php

namespace CT275\Labs;

class user
{
	private $db;

	private $user_id = -1;
	public $user_email;
	public $user_password;
	public $user_name;
	public $user_gender;
	public $user_address;
	public $user_phone;
	public $user_image;
	public $user_created_on;
	public $user_updated_on;
	private $errors = [];

	public function getId()
	{
		return $this->user_id;
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
		if (isset($data['user_email'])) {
			$this->user_email = trim($data['user_email']);
		}
		if (isset($data['user_password'])) {
			$this->user_password = trim($data['user_password']);
		}
		if (isset($data['user_name'])) {
			$this->user_name = trim($data['user_name']);
		}
		if (isset($data['user_gender'])) {
			$this->user_gender = trim($data['user_gender']);
		}
		if (isset($data['user_address'])) {
			$this->user_address = trim($data['user_address']);
		}
		if (isset($data['user_phone'])) {
			$this->user_phone = trim($data['user_phone']);
		}
		if (isset($data['user_image'])) {
			$this->user_image = trim($data['user_image']);
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
		$users = [];
		$stmt = $this->db->prepare('select * from user');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$user = new user($this->db);
			$user->fillFromDB($row);
			$users[] = $user;
		}
		return $users;
	}
	protected function fillFromDB(array $row)
	{
		[
			'user_id' => $this->user_id,
			'user_email' => $this->user_email,
			'user_password' => $this->user_password,
			'user_name' => $this->user_name,
			'user_gender' => $this->user_gender,
			'user_address' => $this->user_address,
			'user_phone' => $this->user_phone,
			'user_image' => $this->user_image,
			'user_created_on' => $this->user_created_on,
			'user_updated_on' => $this->user_updated_on //gan gia tri tu mang qua doi tuong Contact
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

	public function edit_user()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update user set ten = :ten,
ho = :ho, gt = :gt, updated_at = now()
where id = :id');
			$result = $stmt->execute([
				'ten' => $this->ten,
				'ho' => $this->ho,
				'gt' => $this->gt,
				'id' => $this->id
			]);
		}

		return $result;
	}
	public function save_user()
	{
		$result = false;

		$stmt = $this->db->prepare(
			'insert into user (ten, ho, gt, created_at, updated_at)
values (:ten, :ho, :gt, now(), now())'
		);
		$result = $stmt->execute([
			'ten' => $this->ten,
			'ho' => $this->ho,
			'gt' => $this->gt
		]);
		if ($result) {
			$this->id = $this->db->lastInsertId(); // lay id giao dich cuoi cung
		}

		return $result;
	}
	public function find($user_email)
	{
		$stmt = $this->db->prepare('select * from user where user_email = :user_email');
		$stmt->execute(['user_email' => $user_email]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}


	public function find_user_id($user_id)
	{
		$stmt = $this->db->prepare('select * from user where user_id = :user_id');
		$stmt->execute(['user_id' => $user_id]);
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
		$stmt = $this->db->prepare('delete from user where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
