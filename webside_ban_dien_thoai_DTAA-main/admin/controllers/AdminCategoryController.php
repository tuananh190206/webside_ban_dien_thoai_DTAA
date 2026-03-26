<?php 
class AdminCategoryController {
    public $modelCategory;
    public function __construct()
    {
       $this->modelCategory= new AdminCategory();
    }
    public function listCategory(){
        $listCategory=$this->modelCategory->getAllCategory();
        require_once './views/category/listCategory.php';
    }
    public function formAddCategory(){
        require_once './views/category/addCategory.php';
    }
    public function postAddCategory(){
      //ham nay dung de xu ly them du lieu
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name=$_POST['name'];
        $description=$_POST['description'];
        $errors=[];
        if(empty($name)){
            $errors['name']= 'Tên danh mục không được để trống';
        }
        if(empty($errors)){
            $this->modelCategory->insertCategory($name, $description);
            header("Location:" .BASE_URL_ADMIN .'?act=category');
            exit();
        }else{
          require_once './views/category/addCategory.php';
        }
      }
    }
    public function formEditCategory(){
        $id=$_GET['id_category'];
        $category=$this->modelCategory->getDetailCategory($id);
        if($category){
            require_once './views/category/editCategory.php';
        }else{
            header("Location:" .BASE_URL_ADMIN .'?act=category');
            exit(); 
        }
    }
   public function postEditCategory(){
      //ham nay dung de xu ly them du lieu
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $description=$_POST['description'];
        $errors=[];
        if(empty($name)){
            $errors['name']= 'Tên danh mục không được để trống';
        }
        if(empty($errors)){
            $this->modelCategory->updateCategory($id,$name, $description);
            header("Location:" .BASE_URL_ADMIN .'?act=category');
            exit();
        }else{
          $category=['id'=>$id,'name'=>$name,'description'=>$description];
          require_once './views/category/editCategory.php';
        }
      }
    }
    public function deleteCategory(){
        $id=$_GET['id_category'];
        $category=$this->modelCategory->getDetailCategory($id);
        if($category){
            $this->modelCategory->destroyCategory($id);
        }
        header("Location:" .BASE_URL_ADMIN .'?act=category');
        exit();
    }

    
}
    
   
