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
          <h1>Quản lý tài khoản khách hàng</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <div class="card card-dark">
            <div class="card-header default_cursor_land">
              <h3 class="card-title default_cursor_land">Sửa thông tin tài khoản Khách hàng : <?= $khachHang['ho_ten']; ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= BASE_URL_ADMIN . '?act=sua-khach-hang' ?>" method="POST">
              <input type="hidden" name="khach_hang_id" value="<?= $khachHang['id'] ?>">
              <div class="card-body default_cursor_land">
                <div class="form-group">
                  <label>Họ tên</label>
                  <input type="text" class="form-control" name="ho_ten" value="<?= $khachHang['ho_ten'] ?>"
                    placeholder="Nhập họ tên">
                  <?php if (isset($_SESSION['error']['ho_ten'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['ho_ten'] ?></p>
                  <?php } ?>
                </div>


                <div class="form-group default_cursor_land col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" value="<?= $khachHang['email'] ?>"
                    placeholder="Nhập email">
                  <?php if (isset($_SESSION['error']['email'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['email'] ?></p>
                  <?php } ?>
                </div>


                <div class="form-group default_cursor_land col-12">
                  <label>Số điện thoại</label>
                  <input type="text" class="form-control" name="so_dien_thoai" value="<?= $khachHang['so_dien_thoai'] ?>"
                    placeholder="Nhập số điện thoại">
                  <?php if (isset($_SESSION['error']['so_dien_thoai'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['so_dien_thoai'] ?></p>
                  <?php } ?>
                </div>

                <div class="form-group default_cursor_land col-12">
                  <label>Ngày sinh</label>
                  <input type="date" class="form-control" name="ngay_sinh" value="<?= $khachHang['ngay_sinh'] ?>"
                    placeholder="Nhập ngày sinh">
                  <?php if (isset($_SESSION['error']['ngay_sinh'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['ngay_sinh'] ?></p>
                  <?php } ?>
                </div>

                <div class="form-group default_cursor_land col-12">
                  <label for="gioi_tinh">Giới tính</label>
                  <select id="gioi_tinh" name="gioi_tinh" class="form-control custom-select">
                    <option <?= $khachHang['gioi_tinh'] == 1 ? 'selected' : '' ?> value="1">Nam</option>
                    <option <?= $khachHang['gioi_tinh'] !== 1 ? 'selected' : '' ?> value="2">Nữ</option>
                  </select>
                </div>

                <div class="form-group default_cursor_land col-12">
                  <label>Địa chỉ</label>
                  <input type="text" class="form-control" name="dia_chi" value="<?= $khachHang['dia_chi'] ?>"
                    placeholder="Nhập số điện thoại">
                  <?php if (isset($_SESSION['error']['dia_chi'])) { ?>
                    <p class="text-danger"><?= $_SESSION['error']['dia_chi'] ?></p>
                  <?php } ?>
                </div>


                <div class="form-group">
                  <label for="trang_thai">Trạng thái tài khoản</label>
                  <select id="trang_thai" name="trang_thai" class="form-control custom-select">
                    <option <?= $khachHang['trang_thai'] == 1 ? 'selected' : '' ?> value="1"><i
                        class="fa-solid fa-earth-americas"></i> Online</option>
                    <option <?= $khachHang['trang_thai'] !== 1 ? 'selected' : '' ?> value="2">Offline</option>
                  </select>
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