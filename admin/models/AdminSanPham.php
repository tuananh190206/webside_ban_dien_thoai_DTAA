<?php
class AdminSanPham
{
    public $conn;

    public function __construct()
    {
        // Giả định hàm connectDB() đã được định nghĩa trong hệ thống của bạn
        $this->conn = connectDB();
    }

    // Lấy danh sách sản phẩm kèm tên danh mục
    public function getAllSanPham()
    {
        try {
            $sql = "SELECT products.*, categories.name as ten_danh_muc
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Thêm sản phẩm mới
    public function insertSanPham($name, $price, $discount_price, $quantity, $import_date, $category_id, $status, $description, $image)
    {
        try {
            $sql = "INSERT INTO products (name, price, discount_price, quantity, import_date, category_id, status, description, image)
                    VALUES (:name, :price, :discount_price, :quantity, :import_date, :category_id, :status, :description, :image)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':discount_price' => $discount_price,
                ':quantity' => $quantity,
                ':import_date' => $import_date,
                ':category_id' => $category_id,
                ':status' => $status,
                ':description' => $description,
                ':image' => $image
            ]);
            // Lấy id sản phẩm vừa thêm
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Thêm ảnh vào album ảnh sản phẩm
    public function insertAlbumAnhSanPham($product_id, $image_url)
    {
        try {
            $sql = "INSERT INTO product_images (product_id, image_url)
                    VALUES (:product_id, :image_url)";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':product_id' => $product_id,
                ':image_url' => $image_url,
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function insertProductVariant($product_id, $capacity, $color, $price, $discount_price, $stock, $image)
    {
        try {
            $sql = "INSERT INTO product_variants (product_id, capacity, color, price, discount_price, stock, image)
                    VALUES (:product_id, :capacity, :color, :price, :discount_price, :stock, :image)";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':product_id' => $product_id,
                ':capacity' => $capacity,
                ':color' => $color,
                ':price' => $price,
                ':discount_price' => $discount_price,
                ':stock' => $stock,
                ':image' => $image,
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function getDetailSanPham($id)
    {
        try {
            $sql = "SELECT products.*, categories.name as ten_danh_muc
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

    public function getListAnhSanPham($product_id)
    {
        try {
            $sql = "SELECT * FROM product_images WHERE product_id = :product_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function updateSanPham($id, $name, $price, $discount_price, $quantity, $import_date, $category_id, $status, $description, $image)
    {
        try {
            $sql = "UPDATE products SET 
                        name = :name,
                        price = :price,
                        discount_price = :discount_price,
                        quantity = :quantity,
                        import_date = :import_date,
                        category_id = :category_id,
                        status = :status,
                        description = :description,
                        image = :image
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':discount_price' => $discount_price,
                ':quantity' => $quantity,
                ':import_date' => $import_date,
                ':category_id' => $category_id,
                ':status' => $status,
                ':description' => $description,
                ':image' => $image,
                ':id' => $id
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getDetailAnhSanPham($id)
    {
        try {
            $sql = "SELECT * FROM product_images WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function updateAnhSanPham($id, $new_file)
    {
        try {
            $sql = "UPDATE product_images SET image_url = :new_file WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':new_file' => $new_file,
                ':id' => $id,
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function destroyAnhSanPham($id)
    {
        try {
            $sql = "DELETE FROM product_images WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function destroySanPham($id)
    {
        try {
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getProductVariants($product_id)
    {
        try {
            $sql = "SELECT * FROM product_variants WHERE product_id = :product_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getDetailProductVariant($id)
    {
        try {
            $sql = "SELECT * FROM product_variants WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function updateProductVariant($id, $capacity, $color, $price, $discount_price, $stock, $image)
    {
        try {
            $sql = "UPDATE product_variants SET 
                        capacity = :capacity,
                        color = :color,
                        price = :price,
                        discount_price = :discount_price,
                        stock = :stock,
                        image = :image
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':capacity' => $capacity,
                ':color' => $color,
                ':price' => $price,
                ':discount_price' => $discount_price,
                ':stock' => $stock,
                ':image' => $image,
                ':id' => $id
            ]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function destroyProductVariant($id)
    {
        try {
            $sql = "DELETE FROM product_variants WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
?>