<?= $this->extend('layouts/admin_app'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <span><?= isset($title) ? $title : '' ?></span>
        <a href="<?= route_to('product_create') ?>" class="btn btn-success btn-secondary"> Tambah</a>
        <div class="float-right">
            <?= search(route_to('product_index')) ?>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($products && count($products) > 0): ?>
                    <?php foreach ($products as $index => $product): ?>
                        <tr>
                            <td><?= no($pager, $index) ?></td>

                            <td>
                                <p>
                                    <?php
                                    $images = json_decode($product['image'], true); // Decode JSON menjadi array
                                    $firstImage = !empty($images) ? $images[0] : null; // Ambil gambar pertama jika ada
                                    ?>

                                    <?php if (!empty($firstImage)) : ?>
                                        <a href="<?= base_url('storage/products/' . $firstImage) ?>" data-lightbox="product-gallery" data-title="<?= esc($product['name']) ?>">
                                            <img src="<?= base_url('storage/products/' . $firstImage) ?>" alt="<?= esc($product['name']) ?>" width="50" height="50">
                                        </a>
                                    <?php else : ?>
                                        <img src="https://placehold.co/50x50" alt="No Image">
                                    <?php endif; ?>
                                    <strong>
                                        <?= esc($product['name']) ?></strong>
                                </p>
                            </td>
                            <td><?= esc($product['category']) ?></td>
                            <td><?= esc(rp(($product['price']))) ?></td>
                            <td><?= esc($product['stocks']) ?> Item</td>
                            <td>
                                <div class="dropdown">
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm dropdown-toggle"
                                        data-toggle="dropdown"
                                        aria-expanded="false">
                                        Opsi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= route_to('product_edit', esc($product['slug'])) ?>">Edit</a></li>
                                        <li>
                                            <?= btn_delete(route_to('product_delete', esc($product['slug'])), 'Produk', esc($product['name'])) ?>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Data tidak ada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?= $pager->links() ?>
</div>
<?= $this->endSection(); ?>