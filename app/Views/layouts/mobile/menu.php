<nav class="humberger__menu__nav mobile-menu">
    <ul>
        <li><a href="<?= base_url('/') ?>">Home</a></li>
        <?php if (auth()): ?>
            <li class="active"><a href="<?= base_url('/profile') ?>">Profile</a></li>
            <?php if (can('admin')): ?>
                <li><a href="<?= route_to('admin_dashboard') ?>">Dashboard</a></li>
            <?php endif; ?>
            <li>
                <a href="javascript:void(0)" onclick="logout()" class="text-danger">Keluar</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>