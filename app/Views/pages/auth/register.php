<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0">
            <div class="card-header border-0">
                <h4><?= isset($title) ? $title : '' ?></h4>
            </div>
            <div class="card-body">
                <?= form_open($action, ['method' => 'POST']) ?>
                <?= csrf_field() ?>
                <?= form_input(
                    title: 'Nama Lengkap',
                    name: 'name',
                    value: old('name') ?? '',
                    errors: session('errors.name') ?? '',
                    type: 'name',
                    ph: 'Masukkan Nama Lengkap',
                    attributes: ['required' => 'required']
                ) ?>
                <?= form_input(
                    title: 'E-Mail',
                    name: 'email',
                    value: old('email') ?? '',
                    errors: session('errors.email') ?? '',
                    type: 'email',
                    ph: 'Masukkan E-Mail Valid',
                    attributes: ['required' => 'required']
                ) ?>
                <?= form_input(
                    title: 'Kata Sandi',
                    name: 'password',
                    value: old('password') ?? '',
                    errors: session('errors.password') ?? '',
                    type: 'password',
                    ph: 'Masukkan Kata sandi',
                    attributes: ['required' => 'required']
                ) ?>
                <?= form_input(
                    title: 'Konfirmasi Kata Sandi',
                    name: 'password_confirmation',
                    value: old('password_confirmation') ?? '',
                    errors: session('errors.password_confirmation') ?? '',
                    type: 'password',
                    ph: 'Konfirmasi Kata sandi',
                    attributes: ['required' => 'required']
                ) ?>
                <?= btn_auth(title: 'Daftar') ?>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>