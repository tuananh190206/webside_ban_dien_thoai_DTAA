<?php
class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

      public function checkLogin($email, $mat_khau){
    try {
        $sql = "SELECT * FROM tai_khoans WHERE email = :email";
        $stmt = $this->conn->prepare(query: $sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && ($mat_khau==$user['mat_khau'])) {
            if ($user['chuc_vu_id'] == 2) {
                if ($user['trang_thai'] == 1) {
                    return $user['email']; // Trường hợp đăng nhập thành công
                } else {
                    return "Tài khoản bị cấm";
                }
            } else {
                return "Tài khoản không có quyền đăng nhập";
            }
        } else {
            return "Bạn nhập sai thông tin mật khẩu hoặc tài khoản";
        }

    } catch (Exception $e) {
        echo "lỗi: " . $e->getMessage();
        return false;
    }
}
public function getTaiKhoanFormEmail($email)
    {
        try {
            $sql = "SELECT * FROM tai_khoans WHERE email= :email";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':email' => $email,

            ]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

}