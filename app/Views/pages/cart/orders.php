<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('layouts/menu_side') ?>
    </div>
    <div class="col-md-9">
        <div class="card-mb-3">
            <div class="card-header">
                <?= isset($title) ? $title : '' ?>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= 'Invoice' ?></th>
                            <th>Tanggal</th>
                            <th class="text-center"><?= 'Total' ?></th>
                            <th class="text-center"><?= 'Status' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($orders && count($orders) > 0): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('/myorders/detail/' . $order->invoice) ?>"> <?= esc($order->invoice) ?></a>
                                    </td>
                                    <td>
                                        <?= esc(dateID($order->created_at)) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= esc(rp($order->total)) ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($order->status == 'waiting'): ?>
                                            <span class="badge badge-fill badge-info"><?= 'Menunggu Pembayaran' ?></span>
                                        <?php elseif ($order->status == 'paid'): ?>
                                            <span class="badge badge-fill badge-success"><?= 'Dibayar' ?></span>
                                        <?php elseif ($order->status == 'delivered'): ?>
                                            <span class="badge badge-fill badge-warning"><?= 'Dikirim' ?></span>
                                        <?php elseif ($order->status == 'cancel'): ?>
                                            <span class="badge badge-fill badge-danger"><?= 'Dibatalkan' ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center"><?= 'Data tidak ada.' ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>