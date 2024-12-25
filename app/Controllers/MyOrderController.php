<?php

namespace App\Controllers;

use App\Models\User;
use Config\Services;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MyOrderController extends BaseController
{
    protected $user;
    protected $sessionId;
    protected $order;
    protected $orderDetail;

    public function __construct()
    {
        $this->sessionId    = Services::session();
        $this->user         = new User();
        $this->order       = new Order();
        $this->orderDetail  = new OrderDetail();
    }

    public function index()
    {
        $userId = $this->sessionId->get('user_id');
        $orders = $this->order->where('id_user', $userId)->orderBy('id', 'desc')->get()->getResult();
        $data = [
            'title' => 'Daftar Pesanan',
            'orders'  => $orders
        ];
        return view('/pages/order/index', $data);
    }

    public function detail(string $inv)
    {
        $order = $this->order->where('invoice', $inv)->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $details = $this->orderDetail
            ->select('order_details.*, products.name as product_name, products.price as product_price, products.image as product_image')
            ->join('products', 'products.id = order_details.id_product', 'left')
            ->where('id_order', $order['id'])
            ->findAll();

        $data = [
            'title'   => 'Detail Pesanan: ',
            'order'   => $order,
            'details' => $details,
        ];

        return view('/pages/order/detail', $data);
    }
}
