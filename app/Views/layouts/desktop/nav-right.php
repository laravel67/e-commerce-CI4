<div class="col-lg-4">
    <nav class="header__menu">
        <ul class="d-flex justify-content-end">
            <li>
                <a href="<?= base_url('/carts') ?>">
                    <i class="fa fa-shopping-cart"></i>
                    <?php if (auth()): ?>
                        <?php if ($cartCount > 0): ?>
                            <span style="height: 13px;width: 13px;color: #7fad39;background: #7fad39;font-size: 10px;color: #ffffff;line-height: 13px;text-align: center;font-weight: 700;display: inline-block;border-radius: 50%;position: absolute;top: 0;right: -12px;">
                                <?= $cartCount ?>
                            </span>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <button class="open-search btn">
                    <i class="fa fa-search"></i>
                </button>
            </li>
            <?php if (guest()): ?>
                <li class="mr-3">
                    <a href="<?= base_url('/login') ?>">
                        <i class="fa fa-user"></i> Masuk
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('/register') ?>">
                        <i class="fa fa-pencil"></i> Daftar
                    </a>
                </li>
            <?php else: ?>
                <?php $user = auth(); ?>
                <li><a href="#"><i class="fa fa-user-circle"></i> <?= esc($user['name']) ?></a>
                    <ul class="header__menu__dropdown">
                        <?php if (can('admin')): ?>
                            <li><a href="<?= route_to('admin_dashboard') ?>">Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="<?= base_url('/profile') ?>">Profile</a></li>
                        <li><a href="<?= base_url('/myorders') ?>">Pesanan</a></li>
                        <li><a href="<?= base_url('/users') ?>">Keluar</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>