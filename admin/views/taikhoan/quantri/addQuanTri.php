<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm quản trị viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 40px 0; }
        .form-container { max-width: 800px; margin: auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px; color: white; }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <h2 class="text-2xl font-bold">Thêm Quản Trị Viên Mới</h2>
        </div>
        <form action="<?= BASE_URL_ADMIN . '?act=them-quan-tri' ?>" method="POST" class="p-8 grid grid-cols-2 gap-6">
            <div class="col-span-2 md:col-span-1">
                <label class="block font-bold mb-2 text-gray-700">Họ và tên</label>
                <input type="text" name="full_name" required class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label class="block font-bold mb-2 text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-purple-500 outline-none">
                <?php if(isset($_SESSION['error']['email'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $_SESSION['error']['email'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-span-2">
                <label class="block font-bold mb-2 text-gray-700">Mật khẩu mặc định sẽ là: <span class="text-purple-600">123456</span></label>
            </div>
            <div class="col-span-2 flex justify-end gap-4 mt-4">
                <a href="<?= BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri' ?>" class="px-6 py-3 bg-gray-200 rounded-lg font-bold">Hủy</a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-bold shadow-lg hover:bg-purple-700 transition">Tạo tài khoản</button>
            </div>
        </form>
    </div>
</body>
</html>