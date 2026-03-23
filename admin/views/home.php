<?php require './views/layout/sidebar.php' ?>
<div id="content-area" class="p-8">
  <div id="home-page" class="page-content">
    <div class="mb-6">
      <h3 class="text-2xl font-semibold text-gray-800 mb-2">
        Chào mừng đến với hệ thống quản lý SHOP ĐIỆN THOẠI
      </h3>
      <p class="text-gray-600">Dashboard tổng quan về hoạt động kinh doanh</p>
    </div>

    <!-- THỐNG KÊ -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

      <!-- SẢN PHẨM -->
      <div class="card bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Tổng sản phẩm</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">256</p>
      </div>

      <!-- ĐƠN HÀNG -->
      <div class="card bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Đơn hàng</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">512</p>
      </div>

      <!-- KHÁCH HÀNG -->
      <div class="card bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-sm">Khách hàng</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">1,200</p>
      </div>

      <!-- DOANH THU -->
      <div class="card bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
        <p class="text-gray-500 text-sm">Doanh thu</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">3.2B</p>
      </div>

    </div>

    <!-- DANH SÁCH -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- ĐƠN HÀNG GẦN ĐÂY -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h4 class="text-lg font-bold mb-4">Đơn hàng gần đây</h4>

        <div class="space-y-3">
          <div class="p-3 bg-gray-50 rounded-lg flex justify-between">
            <div>
              <p class="font-medium">iPhone 14 Pro Max</p>
              <p class="text-sm text-gray-500">Nguyễn Văn A - 01/03/2026</p>
            </div>
            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Đã giao</span>
          </div>

          <div class="p-3 bg-gray-50 rounded-lg flex justify-between">
            <div>
              <p class="font-medium">Samsung S23 Ultra</p>
              <p class="text-sm text-gray-500">Trần Thị B - 02/03/2026</p>
            </div>
            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Đang xử lý</span>
          </div>
        </div>
      </div>

      <!-- SẢN PHẨM BÁN CHẠY -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h4 class="text-lg font-bold mb-4">Sản phẩm bán chạy</h4>

        <div class="space-y-3">
          <div class="p-3 bg-blue-50 rounded-lg flex justify-between">
            <p>📱 iPhone 14</p>
            <span class="font-bold text-blue-600">120 sold</span>
          </div>

          <div class="p-3 bg-green-50 rounded-lg flex justify-between">
            <p>📱 Samsung S22</p>
            <span class="font-bold text-green-600">98 sold</span>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- KHÁCH HÀNG -->
  <div id="customers-page" class="page-content hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <h3 class="text-xl font-bold mb-6">Danh sách khách hàng</h3>

      <table class="w-full">
        <thead>
          <tr class="bg-gray-50">
            <th class="p-3">Mã KH</th>
            <th class="p-3">Tên</th>
            <th class="p-3">Email</th>
            <th class="p-3">SĐT</th>
            <th class="p-3">Đơn hàng</th>
          </tr>
        </thead>

        <tbody>
          <tr class="border-b">
            <td class="p-3">KH001</td>
            <td class="p-3">Nguyễn Văn A</td>
            <td class="p-3">a@gmail.com</td>
            <td class="p-3">0901234567</td>
            <td class="p-3">5</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- DANH MỤC -->
  <div id="categories-page" class="page-content hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <h3 class="text-xl font-bold mb-6">Danh mục sản phẩm</h3>

      <div class="grid grid-cols-3 gap-4">
        <div class="border p-4 rounded-lg">📱 iPhone</div>
        <div class="border p-4 rounded-lg">📱 Samsung</div>
        <div class="border p-4 rounded-lg">📱 Xiaomi</div>
      </div>
    </div>
  </div>

  <!-- SẢN PHẨM -->
  <div id="products-page" class="page-content hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <h3 class="text-xl font-bold mb-6">Quản lý sản phẩm</h3>
      <p>Danh sách điện thoại</p>
    </div>
  </div>

  <!-- ĐƠN HÀNG -->
  <div id="orders-page" class="page-content hidden">
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <h3 class="text-xl font-bold mb-6">Quản lý đơn hàng</h3>
    </div>
  </div>

</div>