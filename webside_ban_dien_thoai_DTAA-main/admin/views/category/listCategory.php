<?php require './views/layout/sidebar.php' ?>
<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website bán điện thoại DTAA</title>
  <script src="/_sdk/element_sdk.js"></script>
  <style>
    body {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100%;
      width: 100%;
    }

    * {
      box-sizing: border-box;
    }

    .container {
      width: 100%;
      min-height: 100%;
      padding: auto;
      margin: auto;
    }

    .admin-panel {
      max-width: 1200px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }

    .header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 32px 40px;
      color: #ffffff;
    }

    .header h1 {
      margin: 0 0 8px 0;
      font-size: 32px;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .header p {
      margin: 0;
      font-size: 16px;
      opacity: 0.9;
    }

    .toolbar {
      padding: 24px 40px;
      background: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    .search-box {
      flex: 1;
      min-width: 250px;
    }

    .search-box input {
      width: 100%;
      padding: 12px 16px 12px 44px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s ease;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: 12px center;
    }

    .search-box input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-primary {
      padding: 12px 24px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #ffffff;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .table-container {
      padding: 0;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      background: #f8f9fa;
      border-bottom: 2px solid #e9ecef;
    }

    thead th {
      padding: 16px 24px;
      text-align: left;
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #495057;
    }

    thead th:first-child {
      width: 80px;
      text-align: center;
    }

    thead th:nth-child(2) {
      width: 25%;
    }

    thead th:nth-child(3) {
      width: 45%;
    }

    thead th:last-child {
      width: 140px;
      text-align: center;
    }

    tbody tr {
      border-bottom: 1px solid #e9ecef;
      transition: all 0.2s ease;
    }

    tbody tr:hover {
      background: #f8f9fa;
    }

    tbody td {
      padding: 20px 24px;
      font-size: 14px;
      color: #495057;
      vertical-align: top;
    }

    tbody td:first-child {
      text-align: center;
      font-weight: 600;
      color: #667eea;
    }

    .category-name {
      font-weight: 600;
      color: #212529;
      margin-bottom: 4px;
    }

    .category-description {
      line-height: 1.6;
      color: #6c757d;
    }

    .actions {
      display: flex;
      gap: 8px;
      justify-content: center;
    }

    .btn-edit,
    .btn-delete {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-edit {
      background: #e3f2fd;
      color: #1976d2;
    }

    .btn-edit:hover {
      background: #bbdefb;
    }

    .btn-delete {
      background: #ffebee;
      color: #d32f2f;
    }

    .btn-delete:hover {
      background: #ffcdd2;
    }

    .pagination {
      padding: 24px 40px;
      background: #f8f9fa;
      border-top: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    .pagination-info {
      font-size: 14px;
      color: #6c757d;
    }

    .pagination-controls {
      display: flex;
      gap: 8px;
    }

    .page-btn {
      padding: 8px 14px;
      background: #ffffff;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      font-size: 14px;
      color: #495057;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .page-btn:hover {
      background: #e9ecef;
      border-color: #adb5bd;
    }

    .page-btn.active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #ffffff;
      border-color: transparent;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px 10px;
      }

      .header {
        padding: 24px 20px;
      }

      .header h1 {
        font-size: 24px;
      }

      .toolbar {
        padding: 16px 20px;
      }

      .search-box {
        width: 100%;
      }

      thead th,
      tbody td {
        padding: 12px 16px;
      }

      .pagination {
        padding: 16px 20px;
      }
    }
  </style>
  <style>
    @view-transition {
      navigation: auto;
    }
  </style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <script src="https://cdn.tailwindcss.com" type="text/javascript"></script>
</head>

<body>
  <div class="container">
    <div class="admin-panel">
      <header class="header">
        <h1 id="page-title"> Danh Mục Điện Thoại</h1>
        <p>Quản lý danh mục điện thoại trên website</p>   
      </header>
      <div class="toolbar">
        <div class="search-box"><input type="text" placeholder="Tìm kiếm danh mục...">
        </div>
        <a href="<?= BASE_URL_ADMIN . '?act=form-them-category' ?>" style="text-decoration: none;">
          <button class="btn-primary" id="add-button">
            <svg width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg><span id="add-button-text">Thêm Danh Mục Mới</span>
          </button>
        </a>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên Danh Mục</th>
              <th>Mô Tả</th>
              <th>Thao Tác</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($listCategory as $key => $category): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td>
                  <div class="category-name">
                    <?= $category['name'] ?>
                  </div>
                </td>
                <td>
                  <div class="category-description">
                    <?= $category['description'] ?>
                  </div>
                </td>
                <td>
                  <div class="actions">
                    <a href="<?= BASE_URL_ADMIN . '?act=form-sua-category&id_category=' . $category['id'] ?>">
                      <button class="btn-edit">Sửa</button>
                    </a>
                    <a href="<?= BASE_URL_ADMIN . '?act=xoa-category&id_category=' . $category['id'] ?>"
                      onclick="return confirm('Bạn có đồng ý xóa hay không')">
                      <button class="btn-delete">Xóa</button>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <div class="pagination">
        <div class="pagination-info">
          Hiển thị 1-5 trong tổng số X danh mục (Cần PHP tính toán)
        </div>
        <div class="pagination-controls">
          <button class="page-btn">❮ Trước</button>
          <button class="page-btn active">1</button>
          <button class="page-btn">2</button>
          <button class="page-btn">3</button>
          <button class="page-btn">Sau ❯</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    const defaultConfig = {
      page_title: "Danh mục điện thoại",
      add_button_text: "Thêm Danh Mục Mới"
    };

    async function onConfigChange(config) {
      const pageTitle = document.getElementById('page-title');
      const addButtonText = document.getElementById('add-button-text');

      if (pageTitle) {
        pageTitle.textContent = config.page_title || defaultConfig.page_title;
      }

      if (addButtonText) {
        addButtonText.textContent = config.add_button_text || defaultConfig.add_button_text;
      }
    }

    function mapToCapabilities(config) {
      return {
        recolorables: [],
        borderables: [],
        fontEditable: undefined,
        fontSizeable: undefined
      };
    }

    function mapToEditPanelValues(config) {
      return new Map([
        ["page_title", config.page_title || defaultConfig.page_title],
        ["add_button_text", config.add_button_text || defaultConfig.add_button_text]
      ]);
    }

    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange,
        mapToCapabilities,
        mapToEditPanelValues
      });
    }
  </script>
</body>

</html>