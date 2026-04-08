<?php

class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    /** Chỉ khách hàng (role_id = 2) — giữ cho code cũ nếu cần */
    public function checkLogin($email, $password)
    {
        $r = $this->checkLoginUnified($email, $password);
        if (is_array($r) && !empty($r['ok']) && (int) $r['role_id'] === 2) {
            return $r['email'];
        }
        if (is_array($r) && !empty($r['ok']) && (int) $r['role_id'] === 1) {
            return 'Tài khoản không có quyền truy cập';
        }
        return is_string($r) ? $r : 'Tài khoản hoặc mật khẩu không chính xác';
    }

    /**
     * Đăng nhập một cổng: admin (1) hoặc khách (2).
     * @return array{ok:true,id:int,role_id:int,email:string,full_name:string,phone?:string}|string|false
     */
    public function checkLoginUnified($identifier, $password)
    {
        try {
            $id = trim((string) $identifier);
            if ($id === '' || $password === '') {
                return 'Vui lòng nhập đủ thông tin.';
            }

            $user = $this->getTaiKhoanByIdentifier($id);
            if (!$user) {
                return 'Tài khoản hoặc mật khẩu không chính xác';
            }

            $stored = $user['password'] ?? '';
            $passOk = false;
            if (is_string($stored) && strlen($stored) >= 60 && strncmp($stored, '$2', 2) === 0) {
                $passOk = password_verify($password, $stored);
            } else {
                $passOk = hash_equals((string) $stored, (string) $password);
            }
            if (!$passOk) {
                return 'Tài khoản hoặc mật khẩu không chính xác';
            }

            $roleId = (int) ($user['role_id'] ?? 0);
            if ($roleId !== 1 && $roleId !== 2) {
                return 'Tài khoản không có quyền truy cập';
            }
            if ((int) ($user['status'] ?? 0) !== 1) {
                return 'Tài khoản đang bị khóa';
            }

            return [
                'ok' => true,
                'id' => (int) $user['id'],
                'role_id' => $roleId,
                'email' => (string) ($user['email'] ?? ''),
                'full_name' => (string) ($user['full_name'] ?? ''),
                'phone' => (string) ($user['phone'] ?? ''),
            ];
        } catch (Exception $e) {
            return 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }

    public function getTaiKhoanByIdentifier(string $identifier)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :e LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':e' => $identifier]);
            $user = $stmt->fetch();
            if ($user) {
                return $user;
            }
            $phone = preg_replace('/\s+/', '', $identifier);
            if ($phone === '') {
                return false;
            }
            $sql2 = "SELECT * FROM users WHERE REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '.', '') = :p LIMIT 1";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([':p' => $phone]);
            return $stmt2->fetch() ?: false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getTaiKhoanById(int $id)
    {
        try {
            $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch() ?: false;
        } catch (Exception $e) {
            return false;
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

    /** Đăng ký tài khoản (role_id: 1 admin, 2 khách) */
    public function insertTaiKhoan($full_name, $email, $phone, $address, $password, $role_id, $status)
    {
        try {
            $addr = $address !== '' ? $address : 'Hà Nội';
            $sql = 'INSERT INTO users (full_name, email, phone, address, password, role_id, status)
                    VALUES (:full_name, :email, :phone, :address, :password, :role_id, :status)';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':full_name' => $full_name,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $addr,
                ':password' => $password,
                ':role_id' => (int) $role_id,
                ':status' => (int) $status,
            ]);
        } catch (Exception $e) {
            return false;
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
