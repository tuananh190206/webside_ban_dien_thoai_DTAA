<?php
class DonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function addDonHang($userId, $receiverName, $receiverEmail, $receiverPhone, $receiverAddress, $note, $totalAmount, $paymentMethodId, $orderDate, $orderCode, $statusId)
    {
        try {
            $sql = 'INSERT INTO orders (user_id,receiver_name, receiver_email, receiver_phone, receiver_address, note, total_amount, payment_method_id, order_date, order_code, status_id)
            VALUES (:user_id, :receiver_name, :receiver_email, :receiver_phone, :receiver_address, :note, :total_amount, :payment_method_id, :order_date, :order_code, :status_id)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(
                [':user_id' => $userId,
                    ':receiver_name' => $receiverName,
                    ':receiver_email' => $receiverEmail,
                    ':receiver_phone' => $receiverPhone,
                    ':receiver_address' => $receiverAddress,
                    ':note' => $note,
                    ':total_amount' => $totalAmount,
                    ':payment_method_id' => $paymentMethodId,
                    ':order_date' => $orderDate,
                    ':order_code' => $orderCode,
                    ':status_id' => $statusId,
                ]
            );

            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function addChiTietDonHang($orderId, $productId, $price, $quantity, $totalPrice)
    {
        try {
            $sql = "INSERT INTO order_items (order_id, product_id, price, quantity, total_price)
            VALUE (:order_id, :product_id, :price, :quantity, :total_price)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':order_id' => $orderId,
                ':product_id' => $productId,
                ':price' => $price,
                ':quantity' => $quantity,
                ':total_price' => $totalPrice
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getDonHangFromUser($userId){
        try{
            $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC, id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Lỗi". $e->getMessage();
        }
    }
    public function getTrangThaiDonHang()
    {
        try {
            $sql = "SELECT * FROM order_statuses";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getPhuongThucThanhToan()
    {
        try {
            $sql = "SELECT * FROM payment_methods";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getDonHangById($donHangId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$donHangId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

    public function getDonHangByIdAndUser($donHangId,$userId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE id = :id AND user_id=:user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$donHangId,':user_id'=>$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function updateTrangThaiDonHang($donHangId,$statusId)
    {
        try {
            $sql = "UPDATE orders SET status_id = :status_id WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id'=>$donHangId,':status_id'=>$statusId]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    public function getChiTietDonHangByDonHangId($orderId)
    {
        try {
            $sql = 'SELECT order_items.id, order_items.order_id, order_items.product_id,
                order_items.price AS don_gia, order_items.quantity AS so_luong, order_items.total_price AS thanh_tien,
                products.name AS ten_san_pham, products.image AS hinh_anh
            FROM order_items
            INNER JOIN products ON order_items.product_id = products.id
            WHERE order_items.order_id = :order_id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':order_id' => $orderId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }

}