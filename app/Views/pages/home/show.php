<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <?php
                        $images = json_decode($product['image'], true); // Decode JSON menjadi array
                        $firstImage = !empty($images) ? $images[0] : null; // Ambil gambar pertama
                        ?>
                        <?php if ($firstImage): ?>
                            <img class="product__details__pic__item--large" src="<?= base_url('storage/products/' . esc($firstImage)) ?>" alt="">
                        <?php else: ?>
                            <img class="product__details__pic__item--large" src="https://placehold.co/300x200" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="product__details__pic__slider owl-carousel">
                        <?php if (!empty($images)): ?>
                            <?php foreach ($images as $image): ?>
                                <img data-imgbigurl="<?= base_url('storage/products/' . esc($image)) ?>"
                                    src="<?= base_url('storage/products/' . esc($image)) ?>" alt="">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <img data-imgbigurl="https://placehold.co/300x200"
                                src="https://placehold.co/300x200" alt="No Image Available">
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-6">
                <?= form_open(route_to('add_cart', $product['id']),  ['method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'product__details__text']) ?>
                <?= csrf_field() ?>
                <input type="hidden" value="<?= esc($product['id']) ?>" name="idproduct" id="idproduct">
                <h3><?= esc($product['name']) ?></h3>
                <div class="product__details__rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                    <span>(18 reviews)</span>
                </div>
                <div class="product__details__price"><?= esc(rp($product['price'])) ?></div>
                <p><?= esc($product['description']) ?></p>
                <div class="product__details__quantity">
                    <div class="quantity">
                        <div class="pro-qty">
                            <input type="text" name="quantity" value="1" min="1">
                        </div>
                    </div>
                </div>
                <button type="submit" class="primary-btn border-0">ADD TO CARD</button>
                <ul>
                    <li><b>Tersedia</b> <span><?= $product['stocks'] ?> <?= ' Item' ?></span></li>
                    <li><b>Promo</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                    <li><b>Kategori</b> <span><?= $product['category_name'] ?></span></li>
                    <li><b>Bagikan</b>
                        <div class="share">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </li>
                </ul>
                <?= form_close() ?>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                aria-selected="false">Reviews <span>(1)</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                    suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                    vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                    accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                    pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                    elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                    et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                    vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                                <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                    elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                    porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                    nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                    Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                    porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                    sed sit amet dui. Proin eget tortor risus.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                                <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                    ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                    elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                    porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                    nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>