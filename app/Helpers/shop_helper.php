<?php

use App\Models\User;
use Config\Services;

if (!function_exists('no')) {
    function no($pager, $index)
    {
        $currentPage = $pager->getCurrentPage(); // Nomor halaman saat ini
        $perPage = $pager->getPerPage(); // Jumlah item per halaman
        $offset = ($currentPage - 1) * $perPage; // Hitung offset

        return $offset + $index + 1;
    }
}

if (!function_exists('searching')) {
    function searching($url)
    {
        return '
        <form class="form-search d-none" method="GET" action="' . esc(base_url($url)) . '">
            <div class="container h-100 d-flex justify-content-center align-items-center">
                <div class="search-content input-group">
                    <input type="search" class="form-control rounded-0" name="search" id="search" placeholder="Pencarian..." value="' . (isset($_GET['search']) ? esc($_GET['search']) : '') . '">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text rounded-0 btn-search">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        ';
    }
}

if (!function_exists('search')) {
    function search($url)
    {
        return '
        <form class="input-group flex-nowrap" method="GET" action="' . esc(base_url($url)) . '">
            <input type="search" class="form-control form-control-sm" name="search" id="search" placeholder="Cari..." value="' . (isset($_GET['search']) ? esc($_GET['search']) : '') . '">
            <div class="input-group-prepend">
                <button type="submit" class="btn rounded-0 border-0 text-success btn-sm">
                    <i class="mdi mdi-magnify"></i>
                </button>
            </div>
        </form>
        ';
    }
}

if (!function_exists('rp')) {
    /**
     * Format angka menjadi format Rupiah
     *
     * @param int|float $amount Jumlah angka yang akan diformat
     * @return string Format Rupiah (contoh: Rp 1.000.000)
     */
    function rp($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('str_limit')) {
    function str_limit(string $value, int $limit = 100, string $end = '...'): string
    {
        return mb_strlen($value) > $limit ? mb_substr($value, 0, $limit) . $end : $value;
    }
}

if (!function_exists('card_product')) {
    function card_product(
        string $idProduct = '',
        string $name = '',
        int $price = 0,
        string $img = null,
        string $category = '',
        int $count = 0,
        string $urlCategory = '#',
        string $urlShow = '#'
    ): string {
        // Base URL for product images
        $imgUrl = !empty($img)
            ? base_url('storage/products/' . $img)
            : 'https://placehold.co/565x600';
        $action = route_to('add_cart', $idProduct);

        // Card HTML structure
        return '
        <div class="col-lg-3 col-md-4 col-sm-6 mix ' . esc($category) . ' fastfood">
            <div class="featured__item">
                <div class="featured__item__pic set-bg" data-setbg="' . esc($imgUrl) . '">
                    <ul class="featured__item__pic__hover">
                        <li><a href="' . esc($urlShow) . '"><i class="fa fa-eye"></i></a></li>
                        <li>
                            ' . form_open(esc($action), ['method' => 'POST', 'enctype' => 'multipart/form-data']) . '
                                ' . csrf_field() . '
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn-add-cart" type="submit"><i class="fa fa-shopping-cart"></i></button>
                            ' . form_close() . '
                        </li>
                    </ul>
                </div>
                <div class="featured__item__text">
                    <h6><a href="' . esc($urlShow) . '">' . esc($name) . '</a></h6>
                    <h5>' . esc(rp($price)) . '</h5>
                </div>
            </div>
        </div>';
    }
}

if (!function_exists('modal_show')) {
    function modal_show(
        string $idProduct = '',
        string $name = '',
        int $price = 0,
        string $img = null,
        string $category = '',
        int $count = 0,
        string $description = ''
    ): string {
        $imgUrl = !empty($img)
            ? base_url('storage/products/' . $img)
            : 'https://placehold.co/420x400';
        return '
            <div class="modal fade" id="show-' . $idProduct . '" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                        <img src="' . esc($imgUrl) . '" alt="' . esc($name) . '" class="card-img-top" />
                                </div>
                                <div class="col-md-6">
                                    <h2 class="card-tite">' . esc($name) . '</h2>
                                    <p class="card-text mb-0">' . esc(rp($price)) . '</p>
                                    <p class="card-text mb-0">' . esc(str_limit($description, 25, '...')) . '</p>
                                    <span href="" class="badge badge-primary"><i class="fas fa-tag"></i> ' . esc($category) . '</span>
                                    <span class="badge badge-success badge-pill">Tersisa ' . esc($count) . ' Item</span>
                                    <form class=" my-4 input-group flex-nowrap">
                                        <input type="search" class="form-control" name="search" id="search">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-primary" id="addon-wrapping">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    };
}

if (!function_exists('add_cart')) {
    /**
     * Generate HTML for adding product to cart
     *
     * @param int $id Product ID
     * @param int $quantity Default quantity
     * @return string HTML for the add-to-cart form
     */
    function add_cart(
        int $id = null,
    ): string {
        $action = base_url('/carts/add');
        $id = esc($id);
        return  form_open($action, ['method' => 'POST']) . '
        ' . csrf_field() . '
        <div class="input-group flex-nowrap">
            <input type="hidden" value="' . $id . '" name="idproduct" id="idproduct">
            <input type="number" class="form-control" name="quantity" id="quantity" value="0">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-primary" id="addon-wrapping">
                    <i class="fas fa-cart-plus"></i>
                </button>
             </div>
        </div>' . form_close();
    }
}

if (!function_exists('can')) {
    function can($role)
    {
        $session = Services::session();
        $userId = $session->get('user_id');
        if (!$userId) {
            return false;
        }

        // Memuat model User
        $userModel = new User();
        $user = $userModel->find($userId);
        if ($user && $user['role'] === $role) {
            return true;
        }
        return false;
    }
}

if (!function_exists('guest')) {
    function guest()
    {
        $session = Services::session();
        return !$session->get('user_id');
    }
}

if (!function_exists('auth')) {
    function auth()
    {
        $session = Services::session();
        $userId = $session->get('user_id');
        if (!$userId) {
            return false;
        }

        $userModel = new User();
        return $userModel->find($userId) ?: false;
    }
}

if (!function_exists('dateID')) {
    /**
     * Format tanggal ke format Indonesia
     *
     * @param string $date Tanggal dalam format Y-m-d atau Y-m-d H:i:s
     * @param bool $includeTime Apakah waktu harus disertakan (opsional)
     * @return string Tanggal dalam format Indonesia
     */
    function dateID($date, $includeTime = false)
    {
        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $timestamp = strtotime($date);
        $day = date('d', $timestamp);
        $month = (int)date('m', $timestamp);
        $year = date('Y', $timestamp);

        $formattedDate = $day . ' ' . $bulan[$month] . ' ' . $year;

        if ($includeTime) {
            $time = date('H:i:s', $timestamp);
            $formattedDate .= ' ' . $time;
        }

        return $formattedDate;
    }
}

if (!function_exists('linka')) {
    /**
     * Membuat link menu dengan status aktif
     *
     * @param string $href URL tujuan (misalnya 'users.index')
     * @param string $active Bagian URL yang digunakan untuk menandai status aktif
     * @param string $icon Ikon untuk link (optional)
     * @param string $label Label yang akan ditampilkan untuk link
     * @param string $classActive Kelas CSS untuk status aktif (default: 'active')
     * @return string HTML untuk link menu
     */
    function linka(
        string $href = '#',
        string $active = '',
        string $icon = '',
        string $label = '',
        string $classActive = 'active',
    ) {
        $isActive = strpos(uri_string(), $active) === 0 ? $classActive : '';
        return '
        <li class="nav-item menu-items ' . $isActive . ' ">
            <a class="nav-link" href="' . $href . '">
                <span class="menu-icon">
                    <i class="mdi mdi-' . $icon . '"></i>
                </span>
                <span class="menu-title">' . $label . '</span>
            </a>
        </li>
        ';
    };
}

if (!function_exists('btn_delete')) {
    function btn_delete(
        string $action = '',
        // string $title = '',
        string $categoryName = ''
    ): string {
        $attributesStr = '';

        return '
        <form action="' . $action . '" method="post" class="d-inline">
            ' . csrf_field() . '
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" class="dropdown-item text-danger" onclick="deleteConfirmed(this, \'' . $categoryName . '\')">
                Hapus
            </button>
        </form>
        <script>
            function deleteConfirmed(button, categoryName) {
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Data " + categoryName + " akan dihapus secara permanen.",
                    icon: "warning",
                    buttons: ["Batal", "Hapus"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        button.closest("form").submit();
                    }
                });
            }
        </script>';
    }
}

if (!function_exists('logout')) {
    function logout()
    {
        return form_open(base_url('/logout'), ['id' => 'logout-form', 'method' => 'POST'])
            . csrf_field()
            . form_close();
    }
}
