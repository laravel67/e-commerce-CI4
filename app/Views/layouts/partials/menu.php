<?= linka(href: route_to('admin_dashboard'), active: 'admin', icon: 'speedometer', label: 'Dashboard') ?>
<?= linka(href: route_to('product_index'), active: 'dashboard/products', icon: 'shopping', label: 'Produk') ?>
<?= linka(href: route_to('category_index'), active: 'dashboard/categories', icon: 'tag', label: 'Kategori') ?>
<?= linka(href: route_to('order_index'), active: 'dashboard/orders', icon: 'cart', label: 'Pesanan') ?>
<?= linka(href: route_to('user_index'), active: 'dashboard/users', icon: 'account-group', label: 'Member') ?>
