<?= $this->extend('layouts/admin_app'); ?>
<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <span>
                    <?= isset($title) ? $title : '' ?>
                </span>
            </div>
            <div class="card-body">
                <?= form_open(route_to($action), ['method' => 'POST', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>

                <?= form_input(
                    title: 'Nama Pengguna',
                    name: 'name',
                    value: old('name') ?? $user['name'],
                    errors: session('errors.name') ?? '',
                    type: 'text',
                    ph: 'Masukkan nama pengguna',
                    attributes: ['required' => 'required']
                ) ?>

                <?= form_input(
                    title: 'E-Mail',
                    name: 'email',
                    value: old('email') ?? $user['email'],
                    errors: session('errors.email') ?? '',
                    type: 'email',
                    ph: 'Masukkan e-mail',
                    attributes: ['required' => 'required']
                ) ?>

                <?= form_radio(
                    title: 'Role',
                    errors: session('errors.role') ?? '',
                    selected: old('role') ?? $user['role'],
                    options: [
                        ['title_option' => 'Admin', 'value' => 'admin', 'name' => 'role', 'id' => 'admin'],
                        ['title_option' => 'Member', 'value' => 'member', 'name' => 'role', 'id' => 'member']
                    ]
                ) ?>

                <?= form_radio(
                    title: 'Status',
                    errors: session('errors.status') ?? '',
                    selected: old('status') ?? $user['is_active'],
                    options: [
                        ['title_option' => 'Aktif', 'value' => '1', 'name' => 'status', 'id' => 'active'],
                        ['title_option' => 'Tidak Aktif', 'value' => '0', 'name' => 'status', 'id' => 'unactive']
                    ]
                ) ?>

                <?= form_input(
                    title: 'Upload Gambar',
                    name: 'image',
                    errors: session('errors.image') ?? '',
                    type: 'file',
                    attributes: ['accept' => 'image/*']
                ) ?>

                <?= btn_submit(route_to('user_index')) ?>
                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>