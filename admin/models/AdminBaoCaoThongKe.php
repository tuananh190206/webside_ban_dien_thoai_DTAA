<?php
class AdminBaoCaoThongKe
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    private function scalar($sql,$params= [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    public function getSummary()
    {
        $data= [
            'tong_san_pham'=>0,
            'tong_don_hang'=>0,
            'tong_khach_hang'=>0,
            'doanh_thu'=>0,
        ];
        try{
            $data['tong_san_pham'] =(int) $this->scalar("SELECT COUNT(*) FROM products");
        }catch(Exception $e)
        {

        }
        try{
            $data['tong_don_hang'] =(int) $this->scalar("SELECT COUNT(*) FROM orders");
        }catch(Exception $e)
        {

        }
        
        try{
            $data['tong_khach_hang'] =(int) $this->scalar("SELECT COUNT(*) FROM users");
        }catch(Exception $e)
        {
            try{
                $data['tong_khach_hang'] =(int) $this->scalar("SELECT COUNT(*) FROM tai_khoans WHERE chuc_vu_id = 2");
            }catch(Exception $e2)
            {
            }
        }
        
        try{
            $data['doanh_thu'] =(float) $this->scalar("SELECT COALESCE(SUM(total_amount), 0) FROM orders");
        }catch(Exception $e)
        {
        }

        return $data;
    }

    public function getRecentOrders($limit = 8)
    {
        $baseSelect = "SELECT o.id,
                              o.order_date,
                              o.total_amount,
                              os.name AS ten_trang_thai,
                              COALESCE(o.receiver_name,u.full_name, 'N/A') AS ten_khach_hang
                              FROM orders o
                              LEFT JOIN users u ON o.user_id = u.id
                              ORDER BY o.order_date DESC
                              LIMIT :limit";
        
        try {
            $sql = str_replace('FROM orders o', 'FROM orders o INNER JOIN order_statuses os ON o.status_id = os.id', $baseSelect);
            $stmt= $this->conn->prepare($sql);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            try{
                $sql2 = str_replace('FROM orders o', 'FROM orders o INNER JOIN order_statuses os ON o.order_status_id = os.id', $baseSelect);
                $stmt2 = $this->conn->prepare($sql2);
                $stmt2->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
                $stmt2->execute();
                return $stmt2->fetchAll();

            }catch (Exception $e2)
            {
                return [];
            }
        }
    }

    public function getTopProducts($limit = 8)
    {
        try{
            $sql="SELECT p.id,
                         p.name,
                         p.image,
                         COALESCE(SUM(oi.quantity),0) AS so_luong_ban
                     FROM order_items oi
                    INNER JOIN products p ON oi.product_id = p.id
                    GROUP BY p.id, p.name, p.image
                    ORDER BY so_luong_ban DESC
                    LIMIT :limit"; 
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
        }
    }
   
