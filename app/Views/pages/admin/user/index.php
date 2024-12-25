<?= $this->extend('layouts/admin_app'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <span><?= isset($title) ? $title : '' ?></span>
        <a href="<?= route_to('user_create') ?>" class="btn btn-success btn-secondary"> Tambah</a>
        <div class="float-right">
            <?= search('/users') ?>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users && count($users) > 0): ?>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= no($pager, $index) ?></td>

                            <td>
                                <p>
                                    <?php if (!empty($user['image'])) : ?>
                                        <a href="<?= base_url('storage/users/' . $user['image']) ?>" data-lightbox="user-gallery" data-title="<?= esc($user['name']) ?>">
                                            <img src="<?= base_url('storage/users/' . $user['image']) ?>" alt="<?= esc($user['name']) ?>" width="50" height="50">
                                        </a>
                                    <?php else : ?>
                                        <img src="https://placehold.co/50x50" alt="No Image">
                                    <?php endif; ?>
                                    <strong><?= esc($user['name']) ?></strong>
                                </p>
                            </td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['role']) ?></td>
                            <td>
                                <?php if (esc($user['is_active']) == true) :  ?>
                                    <span class="badge badge-pill badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-pill badge-secondary">Unactive</span>
                                <?php endif; ?>
                            </td>
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
                                        <li><a class="dropdown-item" href="<?= route_to('user_edit', esc($user['id'])) ?>">Edit</a></li>
                                        <li>
                                            <?= btn_delete(route_to('user_delete', esc($user['id'])), 'Pengguna', esc($user['name'])) ?>
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
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection(); ?>