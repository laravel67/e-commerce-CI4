<?= $this->include('components/clients/header') ?>
<?= $this->include('layouts/mobile/sidebar') ?>
<?= $this->include('layouts/desktop/header') ?>
<?= searching('/') ?>
<?php if ($_SERVER['REQUEST_URI'] == '/'): ?>
    <section class="hero">
        <div class="container">
            <div class="row">
                <!-- <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Kategori</span>
                        </div>
                        <ul>
                            <li><a href="#">Fresh Meat</a></li>
                        </ul>
                    </div>
                </div> -->
                <div class="col-lg-12">
                    <div class="hero__item set-bg" data-setbg="<?= base_url('img/hero/banner.jpg') ?>">
                        <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<section class="featured spad">
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>
</section>
<?= $this->include('layouts/mobile/_navigation') ?>
<?= $this->include('components/clients/footer') ?>