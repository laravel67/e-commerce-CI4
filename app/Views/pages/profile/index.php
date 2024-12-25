<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3">
        <?= $this->include('layouts/menu_side') ?>
    </div>
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-header">
                <?= isset($title) ? $title : '' ?>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-4 text-center">
                        <?php if (!empty($user['image'])) : ?>
                            <a href="<?= base_url('storage/users/' . $user['image']) ?>" data-lightbox="user-gallery" data-title="<?= esc($user['name']) ?>">
                                <img src="<?= base_url('storage/users/' . $user['image']) ?>" alt="<?= esc($user['name']) ?>" width="200" height="200">
                            </a>
                        <?php else : ?>
                            <img src="https://placehold.co/200x200">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nama: <?= $user['name'] ?></li>
                            <li class="list-group-item">Email: <?= $user['email'] ?></li>
                        </ul>
                    </div>
                </div>
                <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary">
                    Ubah
                </a>
                <a href="<?= base_url('profile/update-password') ?>" class="btn btn-secondary">
                    Ganti Sandi
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>