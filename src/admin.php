<?php

namespace CT275\Labs;

class admin
{
	private $db;

	private $admin_id = -1;
	public $admin_email;
	public $admin_password;
	public $admin_name;
	public $admin_gender;
	public $admin_address;
	public $admin_phone;
	public $admin_image;
	public $admin_created_on;
	public $admin_updated_on;
	private $errors = [];

	public function getId()
	{
		return $this->admin_id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['admin_id'])) {
			$this->admin_id = trim($data['admin_id']);
		}
		if (isset($data['admin_email'])) {
			$this->admin_email = trim($data['admin_email']);
		}
		if (isset($data['admin_password'])) {
			$this->admin_password = trim($data['admin_password']);
		}
		if (isset($data['admin_name'])) {
			$this->admin_name = trim($data['admin_name']);
		}
		if (isset($data['admin_gender'])) {
			$this->admin_gender = trim($data['admin_gender']);
		}
		if (isset($data['admin_address'])) {
			$this->admin_address = trim($data['admin_address']);
		}
		if (isset($data['admin_phone'])) {
			$this->admin_phone = trim($data['admin_phone']);
		}
		if (isset($data['admin_image'])) {
			$this->admin_image = trim($data['admin_image']);
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
		$admins = [];
		$stmt = $this->db->prepare('select * from admin');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$admin = new admin($this->db);
			$admin->fillFromDB($row);
			$admins[] = $admin;
		}
		return $admins;
	}
	protected function fillFromDB(array $row)
	{
		[
			'admin_id' => $this->admin_id,
			'admin_email' => $this->admin_email,
			'admin_password' => $this->admin_password,
			'admin_name' => $this->admin_name,
			'admin_gender' => $this->admin_gender,
			'admin_address' => $this->admin_address,
			'admin_phone' => $this->admin_phone,
			'admin_image' => $this->admin_image,
			'admin_created_on' => $this->admin_created_on,
			'admin_updated_on' => $this->admin_updated_on //gan gia tri tu mang qua doi tuong Contact
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

	public function edit_admin()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update admin set ten = :ten,
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
	public function save_admin()
	{
		$result = false;

		$stmt = $this->db->prepare(
			'insert into admin (ten, ho, gt, created_at, updated_at)
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
	public function find($admin_email)
	{
		$stmt = $this->db->prepare('select * from admin where admin_email = :admin_email');
		$stmt->execute(['admin_email' => $admin_email]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function find_adimn_id($admin_id)
	{
		$stmt = $this->db->prepare('select * from admin where admin_id = :admin_id');
		$stmt->execute(['admin_id' => $admin_id]);
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
		$stmt = $this->db->prepare('delete from admin where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
