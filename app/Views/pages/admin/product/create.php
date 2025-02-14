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
                <?= form_open($action, ['method' => 'POST', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <?= form_input(
                    name: 'title',
                    value: old('title') ?? '',
                    errors: session('errors.title') ?? '',
                    type: 'text',
                    ph: 'Masukkan nama produk',
                    title: 'Nama Produk',
                    attributes: ['', 'onkeyup' => 'createSlug()']
                ) ?>

                <?= form_input(
                    name: 'slug',
                    value: old('slug') ?? '',
                    errors: session('errors.slug') ?? '',
                    type: 'text',
                    ph: 'Slug',
                    title: 'Slug',
                    attributes: ['']
                ) ?>

                <?= form_select(
                    name: 'category_id',
                    options: $categories,
                    title: 'Kategori',
                    selected: old('category_id') ?? '',
                    errors: session('errors.category_id') ?? ''
                ) ?>

                <?= form_input(
                    name: 'price',
                    value: old('price') ?? '',
                    errors: session('errors.price') ?? '',
                    type: 'number',
                    ph: 'Masukkan harga produk',
                    title: 'Harga Produk',
                    attributes: ['']
                ) ?>

                <?= form_input(
                    name: 'stocks',
                    value: old('stocks') ?? '',
                    errors: session('errors.stocks') ?? '',
                    type: 'number',
                    ph: 'Masukkan Stok produk',
                    title: 'Stok Produk',
                    attributes: ['']
                ) ?>

                <?= form_text(
                    name: 'description',
                    value: old('description') ?? '',
                    errors: session('errors.description') ?? '',
                    ph: 'Tulis deskripsi produk...',
                    title: 'Deskripsi Produk',
                    attributes: ['']
                ) ?>

                <?= form_input(
                    name: 'images[]',
                    errors: session('errors.images') ?? '',
                    type: 'file',
                    title: 'Upload Gambar Produk',
                    attributes: [
                        'accept' => 'image/*',
                        'multiple' => true
                    ]
                ) ?>
                <div class="image-preview" id="image-preview"></div>
                <?= btn_submit(route_to('product_index')) ?>
                <?= form_close() ?>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>