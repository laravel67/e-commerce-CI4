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
                <?= form_open($action, ['method' => 'POST']) ?>
                <?= csrf_field() ?>
                <?= form_input(
                    name: 'title',
                    value: old('title') ?? $category['name'],
                    errors: session('errors.title') ?? '',
                    type: 'text',
                    ph: 'Masukkan nama kategori',
                    title: 'Nama Kategori',
                    attributes: ['required' => 'required', 'onkeyup' => 'createSlug()']
                ) ?>
                <?= form_input(
                    name: 'slug',
                    value: old('slug') ?? $category['slug'],
                    errors: session('errors.slug') ?? '',
                    type: 'text',
                    ph: 'Slug',
                    title: 'Slug Kategori',
                    attributes: ['required' => 'required']
                ) ?>
                <?= btn_submit(route_to('category_index')) ?>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>