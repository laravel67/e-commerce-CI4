<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('layouts/menu_side') ?>
    </div>
    <div class="col-md-9">
        <div class="card-mb-3">
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
                                            <a href="<?= base_url('storage/products/' . $detail['product_image']) ?>" data-lightbox="product-gallery" data-title="<?= esc($detail['product_name']) ?>">
                                                <img src="<?= base_url('storage/products/' . $detail['product_image']) ?>" alt="<?= esc($detail['product_name']) ?>" width="50" height="50">
                                            </a>
                                        <?php else : ?>
                                            <img src="https://placehold.co/50x50" alt="No Image">
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
                <a href="<?= base_url('checkout/payment') ?>" class="btn btn-success">
                    Konfirmasi Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>