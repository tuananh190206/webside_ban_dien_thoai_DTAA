<?php
class SanPham {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

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

    public function getBinhLuanFormSanPham($id) {
        try {
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

    public function getListSanPhamDanhMuc($category_id) {
        try {
            $sql = 'SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id 
                    WHERE products.category_id = :category_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':category_id' => $category_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // =========================
    // ADMIN UPDATE KHO
    // =========================
    public function updateSoLuongVaTrangThai($productId, $quantity)
    {
        $sql = "UPDATE products
                SET quantity = :quantity
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $productId
        ]);

        $this->capNhatTrangThai($productId);
    }

    // =========================
    // TÌM KIẾM SẢN PHẨM
    // =========================
    public function timKiemSanPham($keyword) {
        $keyword = trim($keyword);
        if (empty($keyword)) {
            return [];
        }

        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories ON products.category_id = categories.id
                WHERE products.name LIKE :keyword
                   OR products.description LIKE :keyword
                   OR categories.name LIKE :keyword
                ORDER BY products.name ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll();
    }

    // Tìm kiếm theo danh mục
    public function timKiemTheoDanhMuc($category_id) {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories ON products.category_id = categories.id
                WHERE products.category_id = :category_id
                ORDER BY products.name ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':category_id' => $category_id]);
        return $stmt->fetchAll();
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->conn->query($sql)->fetchAll();
    }
}
