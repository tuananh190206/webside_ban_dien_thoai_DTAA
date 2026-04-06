<?php
class AdminVaiTro {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

 public function getAll() {
        // Lấy danh sách người dùng kèm theo tên vai trò của họ
        $sql = "SELECT users.full_name, users.id as user_id, roles.name as ten_vai_tro, roles.id as role_id 
                FROM users 
                INNER JOIN roles ON users.role_id = roles.id 
                ORDER BY users.id DESC";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getDetail($id) {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insert($name) {
        $sql = "INSERT INTO roles (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name
        ]);
    }

    public function update($id, $name) {
        $sql = "UPDATE roles SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM roles WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}