<?php
class AdminSanPham {
    public $conn;

    public function __construct(){
        $this->conn = connectDB();
    }

    // Lấy danh sách tất cả sản phẩm kèm tên danh mục
    public function getAllSanPham(){
        try {
            $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    INNER JOIN categories ON products.category_id = categories.id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Thêm sản phẩm mới
    public function insertSanPham($name, $price, $quantity, $category_id, $status, $description, $image){
        try {
            $sql = "INSERT INTO products (name, price, quantity, category_id, status, description, image)
                    VALUES (:name, :price, :quantity, :category_id, :status, :description, :image)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':quantity' => $quantity,
                ':category_id' => $category_id,
                ':status' => $status,
                ':description' => $description,
                ':image' => $image
            ]);
            // lay id san pham vua them
            return $this->conn->lastInsertID();
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function insertAlbumAnhSanPham($san_pham_id,$link_hinh_anh){
        try {
            $sql = "INSERT INTO hinh_anh_san_phams(san_pham_id,link_hinh_anh)
            VALUES(:san_pham_id,:link_hinh_anh) ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':link_hinh_anh' => $link_hinh_anh,
                
            ]);
            // lay id san pham vua them
            return true;
        } catch(Exception $e) {
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
        $sql = "SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchAll(); // lấy danh sách ảnh nên dùng fetchAll()
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
public function updateSanPham($id,$name, $price, $quantity, $category_id, $status, $description, $image){
        try {
               $sql = "UPDATE products SET 
                    name = :name,
                    price = :price,
                    quantity = :quantity,
                    category_id = :category_id,
                    status = :status,
                    description = :description,
                    image = :image
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
           $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':quantity' => $quantity,
                ':category_id' => $category_id,
                ':status' => $status,
                ':description' => $description,
                ':image' => $image,

                ':id' => $id
            ]);

            
            // lay id san pham vua them
            return true;
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


//        public function getDetailAnhSanPham($id){
//     try {
//         $sql = "SELECT * FROM hinh_anh_san_phams WHERE id = :id";

//         $stmt = $this->conn->prepare($sql);
//         $stmt->execute([':id' => $id]);

//         return $stmt->fetch();
//     } catch (Exception $e) {
//         echo "Lỗi: " . $e->getMessage();
//     }
// }

// public function updateAnhSanPham($id,$new_file){
//         try {
//                $sql = "UPDATE san_phams SET 
//                     link_hinh_anh = :new_file,
                    
//                     WHERE id = :id";

//             $stmt = $this->conn->prepare($sql);
//            $stmt->execute([
//                 ':new_file' => $new_file,
//                 ':id' => $id,
//             ]);

            
//             // lay id san pham vua them
//             return true;
//         } catch(Exception $e) {
//             echo "Lỗi: " . $e->getMessage();
//         }
//     }

    //   public function destroyAnhSanPham($id){
    //         try{
    //             $sql="DELETE FROM hinh_anh_san_phams WHERE id= :id";

    //             $stmt=$this->conn->prepare($sql);

    //             $stmt->execute([
    //                 ':id'=>$id,
                    

    //             ]);

    //             return true;
    //         }catch(Exception $e){
    //             echo"Lỗi" .$e->getMessage();
    //         }
    //     }

        public function destroySanPham($id){
            try{
                $sql="DELETE FROM products WHERE id= :id";

                $stmt=$this->conn->prepare($sql);

                $stmt->execute([
                    ':id'=>$id,
                    

                ]);

                return true;
            }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
        }


         public function getBinhLuanFromKhachHang($id){
        try {
            $sql = "SELECT binh_luans.*, san_phams.ten_san_pham
                    FROM binh_luans
                    INNER JOIN san_phams ON binh_luans.san_pham_id = san_phams.id
                    WHERE binh_luans.tai_khoan_id = :id
                    ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$id]);   

            return $stmt->fetchAll();
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

       public function getDetailBinhLuan($id){
    try {
        $sql = "SELECT * FROM binh_luans WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch();
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

public function updateTrangThaiBinhLuan($id,$trang_thai){
        try {
               $sql = "UPDATE binh_luans SET 
                    trang_thai = :trang_thai
                    
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
           $stmt->execute([
                ':trang_thai' => $trang_thai,
                ':id' => $id
            ]);

            
            // lay id san pham vua them
            return true;
        } catch(Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
?>