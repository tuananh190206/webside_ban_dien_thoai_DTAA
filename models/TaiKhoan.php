<?php

class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function checkLogin($email, $password)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if (!$user) {
                return 'Tài khoản hoặc mật khẩu không chính xác';
            }

            $passOk = false;
            $stored = $user['password'] ?? '';
            if (is_string($stored) && strlen($stored) >= 60 && strncmp($stored, '$2', 2) === 0) {
                $passOk = password_verify($password, $stored);
            } else {
                $passOk = hash_equals((string) $stored, (string) $password);
            }

            if (!$passOk) {
                return 'Tài khoản hoặc mật khẩu không chính xác';
            }

            if ((int) ($user['role_id'] ?? 0) !== 2) {
                return 'Tài khoản không có quyền truy cập';
            }

            if ((int) ($user['status'] ?? 0) !== 1) {
                return 'Tài khoản đang bị khóa';
            }

            return $user['email'];
        } catch (Exception $e) {
            return 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }

    public function getTaiKhoanFormEmail($email)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function capNhatThongTinKhachHang($id, $full_name, $phone, $address)
    {
        try {
            $sql = 'UPDATE users SET full_name = :full_name, phone = :phone, address = :address WHERE id = :id AND role_id = 2';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':full_name' => $full_name,
                ':phone' => $phone,
                ':address' => $address,
                ':id' => $id,
            ]);
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }
}
