<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row mb-2">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <?= 'Data Pengiriman' ?>
            </div>
            <div class="card-body">
                <?= form_open($action, ['method' => 'POST']) ?>
                <?= csrf_field() ?>
                <?= form_input(
                    name: 'name',
                    value: old('name') ?? $user['name'],
                    errors: session('errors.name') ?? '',
                    type: 'text',
                    ph: 'Masukkan nama penerima',
                    title: 'Nama Penerima',
                    attributes: ['required' => 'required']
                ) ?>
                <?= form_text(
                    name: 'address',
                    value: old('address') ?? '',
                    errors: session('errors.address') ?? '',
                    ph: 'Masukkan alamat pengiriman',
                    title: 'Alamat Pengiriman',
                    attributes: ['required' => 'required']
                ) ?>
                <?= form_input(
                    name: 'phone',
                    value: old('phone') ?? '',
                    errors: session('errors.phone') ?? '',
                    type: 'number',
                    ph: 'Masukkan nomot telepone',
                    title: 'Nomor Telepone',
                    attributes: ['required' => 'required']
                ) ?>
                <div class="card-footer">
                    <a href="<?= base_url('/carts') ?>" class="btn btn-secondary">
                        <i class="fas fa-angle-left"></i> <?= 'Kembali' ?>
                    </a>
                    <button type="submit" class="btn btn-success float-right col-2">
                        <?= 'CheckOut ' ?> <i class="fas fa-angle-right"></i>
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <?= 'Invoice' ?>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= esc($product->product_name) ?></td>
                                        <td><?= esc($product->quantity) ?></td>
                                        <td> <?= esc(rp($product->product_price)) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Subtotal</td>
                                        <td><?= esc(rp($product->subtotal)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2"><strong>Total:</strong></th>
                                    <th><strong><?= esc(rp($total)) ?></strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>