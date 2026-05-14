<h1>Фотогалерея</h1>

<form class="upload-form" action="" method="post" enctype="multipart/form-data">
    <label for="image">Загрузить новое изображение</label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png">
    <button type="submit">Загрузить</button>
</form>

<?php if (!empty($error)): ?>
    <div class="message message-error"><?=$error?></div>
<?php endif; ?>

<?php if (!empty($images)): ?>
    <div class="gallery">
        <?php foreach ($images as $image): ?>
            <a class="gallery-item" href="<?=htmlspecialchars($image['src'])?>" target="_blank">
                <img src="<?=htmlspecialchars($image['thumb'])?>" alt="<?=htmlspecialchars($image['name'])?>" width="200">
                <span><?=htmlspecialchars($image['name'])?></span>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>В галерее пока нет изображений. Загрузите первое фото через форму выше.</p>
<?php endif; ?>
