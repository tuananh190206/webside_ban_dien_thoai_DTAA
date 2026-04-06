<?php
class AdminVaiTroController {
    public $modelVaiTro;

    public function __construct() {
        $this->modelVaiTro = new AdminVaiTro();
    }

    public function listVaiTro() {
        $listRoles = $this->modelVaiTro->getAll();
        require_once './views/vaitro/listVaiTro.php';
    }

    public function formAddVaiTro() {
        require_once './views/vaitro/addVaiTro.php';
    }

    public function postAddVaiTro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            if ($this->modelVaiTro->insert($name)) {
                header("Location: " . BASE_URL_ADMIN . "?act=vai-tro");
                exit();
            }
        }
    }

    public function formEditVaiTro() {
        $id = $_GET['id_vai_tro'];
        $role = $this->modelVaiTro->getDetail($id);
        require_once './views/vaitro/editVaiTro.php';
    }

    public function postEditVaiTro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'] ?? '';
            if ($this->modelVaiTro->update($id, $name)) {
                header("Location: " . BASE_URL_ADMIN . "?act=vai-tro");
                exit();
            }
        }
    }

    public function deleteVaiTro() {
        $id = $_GET['id_vai_tro'];
        $this->modelVaiTro->delete($id);
        header("Location: " . BASE_URL_ADMIN . "?act=vai-tro");
        exit();
    }
}