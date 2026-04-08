<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding">
        <div class="container">
            <form action="<?= BASE_URL . '?act=xu-ly-thanh-toan' ?>" method="POST">
                <div class="row">
                    <!-- Checkout Billing Details -->
                    <div class="col-lg-6">
                        <div class="checkout-billing-details-wrap">
                            <h5 class="checkout-title">Thông tin người nhận</h5>
                            <div class="billing-form-wrap">



                                <div class="single-input-item">
                                    <label for="receiver_name" class="required">Tên người nhận</label>
                                    <input type="text" id="receiver_name" name="receiver_name"
                                        value="<?= $user['full_name'] ?>" placeholder="Họ tên người nhận" required />
                                </div>
                                <div class="single-input-item">
                                    <label for="receiver_email" class="required">Địa chỉ email</label>
                                    <input type="email" id="receiver_email" name="receiver_email"
                                        value="<?= $user['email'] ?> " placeholder="Địa chỉ email" required />
                                </div>
                                <div class="single-input-item">
                                    <label for="receiver_phone" class="required">Số điện thoại</label>
                                    <input type="text" id="receiver_phone" name="receiver_phone"
                                        value="<?= $user['phone'] ?> " placeholder="Số điện thoại" required />
                                </div>
                                <div class="single-input-item">
                                    <label for="receiver_address" class="required">Địa chỉ</label>
                                    <input type="text" id="receiver_address" name="receiver_address"
                                        value="<?= $user['address'] ?> " placeholder="Địa chỉ" required />
                                </div>


                                <div class="single-input-item">
                                    <label for="note">Ghi chú</label>
                                    <textarea name="note" id="note" cols="30" rows="3"
                                        placeholder="Vui lòng nhập ghi chú."></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Details -->
                    <div class="col-lg-6">
                        <div class="order-summary-details">
                            <h5 class="checkout-title">Thông tin sản phẩm</h5>
                            <div class="order-summary-content">
                                <!-- Order Summary Table -->
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $tongGioHang = 0;
                                            foreach ($chiTietGioHang as $key => $row):
                                                ?>
                                                <tr>
                                                    <td><a href=""><?= $row['name'] ?>
                                                            <strong>x<?= $row['quantity'] ?></strong></a>
                                                    </td>
                                                    <td> <?php
                                                    $price = !empty($row['discount_price']) ? $row['discount_price'] : $row['price'];
                                                    $subtotal = $price * $row['quantity'];
                                                    $tongGioHang += $subtotal;
                                                    echo formatPrice($subtotal);
                                                    ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Tổng tiền sản phẩm</td>
                                                <td><strong><?= formatPrice($tongGioHang) ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>Phí vận chuyển</td>
                                                <td class="d-flex justify-content-center">
                                                    <strong>250000</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tổng đơn hàng</td>
                                                <input type="hidden"name="tong_tien" value="<?=$tongGioHang + 250000?>" >
                                                <td><strong><?php
                                                $tong_tien = $tongGioHang + 250000;
                                                echo formatPrice($tong_tien);
                                                ?></strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- Order Payment Method -->
                                <div class="order-payment-method">
                                    <div class="single-payment-method show">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="cashon" value="1" name="phuong_thuc_thanh_toan_id"
                                                    class="custom-control-input" checked />
                                                <label class="custom-control-label" for="cashon">Thanh toán khi nhận
                                                    hàng</label>
                                            </div>
                                        </div>
                                        <div class="payment-method-details" data-method="cash">
                                            <p>Khách hàng có thể thanh toán sau khi nhận hàng thành công(Cần xác nhận
                                                đơn hàng)</p>
                                        </div>
                                    </div>
                                    <div class="single-payment-method">
                                        <div class="payment-method-name">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="directbank"  value="2" name="phuong_thuc_thanh_toan_id" value="bank"
                                                    class="custom-control-input" />
                                                <label class="custom-control-label" for="directbank">Thanh toán bằng
                                                    ngân hàng</label>
                                            </div>
                                        </div>
                                        <div class="payment-method-details" data-method="cash">
                                            <p>Khách hàng cần thanh toán online</p>
                                        </div>
                                    </div>

                                    <div class="summary-footer-area">
                                        <div class="custom-control custom-checkbox mb-20">
                                            <input type="checkbox" class="custom-control-input" id="terms" required />
                                            <label class="custom-control-label" for="terms">Xác nhận đơn hàng</label>
                                        </div>
                                        <button type="submit" class="btn btn-sqr">Đặt hàng </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <!-- checkout main wrapper end -->
</main>

<?php require_once 'views/miniCart.php'; ?>

<?php require_once 'layout/footer.php'; ?>