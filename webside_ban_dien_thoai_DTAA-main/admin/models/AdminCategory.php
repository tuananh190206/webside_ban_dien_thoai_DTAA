<?php 
class AdminCategory{
    public $conn;
    public function __construct()
    {
        $this->conn=connectDB();
    }
    public function getAllCategory(){
        try{
            $sql="SELECT * FROM categories";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
             return $stmt->fetchAll();
        }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
    }
    public function insertCategory($name,$description){
        try{
            $slq="INSERT INTO categories (name,description)
            VALUES (:name,:description)";   
            $stmt=$this->conn->prepare($slq);
            $stmt->execute([
                ':name'=>$name,
                ':description'=>$description
            ]);
            return true;
        }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
    }
    public function getDetailCategory($id){
        try{
            $sql="SELECT * FROM categories WHERE id= :id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute([
                ':id'=>$id
            ]);
             return $stmt->fetch();
        }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
    }
    public function updateCategory($id,$name,$description){
        try{
            $sql="UPDATE categories SET name= :name,description= :description WHERE id= :id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute([
                ':id'=>$id,
                ':name'=>$name,
                ':description'=>$description
            ]);
             return true;
        }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
    }
    public function deleteCategory($id){
        try{
            $sql="DELETE FROM categories WHERE id= :id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute([
                ':id'=>$id
            ]);
             return true;
        }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
    }
      public function destroyCategory($id){
        try{
            $sql="DELETE FROM categories WHERE id= :id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute([
                ':id'=>$id,
            ]);
             return true;
        }catch(Exception $e){
                echo"Lỗi" .$e->getMessage();
            }
    }  
}