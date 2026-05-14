<h2>Каталог</h2>

<?php if (!empty($catalog)): ?>
    <div class="catalog">
        <?php foreach ($catalog as $item): ?>
            <a class="product-card" href="index.php?page=product&id=<?=htmlspecialchars($item['id'])?>">
                <img src="<?=htmlspecialchars(getProductImageSrc($item['image_path']))?>" alt="<?=htmlspecialchars($item['name'])?>">
                <span class="product-card-title"><?=htmlspecialchars($item['name'])?></span>
                <span class="product-card-price"><?=htmlspecialchars($item['price'])?> руб.</span>
                <span class="product-card-description"><?=htmlspecialchars(mb_substr($item['description'], 0, 80))?></span>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Товары пока не добавлены.</p>
<?php endif; ?>
