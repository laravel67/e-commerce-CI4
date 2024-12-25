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
                <?= form_open($action, ['method' => 'POST', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <?= form_input(
                    title: 'Kata Sandi Lama',
                    name: 'oldpassword',
                    value: old('oldpassword') ?? '',
                    errors: session('errors.oldpassword') ?? '',
                    type: 'password',
                    ph: 'Masukkan kata sandi lama',
                    attributes: ['required' => 'required']
                ) ?>

                <?= form_input(
                    title: 'Kata Sandi Baru',
                    name: 'newpassword',
                    value: old('newpassword') ?? '',
                    errors: session('errors.newpassword') ?? '',
                    type: 'password',
                    ph: 'Masukkan kata sandi baru',
                    attributes: ['required' => 'required']
                ) ?>

                <?= form_input(
                    title: 'Konfirmasi Kata Sandi',
                    name: 'password_confirmed',
                    value: old('password_confirmed') ?? '',
                    errors: session('errors.password_confirmed') ?? '',
                    type: 'password',
                    ph: 'Konfirmasi kata sandi',
                    attributes: ['required' => 'required']
                ) ?>

                <?= btn_submit('Ubah Kata Sandi') ?>

                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>