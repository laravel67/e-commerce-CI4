    <?php if (auth()): ?>
        <?= logout() ?>
    <?php endif; ?>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/chart.js/Chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/progressbar.js/progressbar.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/jvectormap/jquery-jvectormap.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/owl-carousel-2/owl.carousel.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('assets/js/misc.js') ?>"></script>
    <script src="<?= base_url('assets/js/settings.js') ?>"></script>
    <script src="<?= base_url('assets/js/todolist.js') ?>"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('js/slug.js') ?>"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?= $this->include('components/flash') ?>
    </body>

    </html>