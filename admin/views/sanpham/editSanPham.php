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
        <div class="col-sm-11">
          <h1>Sửa thông tin sản phẩm: <?= $sanPham['name'] ?></h1>
        </div>
        <div class="col-sm-1">
          <a href="<?= BASE_URL_ADMIN . '?act=san-pham' ?>" class="btn btn-secondary">Quay lại</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <div class="row">
    <div class="col-md-8">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Thông tin sản phẩm</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <form action="<?= BASE_URL_ADMIN . '?act=sua-san-pham' ?>" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <input type="hidden" name="id" value="<?= $sanPham['id'] ?>">
              <label for="name">Tên sản phẩm</label>
              <input type="text" id="name" name="name" class="form-control"
                value="<?= $sanPham['name'] ?>">
              <?php if (isset($_SESSION['error']['name'])) { ?>
                <p class="text-danger"><?= $_SESSION['error']['name'] ?></p>
              <?php } ?>
            </div>
            <div class="form-group">
              <label for="price">Giá sản phẩm</label>
              <input type="text" id="price" name="price" class="form-control"
                value="<?= $sanPham['price'] ?>">
            </div>
            <!-- <div class="form-group">
              <label for="hinh_anh">Hình ảnh</label>
              <input type="file" id="hinh_anh" name="hinh_anh" class="form-control">
            </div> -->
            <div class="form-group">
              <label for="quantity">Số lượng</label>
              <input type="number" id="quantity" name="quantity" class="form-control"
                value="<?= $sanPham['quantity'] ?>">
            </div>
            <div class="form-group">
              <label for="category_id">Danh mục sản phẩm</label>
              <select id="category_id" name="category_id" class="form-control custom-select">
                <?php foreach ($listDanhMuc as $Category): ?>
                  <option <?= $Category['id'] == $sanPham['category_id'] ? 'selected' : '' ?> value="<?= $Category['id'] ?>">
                    <?= $Category['name'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="status">Trạng thái sản phẩm</label>
              <select id="status" name="status" class="form-control custom-select">

                <option <?= $sanPham['status'] == 1 ? 'selected' : '' ?> value="1">Còn bán</option>
                <option <?= $sanPham['status'] == 2 ? 'selected' : '' ?> value="2">Dừng bán</option>

              </select>
            </div>
            <div class="form-group">
              <label for="description">Mô tả</label>
              <textarea id="description" name="description" class="form-control" rows="4"><?= $sanPham['description'] ?></textarea>
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary ">Sửa thông tin</button>
          </div>
      </div>
      </form>
      <!-- /.card -->
    </div>
    <!-- <div class="col-md-4">
       <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">Album ảnh</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div> -->
        <!-- <div class="card-body p-0">
          <form action="<?= BASE_URL_ADMIN . '?act=sua-album-anh-san-pham' ?>" method="post"
            enctype="multipart/form-data">
            <div class="table-responsive">
              <table id="faqs" class="table table-hover">
                <thead>
                  <tr>
                    <th>Ảnh</th>
                    <th>File</th>
                    <th>
                      <div class="text-center"><button onclick="addfaqs();" type="button" class="badge badge-success"><i
                            class="fa fa-plus"></i>Thêm</button></div>
                    </th>

                  </tr>
                </thead>
                <tbody>
                  <input type="hidden" name="id" value="<?= $sanPham['id'] ?>">
                  <input type="hidden" id="img_delete" name="img_delete">
                  <?php foreach ($listAnhSanPham as $key => $value): ?>
                    <tr id="faqs-row-<?= $key ?>">
                      <input type="hidden" name="current_img_ids[]" value="<?=$value['id']?>">
                      <td><img src="<?= BASE_URL . $value['link_hinh_anh']?>" style="width: 70px; height: 70px;" alt=""></td>
                      <td><input type="file" name="img_array[]" class="form-control"></td>
                      <td class="mt-10"><button class="badge badge-danger" type="button" onclick="removeRow(<?= $key?>, <?=$value['id']?>)"><i class="fa fa-trash"></i> Delete</button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

        </div> -->
        <!-- /.card-body -->
        <!-- <div class="card-footer text-center">
          <button type="submit" class="btn btn-primary ">Sửa thông tin</button>
        </div> -->
        </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
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
<!-- <script>
  var faqs_row = <?=count($listAnhSanPham);?>;
  function addfaqs() {
    html = '<tr id="faqs-row-' + faqs_row + '">';
    html += '<td><img src="https://azpet.com.vn/wp-content/uploads/2024/11/z6015559978898_aaaa70a3bca6d9869da9a49f1deb9567-1536x1536.jpg" style="width: 70px; height: 70px;" alt=""></td>';
    html += '<td><input type="file" name="img_array[]" class="form-control"></td>';

    html += '<td class="mt-10"><button type="button" class="badge badge-danger" onclick="removeRow('+ faqs_row+ ', null);"><i class="fa fa-trash"></i> Delete</button></td>';

    html += '</tr>';

    $('#faqs tbody').append(html);

    faqs_row++;
  }

  function removeRow(rowId, imgId){
    
    $('#faqs-row-' + rowId).remove();
    if(imgId !== null){
      var imgDeleteInput = document.getElementById('img_delete')
      var currentValue = imgDeleteInput.value;
      imgDeleteInput.value = currentValue ? currentValue + ',' + imgId : imgId;
    }
  }
</script> -->

</html>