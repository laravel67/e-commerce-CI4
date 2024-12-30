<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="featured__controls">
            <ul>
                <li class="active" data-filter="*">Semua</li>
                <?php foreach ($categories as $category): ?>
                    <li data-filter=".<?= $category['name'] ?>"><?= $category['name'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="row featured__filter">
    <?php if ($products && count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <?php
            $images = json_decode($product['image'], true);
            $firstImage = !empty($images) ? $images[0] : null;
            ?>
            <?= card_product(
                idProduct: $product['id'],
                name: $product['name'],
                price: $product['price'],
                img: $firstImage,
                category: $product['category_name'],
                count: $product['stocks'],
                urlShow: base_url("product/" . $product['slug']),
                urlCategory: base_url('/?category=' . $product['category_slug']),
            ) ?>
        <?php endforeach; ?>
    <?php endif ?>
</div>
<?= $this->endSection(); ?>