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

     public function getDetailSanPham($id){
    try {
        $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id WHERE products.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

public function getListAnhSanPham($id){
    try {
        $sql = "SELECT * FROM hinh_anh_products WHERE product_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchAll(); // lấy danh sách ảnh nên dùng fetchAll()
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
 public function getBinhLuanFormSanPham($id){
        try {
            $sql = "SELECT binh_luans.*, products.name_product, tai_khoans.anh_dai_dien
        FROM binh_luans
        INNER JOIN products ON binh_luans.product_id = products.id
        INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
        WHERE binh_luans.tai_khoan_id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);

            return $stmt->fetchAll();
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getListSanPhamDanhMuc($categorie_id) {
        try {
            $sql = 'SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id 
                     WHERE products.category_id = ' . $categorie_id;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}

?>