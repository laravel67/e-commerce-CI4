<?php

use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\MyOrderController;
use App\Controllers\CheckoutController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\AdminUserController;
use App\Controllers\AdminOrderController;
use App\Controllers\AdminProductController;
use App\Controllers\AdminCategoryController;
use App\Controllers\DashboardController;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', [HomeController::class, 'index']);
$routes->get('product/(:any)', [HomeController::class, 'show']);

$routes->group('carts', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', [CartController::class, 'index']);
    $routes->post('add/(:num)', [CartController::class, 'addcart'], ['as' => 'add_cart']);
    $routes->post('update/(:num)', [CartController::class, 'upateCart'], ['as' => 'update_cart']);
    $routes->delete('delete/(:num)', [CartController::class, 'destroy']);
});

$routes->group('checkout', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', [CheckoutController::class, 'index']);
    $routes->post('store', [CheckoutController::class, 'store']);
    $routes->get('payment', [CheckoutController::class, 'payment']);
    $routes->get('paid/(:any)', [CheckoutController::class, 'paid']);
});

$routes->group('profile', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', [UserController::class, 'index']);
    $routes->get('edit', [UserController::class, 'edit']);
    $routes->post('update', [UserController::class, 'update']);
    $routes->get('update-password', [UserController::class, 'updatePassword']);
    $routes->post('update-password', [UserController::class, 'updatePassword']);
});

$routes->group('myorders', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', [MyOrderController::class, 'index']);
    $routes->get('detail/(:any)', [MyOrderController::class, 'detail']);
});

$routes->get('/register', [AuthController::class, 'showFormRegister'], ['filter' => 'guest']);
$routes->post('/register', [AuthController::class, 'register']);
$routes->get('/login', [AuthController::class, 'showFormLogin'], ['filter' => 'guest']);
$routes->post('/login', [AuthController::class, 'login']);
$routes->post('/logout', [AuthController::class, 'logout'], ['filter' => 'auth']);


$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', function () {
        return redirect()->to(route_to('admin_dashboard'));
    });
    $routes->get('admin', [DashboardController::class, 'dashboard'], ['as' => 'admin_dashboard']);
    $routes->group('categories', function ($routes) {
        $routes->get('/', [AdminCategoryController::class, 'index'], ['as' => 'category_index']);
        $routes->get('create', [AdminCategoryController::class, 'create'], ['as' => 'category_create']);
        $routes->post('store', [AdminCategoryController::class, 'store'], ['as' => 'category_store']);
        $routes->get('edit/(:segment)', [AdminCategoryController::class, 'edit'], ['as' => 'category_edit']);
        $routes->post('update/(:segment)', [AdminCategoryController::class, 'update'], ['as' => 'category_update']);
        $routes->delete('delete/(:segment)', [AdminCategoryController::class, 'destroy'], ['as' => 'category_delete']);
    });

    $routes->group('products', function ($routes) {
        $routes->get('/', [AdminProductController::class, 'index'], ['as' => 'product_index']);
        $routes->get('create', [AdminProductController::class, 'create'], ['as' => 'product_create']);
        $routes->post('store', [AdminProductController::class, 'store'], ['as' => 'product_store']);
        $routes->get('edit/(:segment)', [AdminProductController::class, 'edit'], ['as' => 'product_edit']);
        $routes->post('update/(:segment)', [AdminProductController::class, 'update'], ['as' => 'product_update']);
        $routes->delete('delete/(:segment)', [AdminProductController::class, 'destroy'], ['as' => 'product_delete']);
    });

    $routes->group('users', function ($routes) {
        $routes->get('/', [AdminUserController::class, 'index'], ['as' => 'user_index']);
        $routes->get('create', [AdminUserController::class, 'create'], ['as' => 'user_create']);
        $routes->post('store', [AdminUserController::class, 'store'], ['as' => 'user_store']);
        $routes->get('edit/(:segment)', [AdminUserController::class, 'edit'], ['as' => 'user_edit']);
        $routes->post('update/(:segment)', [AdminUserController::class, 'update'], ['as' => 'user_update']);
        $routes->delete('delete/(:segment)', [AdminUserController::class, 'destroy'], ['as' => 'user_delete']);
    });

    $routes->group('orders', function ($routes) {
        $routes->get('/', [AdminOrderController::class, 'index'], ['as' => 'order_index']);
        $routes->get('send/(:num)', [AdminOrderController::class, 'send'], ['as' => 'order_send']);
        $routes->get('detail/(:any)', [AdminOrderController::class, 'show'], ['as' => 'order_detail']);
        // Uncomment these lines if needed in the future
        // $routes->get('create', [AdminOrderController::class, 'create'], ['as' => 'order_create']);
        // $routes->post('store', [AdminOrderController::class, 'store'], ['as' => 'order_store']);
        // $routes->get('edit/(:segment)', [AdminOrderController::class, 'edit'], ['as' => 'order_edit']);
        // $routes->post('update/(:segment)', [AdminOrderController::class, 'update'], ['as' => 'order_update']);
        // $routes->delete('delete/(:segment)', [AdminOrderController::class, 'destroy'], ['as' => 'order_delete']);
    });
});
