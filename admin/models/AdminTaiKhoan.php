<?php

class AdminTaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Lấy danh sách tài khoản theo role_id (1: Admin, 2: Khách hàng)
    public function getAllTaiKhoan($role_id)
    {
        try {
            $sql = "SELECT * FROM users WHERE role_id = :role_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':role_id' => $role_id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 2. Thêm mới tài khoản quản trị
    public function insertTaiKhoan($full_name, $email, $password, $role_id)
    {
        try {
            $sql = 'INSERT INTO users (full_name, email, password, role_id)
                    VALUES (:full_name, :email, :password, :role_id)';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':password'  => $password,
                ':role_id'   => $role_id
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 3. Lấy chi tiết một tài khoản
    public function getDetailTaiKhoan($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 4. Cập nhật tài khoản quản trị (Rút gọn)
    public function updateTaiKhoan($id, $full_name, $email, $phone, $status)
    {
        try {
            $sql = "UPDATE users SET 
                    full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    status = :status
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':phone'     => $phone,
                ':status'    => $status,
                ':id'        => $id,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 5. Cập nhật chi tiết khách hàng
    public function updateKhachHang($id, $full_name, $email, $phone, $birthday, $gender, $address, $status)
    {
        try {
            $sql = "UPDATE users SET 
                    full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    birthday = :birthday,
                    gender = :gender,
                    address = :address,
                    status = :status
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':full_name' => $full_name,
                ':email'     => $email,
                ':phone'     => $phone,
                ':birthday'  => $birthday,
                ':gender'    => $gender,
                ':address'   => $address,
                ':status'    => $status,
                ':id'        => $id,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 6. Reset mật khẩu
    public function resetPassword($id, $password)
    {
        try {
            $sql = "UPDATE users SET password = :password WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':password' => $password,
                ':id'       => $id,
            ]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // 7. Kiểm tra đăng nhập
    public function checkLogin($email, $password) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            // Lưu ý: Nếu bạn dùng password_hash trong DB thì dùng password_verify
            // Nếu trong DB là text thuần như file SQL bạn gửi ('12345') thì so sánh trực tiếp ==
            if ($user && $password == $user['password']) {
                if ($user['status'] == 1) {
                    return $user; // Trả về mảng thông tin user
                } else {
                    return "Tài khoản của bạn đã bị khóa.";
                }
            } else {
                return "Email hoặc mật khẩu không chính xác.";
            }
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // 8. Lấy thông tin tài khoản bằng Email
    public function getTaiKhoanFromEmail($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}