<?php if (session()->getFlashdata('success')) : ?>
    <script>
        swal({
            title: "Succesfuly!",
            text: "<?= session()->getFlashdata('success'); ?>",
            icon: "success",
        });
    </script>
<?php elseif (session()->getFlashdata('errors')) : ?>
    <script>
        swal({
            title: "Oops!",
            text: "<?= session()->getFlashdata('errors'); ?>",
            icon: "error",
        });
    </script>
<?php endif; ?>