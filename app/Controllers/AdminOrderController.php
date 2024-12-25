<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\OrderDetail;

class AdminOrderController extends BaseController
{
    protected $order;
    protected $detail;

    public function __construct()
    {
        $this->order = new Order();
        $this->detail = new OrderDetail();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $orders = $search
            ? $this->order->like('orders.invoice', $search)->paginate(10)
            : $this->order->orderBy('orders.id', 'desc')->paginate(10);

        $data = [
            'title' => 'Kelola Pesanan',
            'orders' => $orders,
            'pager' => $this->order->pager,
        ];

        return view('pages/admin/orders/index', $data);
    }

    public function send(int $id)
    {
        $order = $this->order->where('id', $id)->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }
        $updateOrder = [
            'id' => $order['id'],
            'status' => 'delivered'
        ];
        $this->order->save($updateOrder);
        return redirect()->to(route_to('order_index'))->with('success', 'Proses pengiriman berhasil.');
    }


    public function create()
    {
        // Menampilkan form untuk membuat resource baru
    }

    public function show(string $inv)
    {
        $order = $this->order->where('invoice', $inv)->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $details = $this->detail
            ->select('order_details.*, products.name as product_name, products.price as product_price, products.image as product_image')
            ->join('products', 'products.id = order_details.id_product', 'left')
            ->where('id_order', $order['id'])
            ->findAll();

        $data = [
            'title'   => 'Detail Pesanan: ',
            'order'   => $order,
            'details' => $details,
        ];

        return view('/pages/admin/orders/show', $data);
    }

    public function store()
    {
        // Menyimpan resource baru ke database
    }

    public function edit($id)
    {
        // Menampilkan form untuk mengedit resource berdasarkan ID
    }

    public function update($id)
    {
        // Memperbarui resource berdasarkan ID
    }

    public function destroy($id)
    {
        // Menghapus resource berdasarkan ID
    }
}
