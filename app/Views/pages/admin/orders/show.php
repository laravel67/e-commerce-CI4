<?= $this->extend('layouts/admin_app'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <?= isset($title) ? esc($title) : '' ?> <?= esc($order['invoice']) ?>
        <div class="float-right">
            <?php if ($order['status'] == 'waiting'): ?>
                <span class="badge badge-fill badge-info">Menunggu Pembayaran</span>
            <?php elseif ($order['status'] == 'paid'): ?>
                <span class="badge badge-fill badge-success">Dibayar</span>
            <?php elseif ($order['status'] == 'delivered'): ?>
                <span class="badge badge-fill badge-warning">Dikirim</span>
            <?php elseif ($order['status'] == 'cancel'): ?>
                <span class="badge badge-fill badge-danger">Dibatalkan</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <p><strong>Nama:</strong> <?= esc($order['name']) ?></p>
        <p><strong>Telepon:</strong> <?= esc($order['phone']) ?></p>
        <p><strong>Alamat:</strong> <?= esc($order['address']) ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga/item</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $detail): ?>
                    <tr>
                        <td>
                            <p>
                                <?php if (!empty($detail['product_image'])) : ?>
                                    <a href="<?= base_url('storage/products/' . esc($detail['product_image'])) ?>" data-lightbox="product-gallery" data-title="<?= esc($detail['product_name']) ?>">
                                        <img src="<?= base_url('storage/products/' . esc($detail['product_image'])) ?>" alt="<?= esc($detail['product_name']) ?>" width="100" height="100">
                                    </a>
                                <?php else : ?>
                                    <img src="https://placehold.co/100x100" alt="No Image">
                                <?php endif; ?>
                                <strong><?= esc($detail['product_name']) ?></strong>
                            </p>
                        </td>
                        <td><?= esc(rp($detail['product_price'])) ?></td>
                        <td class="text-center"><?= esc($detail['quantity']) ?></td>
                        <td class="text-center"><?= esc(rp($detail['subtotal'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td class="text-center"><strong>Rp. <?= number_format($order['total'], 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="<?= route_to('order_index') ?>" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div>
<?= $this->endSection(); ?>