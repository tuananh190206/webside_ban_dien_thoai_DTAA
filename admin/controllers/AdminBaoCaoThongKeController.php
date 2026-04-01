<?php
require_once __DIR__ . '/../models/AdminBaoCaoThongKe.php';
class AdminBaoCaoThongKeController{
    public $modelThongKe;
    public function __construct()
    {
        $this->modelThongKe = new AdminBaoCaoThongKe();

    }
    public function home(){
        require_once './views/home.php';
    }

    public function thongKeBaoCao()
    {
        $summary = $this->modelThongKe->getSummary();
        $recentOrders = $this->modelThongKe->getRecentOrders();
        $topProducts = $this->modelThongKe->getTopProducts();
    
        require_once './views/baocaothongke/index.php';
        deleteSessionError();
    }
}