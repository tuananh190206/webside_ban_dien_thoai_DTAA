<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }

    /* ===== MAIN CONTAINER ===== */
    .shop-page {
        max-width: 1280px;
        margin: 0 auto;
        padding: 30px 20px 60px;
    }

    /* ===== RESULT TITLE ===== */
    .result-title {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .result-title i { color: #667eea; }
    .result-title span { color: #667eea; }

    /* ===== PRODUCT GRID ===== */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    /* ===== PRODUCT CARD ===== */
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.06);
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }
    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
    }
    .product-card:hover::before { opacity: 1; }

    .product-card-img {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        aspect-ratio: 1;
    }
    .product-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .product-card:hover .product-card-img img { transform: scale(1.08); }

    /* BADGES */
    .badge-sale {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 10px rgba(239,68,68,0.4);
    }
    .badge-new {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 10px rgba(16,185,129,0.4);
    }

    /* QUICK ACTIONS */
    .quick-actions {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        opacity: 0;
        display: flex;
        gap: 8px;
        transition: all 0.35s;
    }
    .product-card:hover .quick-actions {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    .quick-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transition: all 0.2s;
        text-decoration: none;
    }
    .quick-btn:hover {
        background: #667eea;
        color: white;
        transform: scale(1.1);
    }
    .quick-btn.wishlist:hover { background: #ef4444; }

    /* CARD BODY */
    .product-card-body { padding: 18px; }
    .product-card-category {
        font-size: 12px;
        color: #667eea;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .product-card-name {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 12px;
        line-height: 1.4;
        height: 42px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .product-card-name a { color: inherit; text-decoration: none; transition: color 0.2s; }
    .product-card-name a:hover { color: #667eea; }

    .product-card-price {
        display: flex;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 14px;
    }
    .price-current { font-size: 20px; font-weight: 800; color: #ef4444; }
    .price-original { font-size: 14px; color: #9ca3af; text-decoration: line-through; }

    /* RATING */
    .product-card-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 14px;
    }
    .stars { color: #fbbf24; font-size: 13px; letter-spacing: 1px; }
    .rating-count { font-size: 12px; color: #9ca3af; }

    /* ADD TO CART BUTTON */
    .btn-add-cart {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-add-cart:hover {
        background: linear-gradient(135deg, #5a6fd6, #6a4190);
        box-shadow: 0 6px 20px rgba(102,126,234,0.4);
    }

    /* ===== NO RESULTS ===== */
    .no-results {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
    }
    .no-results-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 40px;
        color: #9ca3af;
    }
    .no-results h3 { font-size: 22px; color: #374151; margin-bottom: 8px; }
    .no-results p { color: #9ca3af; font-size: 15px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1100px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .product-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; } }
    @media (max-width: 480px) {
        .shop-page { padding: 20px 12px 40px; }
        .product-grid { gap: 12px; }
        .product-card-body { padding: 12px; }
        .price-current { font-size: 17px; }
    }
</style>

<main>
    <div class="shop-page">
        <!-- ===== RESULT TITLE ===== -->
        <?php if (isset($tieuDe)): ?>
        <div class="result-title">
            <i class="fa fa-search"></i> <?= htmlspecialchars($tieuDe) ?>
        </div>
        <?php else: ?>
        <div class="result-title">
            <i class="fa fa-star"></i> Sản phẩm <span>nổi bật</span>
        </div>
        <?php endif; ?>

        <!-- ===== PRODUCT GRID ===== -->
        <div class="product-grid" id="productGrid">
            <?php if (!empty($listSanPham)): ?>
                <?php foreach ($listSanPham as $sanPham): 
                    $giaGoc = (float)($sanPham['price'] ?? 0);
                    $giaGiam = (float)($sanPham['discount_price'] ?? 0);
                    $giaHienThi = $giaGiam > 0 ? $giaGiam : $giaGoc;
                    $phanTramGiam = $giaGoc > 0 && $giaGiam > 0 
                        ? round((($giaGoc - $giaGiam) / $giaGoc) * 100) 
                        : 0;
                    $hinhAnh = $sanPham['image'] ?? 'assets/img/product/default.jpg';
                    $linkChiTiet = BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . (int)$sanPham['id'];
                ?>
                <div class="product-card">
                    <div class="product-card-img">
                        <a href="<?= $linkChiTiet ?>">
                            <img src="<?= BASE_URL . $hinhAnh ?>" alt="<?= htmlspecialchars($sanPham['name']) ?>">
                        </a>
                        <?php if ($phanTramGiam > 0): ?>
                        <span class="badge-sale">-<?= $phanTramGiam ?>%</span>
                        <?php endif; ?>
                        <?php 
                        $ngayTao = strtotime($sanPham['created_at'] ?? '');
                        $ngayMoi = time() - (7 * 24 * 60 * 60);
                        if ($ngayTao > $ngayMoi): 
                        ?>
                        <span class="badge-new">MỚI</span>
                        <?php endif; ?>
                        
                        <div class="quick-actions">
                            <a href="<?= $linkChiTiet ?>" class="quick-btn" title="Xem chi tiết">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" class="quick-btn wishlist" title="Yêu thích">
                                <i class="fa fa-heart"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="product-card-body">
                        <p class="product-card-category">
                            <i class="fa fa-tag"></i> <?= htmlspecialchars($sanPham['category_name'] ?? '') ?>
                        </p>
                        <h3 class="product-card-name">
                            <a href="<?= $linkChiTiet ?>"><?= htmlspecialchars($sanPham['name']) ?></a>
                        </h3>
                        
                        <div class="product-card-price">
                            <span class="price-current"><?= number_format($giaHienThi, 0, ',', '.') ?>đ</span>
                            <?php if ($phanTramGiam > 0): ?>
                            <span class="price-original"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-card-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">(<?= rand(10, 200) ?>)</span>
                        </div>
                        
                        <a href="<?= $linkChiTiet ?>" class="btn-add-cart">
                            <i class="fa fa-shopping-cart"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-results" style="grid-column: 1/-1;">
                    <div class="no-results-icon"><i class="fa fa-search"></i></div>
                    <h3>Không tìm thấy sản phẩm nào!</h3>
                    <p>Hãy thử tìm kiếm với từ khóa khác</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>
