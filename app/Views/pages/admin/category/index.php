<?= $this->extend('layouts/admin_app'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <span><?= isset($title) ? $title : '' ?></span>
        <a href="<?= route_to('category_create') ?>" class="btn btn-success btn-secondary">Tambah</a>
        <div class="float-right">
            <?= search(route_to('category_index')) ?>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($categories && count($categories) > 0): ?>
                    <?php foreach ($categories as $index => $category): ?>
                        <tr>
                            <td><?= no($pager, $index) ?></td>
                            <td><?= esc($category['name']) ?></td>
                            <td><?= esc($category['slug']) ?></td>
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
                                        <li><a class="dropdown-item" href="<?= route_to('category_edit', esc($category['slug'])) ?>">Edit</a></li>
                                        <li>
                                            <?= btn_delete(route_to('category_deelete', esc($category['slug'])), 'Kategori', esc($category['name'])) ?>
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