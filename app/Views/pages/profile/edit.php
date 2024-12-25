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
                    name: 'name',
                    value: old('name') ?? $user['name'],
                    errors: session('errors.name') ?? '',
                    type: 'text',
                    ph: 'Masukkan nama lengkap',
                    title: 'Nama Lengkap',
                    attributes: ['required' => 'required']
                ) ?>
                <?= form_input(
                    name: 'email',
                    value: old('email') ?? $user['email'],
                    errors: session('errors.email') ?? '',
                    type: 'email',
                    ph: 'Masukkan e-mail',
                    title: 'E-mail',
                    attributes: ['required' => 'required']
                ) ?>

                <?= form_input(
                    name: 'image',
                    errors: session('errors.image') ?? '',
                    type: 'file',
                    title: 'Upload Foto',
                    attributes: ['accept' => 'image/*']
                ) ?>

                <?= btn_submit(base_url('/profile')) ?>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>