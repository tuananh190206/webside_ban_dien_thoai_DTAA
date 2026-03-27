<!-- header -->
<?php
  require './views/layout/header.php';
?>
  <!-- Navbar -->
<?php
  include './views/layout/navbar.php';
?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <?php
  include './views/layout/sidebar.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quản lý danh sách sản phẩm</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
 
            <div class="card card-primary">
              <div class="card-header default_cursor_land">
                <h3 class="card-title default_cursor_land">Thêm  sản phẩm</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="<?=BASE_URL_ADMIN .'?act=them-san-pham' ?>" method="POST" enctype="multipart/form-data">
                <div class="card-body default_cursor_land row">
                  <div class="form-group default_cursor_land col-12">
                    <label >Tên sản phẩm</label>
                    <input type="text" class="form-control" name="name"  placeholder="Nhập tên sản phẩm">
                    <?php if(isset($_SESSION['error']['name'])) { ?>
                        <p class="text-danger"><?= $_SESSION['error']['name'] ?></p>
                    <?php }?>
                  </div>
                  <div class="form-group col-6">
                    <label >Giá sản phẩm</label>
                    <input type="number" class="form-control" name="price"  placeholder="Nhập giá sản phẩm">
                    <?php if(isset($_SESSION['error']['price'])) { ?>
                        <p class="text-danger"><?= $_SESSION['error']['price'] ?></p>
                   <?php }?>
                  </div>
                  <!-- <div class="form-group col-6">
                    <label >Hình ảnh</label>
                    <input type="file" class="form-control" name="hinh_anh"  >
                    <?php if(isset($_SESSION['error']['hinh_anh'])) { ?>
                        <p class="text-danger"><?= $_SESSION['error']['hinh_anh'] ?></p>
                   <?php }?>
                  </div> -->
                  <!-- <div class="form-group col-6">
                    <label >Album ảnh</label>
                    <input type="file" class="form-control" name="img_array[]"  multiple  >
                   
                  </div> -->
                  <div class="form-group col-6">
                    <label >Số lượng</label>
                    <input type="number" class="form-control" name="quantity"  placeholder="Nhập số lượng">
                    <?php if(isset($_SESSION['error']['quantity'])) { ?>
                        <p class="text-danger"><?= $_SESSION['error']['quantity'] ?></p>
                   <?php }?>
                  </div>
                  <div class="form-group col-6">
                  <label>Danh mục</label>
                  <select class="form-control" name="category_id" id="exampleFormControlSelect1">
                  <option selected disabled>Chọn danh mục sản phẩm</option>
                  <?php foreach($listDanhMuc as $Category): ?>
                    <option value="<?= $Category['id'] ?>"><?= $Category['name'] ?></option>
                  <?php endforeach; ?>
                 </select>
                  <?php if (isset($_SESSION['error']['category_id'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['category_id'] ?></p>
                 <?php } ?>
                 </div>
                  <div class="form-group col-12">
                  <label>Trạng thái</label>
                  <select class="form-control" name="status" id="exampleFormControlSelect1">
                  <option selected disabled>Chọn trạng thái</option>
                  <option value="1">Còn hàng</option>
                  <option value="2">Hết hàng</option>
                  
                  
                 </select>
                  <?php if (isset($_SESSION['error']['status'])) { ?>
                  <p class="text-danger"><?= $_SESSION['error']['status'] ?></p>
                 <?php } ?>
                 </div>

                  <div class="form-group col-12">
                  <label>Mô tả</label>
                  <!-- <textarea name="discription" id="" class="form-control" placeholder="Nhập mô tả"></textarea> -->
                  <!-- <textarea id="description" name="description" class="form-control" rows="4"><?= $sanPham['description'] ?></textarea> -->
                  <textarea id="description" name="description" class="form-control" rows="4" placeholder="Nhập mô tả"></textarea>
                  <?php if (isset($_SESSION['error']['description'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['description'] ?></p>
                  <?php } ?>

                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer default_cursor_land">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- footer -->
    <?php
    include './views/layout/footer.php';
    ?>
  <!-- endfooter -->
<!-- Page specific script -->
<!-- Code injected by live-server -->

</body>
</html>
