<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>


<?php if ($carts && count($carts) > 0): ?>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="card-header border-0 mb-2 mx-0 px-2"><?= isset($title) ? $title : '' ?></h4>
            <div class="shoping__cart__table">
                <table>
                    <thead>
                        <tr>
                            <th class="shoping__product">Produk</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Sub Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carts as $index => $cart): ?>
                            <tr>
                                <td class="shoping__cart__item">
                                    <?php if ($cart->product_image): ?>
                                        <img src="<?= base_url('storage/products/' . $cart->product_image) ?>" alt="<?= $cart->product_image ?>" width="50">
                                    <?php else: ?>
                                        <img src="https://placehold.co/50x50" alt="No Image">
                                    <?php endif; ?>
                                    <h5><?= esc($cart->product_name) ?></h5>
                                </td>
                                <td class="shoping__cart__price">
                                    <?= esc(rp($cart->product_price)) ?>
                                </td>
                                <td class="shoping__cart__quantity">
                                    <?= form_open(route_to('update_cart', $cart->id), ['method' => 'POST', 'id' => 'form-quantity', 'class' => 'quantity']) ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" value="<?= $cart->id ?>" name="productId">
                                    <div class="pro-qty">
                                        <input type="text" name="quantity" id="quantity" value="<?= $cart->quantity ?>">
                                    </div>
                                    <button type="submit" class="btn btn-sm text-success"><i class="fa fa-check"></i></button>
                                    <?= form_close() ?>
                                </td>
                                <td class="shoping__cart__total">
                                    <?= esc(rp($cart->subtotal)) ?>
                                </td>
                                <td class="shoping__cart__item__close">
                                    <?= btn_delete(
                                        base_url('carts/delete/' . esc($cart->id)),
                                        'Produk',
                                        esc($cart->product_name)
                                    ) ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="col-lg-12">
            <div class="shoping__cart__btns">
                <a href="<?= base_url('/') ?>" class="primary-btn cart-btn">Kembali Belanja</a>
                <a href="<?= base_url('/checkout') ?>" class="primary-btn float-right">PROSES PEMBAYARAN</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <div class="shoping__continue">
                <div class="shoping__discount">
                    <h5>KODE KUPON</h5>
                    <form action="#">
                        <input type="text" placeholder="Masukkan kupon kode" name="cupon_name">
                        <button type="submit" class="site-btn">CEK KUPON</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="shoping__checkout">
                <h5>Jumlah Pembayaran</h5>
                <ul>
                    <li>DISKON <span>Rp.0</span></li>
                    <li>TOTAL <span><?= esc(rp($total)) ?></span></li>
                </ul>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="text-center">
        <img src="<?= base_url('img/reshot-icon-cart-BAE3K9JRS7.svg') ?>" width="400">
        <br>
        <a href="<?= base_url('/') ?>" class="primary-btn">Belanja Sekarang</a>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>