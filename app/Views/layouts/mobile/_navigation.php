<section class="mobile-navigation d-md-none">
    <div class="container-fluid">
        <div class="d-flex text-center">
            <div class="col">
                <a href="<?= base_url('/') ?>" class="nav-link open__menu">
                    <i class="fa fa-home"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="col">
                <a href="<?= base_url('/carts') ?>" class="nav-link active">
                    <span>
                        <i class="fa fa-shopping-cart position-relative" style="font-size: 20px;">
                            <?php if (auth()): ?>
                                <?php if (isset($cartCount) && $cartCount > 0): ?>
                                    <span class="mobile-cart-count">
                                        <?= $cartCount ?>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </i>
                    </span>
                    <span class="ms-2">Keranjang</span>
                </a>
            </div>
            <div class=" col">
                <a href="javascript:void(0)" class="nav-link open__menu">
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                </a>
            </div>
        </div>
    </div>
</section>