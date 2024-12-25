<?= $this->extend('layouts/admin_app'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <span><?= isset($title) ? $title : '' ?></span>
        <div class="float-right">
            <?= search(route_to('order_index')) ?>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Invoice</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders && count($orders) > 0): ?>
                    <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td><?= no($pager, $index) ?></td>
                            <td>
                                <a href="<?= route_to('order_detail', esc($order['invoice'])) ?>"><?= esc($order['invoice']) ?></a>
                            </td>
                            <td><?= esc(rp($order['total'])) ?></td>
                            <td>
                                <?php if ($order['status'] == 'waiting'): ?>
                                    <span class="badge badge-fill badge-info"><?= 'Menunggu Pembayaran' ?></span>
                                <?php elseif ($order['status'] == 'paid'): ?>
                                    <span class="badge badge-fill badge-success"><?= 'Dibayar' ?></span>
                                <?php elseif ($order['status'] == 'delivered'): ?>
                                    <span class="badge badge-fill badge-warning"><?= 'Dikirim' ?></span>
                                <?php elseif ($order['status'] == 'cancel'): ?>
                                    <span class="badge badge-fill badge-danger"><?= 'Dibatalkan' ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button
                                        class="btn btn-danger btn-sm dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown"
                                        aria-expanded="false">
                                        Opsi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php if ($order['status'] == 'paid'): ?>
                                            <li>
                                                <a class="dropdown-item" href="<?= route_to('order_send', esc($order['id'])) ?>">Mengirim</a>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a class="dropdown-item" href="<?= route_to('order_edit', esc($order['id'])) ?>">Edit</a>
                                            </li>
                                            <li>
                                                <?= btn_delete(route_to('order_delete', esc($order['id'])), 'Pesanan', esc($order['invoice'])) ?>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Data tidak ada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="container">
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>