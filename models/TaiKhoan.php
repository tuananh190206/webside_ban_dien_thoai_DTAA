<?php

class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    /** Chuẩn hóa bản ghi `users` để view/controller cũ dùng ho_ten, chuc_vu_id, ... */
    public static function chuanHoaBanGhiUser(?array $row): ?array
    {
        if (!$row) {
            return null;
        }
        $row['ho_ten'] = $row['full_name'] ?? $row['ho_ten'] ?? '';
        $row['so_dien_thoai'] = $row['phone'] ?? $row['so_dien_thoai'] ?? '';
        $row['dia_chi'] = $row['address'] ?? $row['dia_chi'] ?? '';
        $row['chuc_vu_id'] = (int) ($row['role_id'] ?? $row['chuc_vu_id'] ?? 0);

        return $row;
    }

    public function checkLogin($email, $matKhau)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if (!$user) {
                return 'Bạn nhập sai thông tin mật khẩu hoặc tài khoản';
            }

            $passOk = false;
            $stored = $user['password'] ?? '';
            if (is_string($stored) && strlen($stored) >= 60 && strncmp($stored, '$2', 2) === 0) {
                $passOk = password_verify($matKhau, $stored);
            } else {
                $passOk = hash_equals((string) $stored, (string) $matKhau);
            }

            if (!$passOk) {
                return 'Bạn nhập sai thông tin mật khẩu hoặc tài khoản';
            }

            if ((int) ($user['role_id'] ?? 0) !== 2) {
                return 'Tài khoản không có quyền đăng nhập (chỉ khách hàng)';
            }

            if ((int) ($user['status'] ?? 0) !== 1) {
                return 'Tài khoản bị cấm';
            }

            return $user['email'];
        } catch (Exception $e) {
            echo 'lỗi: ' . $e->getMessage();

            return false;
        }
    }

    public function getTaiKhoanFormEmail($email)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch();

            return self::chuanHoaBanGhiUser($row ?: null);
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }

    public function capNhatThongTinKhachHang($id, $ho_ten, $so_dien_thoai, $dia_chi)
    {
        try {
            $sql = 'UPDATE users SET full_name = :full_name, phone = :phone, address = :address WHERE id = :id AND role_id = 2';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':full_name' => $ho_ten,
                ':phone' => $so_dien_thoai,
                ':address' => $dia_chi,
                ':id' => $id,
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();

            return false;
        }
    }
}
