<?php
class GioHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getGioHangFromUser($id)
    {
        try {
            $sql = 'SELECT * FROM carts WHERE user_id = :user_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getDetailGioHang($cartId)
    {
        try {
            $sql = 'SELECT cart_items.id,
                cart_items.cart_id AS gio_hang_id,
                cart_items.product_id AS san_pham_id,
                cart_items.quantity AS so_luong,
                products.name AS ten_san_pham, products.image AS hinh_anh,
                products.price AS gia_san_pham, products.discount_price AS gia_khuyen_mai,
                products.quantity AS ton_kho_san_pham
            FROM cart_items
            INNER JOIN products ON cart_items.product_id = products.id
            WHERE cart_items.cart_id = :cart_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cartId]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function addGioHang($id)
    {
        try {
            $sql = 'INSERT INTO carts (user_id)VALUE (:user_id)';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $id]);

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function updateSoLuong($cartId, $productId, $so_luong)
    {
        try {
            $sql = 'UPDATE cart_items
            SET quantity = :quantity
            WHERE cart_id = :cart_id AND product_id = :product_id
            ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cartId, ':product_id' => $productId, ':quantity' => $so_luong]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }


    public function addDetailGioHang($cartId, $productId, $so_luong)
    {
        try {
            $sql = 'INSERT INTO cart_items (cart_id, product_id, quantity)
            VALUE (:cart_id, :product_id, :quantity)
            ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cartId, ':product_id' => $productId, ':quantity' => $so_luong]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function clearDetailGioHang($cartId)
    {
        try {
            $sql = 'DELETE FROM cart_items
            WHERE cart_id = :cart_id ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cartId]);

            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function clearGioHang($userId)
    {
        try {
            $cart = $this->getGioHangFromUser($userId);
            if ($cart) {
                $this->clearDetailGioHang($cart['id']);
            }
            $sql = 'DELETE FROM carts
            WHERE user_id = :user_id ';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            return true;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function xoaChiTietSanPham($cartId, $productId)
    {
        try {
            $sql = 'DELETE FROM cart_items
            WHERE cart_id = :cart_id AND product_id = :product_id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cart_id' => $cartId, ':product_id' => $productId]);

            return true;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            }
    }
    
}