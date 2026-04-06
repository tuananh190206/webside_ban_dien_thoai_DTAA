<?php
class SanPham {
    public $conn;

    public function __construct() {
        // Giả định hàm connectDB() đã được định nghĩa ở file global
        $this->conn = connectDB();
    }

    // Lấy danh sách tất cả sản phẩm và tên danh mục tương ứng
    public function getAllSanPham() {
        try {
            $sql = 'SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy chi tiết một sản phẩm theo ID
    public function getDetailSanPham($id) {
        try {
            $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id 
                    WHERE products.id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy danh sách ảnh phụ của sản phẩm
    public function getListAnhSanPham($id) {
        try {
            $sql = "SELECT * FROM product_images WHERE product_id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll(); 
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy danh sách bình luận của một sản phẩm
    public function getBinhLuanFormSanPham($id) {
        try {
            // Liên kết bảng reviews với products và users để lấy tên và ảnh đại diện
            $sql = "SELECT reviews.*, users.full_name, users.avatar
                    FROM reviews
                    INNER JOIN users ON reviews.user_id = users.id
                    WHERE reviews.product_id = :id AND reviews.status = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Lấy danh sách sản phẩm theo danh mục
    public function getListSanPhamDanhMuc($category_id) {
        try {
            $sql = 'SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id 
                    WHERE products.category_id = :category_id';

            $stmt = $this->conn->prepare($sql);
            // Sử dụng bindParam hoặc mảng execute để bảo mật hơn nối chuỗi trực tiếp
            $stmt->execute([':category_id' => $category_id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
?>