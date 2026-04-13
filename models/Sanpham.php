<?php

class SanPham {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // =========================
    // LẤY SẢN PHẨM
    // =========================
    public function getAllSanPham() {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories ON products.category_id = categories.id";
        return $this->conn->query($sql)->fetchAll();
    }

    public function getDetailSanPham($id) {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories ON products.category_id = categories.id
                WHERE products.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getListAnhSanPham($id) {
        $sql = "SELECT * FROM product_images WHERE product_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll();
    }

    public function getBinhLuanFormSanPham($id) {
        $sql = "SELECT reviews.*, users.full_name, users.avatar
                FROM reviews
                INNER JOIN users ON users.id = reviews.user_id
                WHERE reviews.product_id = :id AND reviews.status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll();
    }

    public function getListSanPhamDanhMuc($category_id) {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories ON categories.id = products.category_id
                WHERE products.category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':category_id' => $category_id]);
        return $stmt->fetchAll();
    }

    // =========================
    // HÀM CHUẨN TRẠNG THÁI
    // =========================
  public function capNhatTrangThai($productId)
{
    $sql = "UPDATE products
            SET status = CASE
                WHEN quantity > 0 THEN 1 -- Dùng số 1 thay vì 'in_stock'
                ELSE 0                   -- Dùng số 0 thay vì 'out_of_stock'
            END
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $productId]);
}

    // =========================
    // TRỪ KHO (ĐẶT HÀNG)
    // =========================
    public function truSoLuongKho($productId, $quantity)
    {
        $sql = "UPDATE products
                SET quantity = quantity - :quantity
                WHERE id = :id AND quantity >= :quantity";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $productId
        ]);

        if ($stmt->rowCount() == 0) {
            return false; // không đủ hàng
        }

        $this->capNhatTrangThai($productId);
        return true;
    }

    // =========================
    // CỘNG KHO (HUỶ ĐƠN)
    // =========================
  public function congSoLuongKho($productId, $quantity)
{
    try {
        $sql = "UPDATE products SET quantity = quantity + :quantity WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $productId
        ]);
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
<<<<<<< ducdat
public function getVariantsByProductId($product_id) {
    // Truy vấn tất cả dung lượng, màu sắc, giá từ bảng product_variants
    $sql = "SELECT id, capacity, color, price, discount_price, stock, image 
            FROM product_variants 
            WHERE product_id = :product_id 
            ORDER BY price ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':product_id' => $product_id]);
    return $stmt->fetchAll();
}
=======

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
>>>>>>> main
}
?>