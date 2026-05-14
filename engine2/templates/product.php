<?php if ($product): ?>
    <div class="product-detail">
        <a class="back-link" href="index.php?page=catalog">Назад в каталог</a>

        <div class="product-detail-layout">
            <img class="product-detail-image" src="<?=htmlspecialchars(getProductImageSrc($product['image_path']))?>" alt="<?=htmlspecialchars($product['name'])?>">

            <div class="product-detail-info">
                <h2><?=htmlspecialchars($product['name'])?></h2>
                <p class="product-detail-price"><?=htmlspecialchars($product['price'])?> руб.</p>
                <p><?=nl2br(htmlspecialchars($product['description']))?></p>
            </div>
        </div>

        <section class="feedback">
            <h3>Отзывы</h3>

            <?php if (!empty($feedbackError)): ?>
                <p class="message message-error"><?=htmlspecialchars($feedbackError)?></p>
            <?php endif; ?>

            <form class="feedback-form" action="index.php?page=product&id=<?=htmlspecialchars($product['id'])?>" method="post">
                <input type="hidden" name="feedback_action" value="create">
                <input type="hidden" name="product_id" value="<?=htmlspecialchars($product['id'])?>">

                <label>
                    Ваше имя
                    <input type="text" name="author" required>
                </label>

                <label>
                    Отзыв
                    <textarea name="text" rows="4" cols="10" required></textarea>
                </label>

                <button type="submit">Добавить отзыв</button>
            </form>

            <?php if (!empty($feedback)): ?>
                <div class="feedback-list">
                    <?php foreach ($feedback as $item): ?>
                        <article class="feedback-item">
                            <div class="feedback-meta">
                                <strong><?=htmlspecialchars($item['author'])?></strong>
                                <span><?=htmlspecialchars($item['created_at'])?></span>
                            </div>

                            <p><?=nl2br(htmlspecialchars($item['text']))?></p>

                            <form class="feedback-form feedback-form-inline" action="index.php?page=product&id=<?=htmlspecialchars($product['id'])?>" method="post">
                                <input type="hidden" name="feedback_action" value="update">
                                <input type="hidden" name="product_id" value="<?=htmlspecialchars($product['id'])?>">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($item['id'])?>">

                                <label>
                                    Имя
                                    <input type="text" name="author" value="<?=htmlspecialchars($item['author'])?>" required>
                                </label>

                                <label>
                                    Текст
                                    <textarea name="text" rows="3" cols="10" required><?=htmlspecialchars($item['text'])?></textarea>
                                </label>

                                <button type="submit">Сохранить</button>
                            </form>

                            <form action="index.php?page=product&id=<?=htmlspecialchars($product['id'])?>" method="post">
                                <input type="hidden" name="feedback_action" value="delete">
                                <input type="hidden" name="product_id" value="<?=htmlspecialchars($product['id'])?>">
                                <input type="hidden" name="id" value="<?=htmlspecialchars($item['id'])?>">
                                <button class="button-danger" type="submit">Удалить</button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Отзывов пока нет.</p>
            <?php endif; ?>
        </section>
    </div>
<?php else: ?>
    <h2>Товар не найден</h2>
    <p>Такого товара нет в каталоге.</p>
    <p><a href="index.php?page=catalog">Вернуться в каталог</a></p>
<?php endif; ?>
