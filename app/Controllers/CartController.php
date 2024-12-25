<?php

namespace App\Controllers;

use App\Models\Cart;
use App\Models\User;
use Config\Services;
use App\Models\Product;
use App\Controllers\BaseController;

class CartController extends BaseController
{
    protected $cart;
    protected $product;
    protected $user;
    protected $sessionId;

    public function __construct()
    {
        $this->sessionId = Services::session();
        $this->cart = new Cart();
        $this->product = new Product();
        $this->user = new User();
    }

    public function index()
    {
        $userId = $this->sessionId->get('user_id');
        $products = $this->cart
            ->select('carts.*, products.name as product_name, products.price as product_price, products.image as product_image')
            ->join('products', 'products.id = carts.product_id', 'left')
            ->where('user_id', $userId)
            ->get()
            ->getResult();
        $total = array_sum(array_map(function ($product) {
            return $product->product_price * $product->quantity;
        }, $products));
        $data  = [
            'title' => 'Daftar Belanja',
            'carts' => $products,
            'pager' => $this->cart->pager,
            'total' => $total,
        ];

        return view('pages/cart/index', $data);
    }

    public function addcart(int $id)
    {
        $userId = $this->sessionId->get('user_id');
        $quantity = (int) $this->request->getPost('quantity');
        if (empty($id) || $quantity <= 0) {
            session()->setFlashdata('error', 'Tentukan kuantitas produk yang ingin dibeli');
            return redirect()->to(base_url());
        }
        $product = $this->product->find($id);
        if (!$product) {
            session()->setFlashdata('error', 'Produk tidak ditemukan.');
            return redirect()->to(base_url());
        }
        if ($product['stocks'] < $quantity) {
            session()->setFlashdata('error', 'Stok tidak mencukupi.');
            return redirect()->to(base_url());
        }
        $subTotal = $product['price'] * $quantity;
        $cart = $this->cart->where('user_id', $userId)
            ->where('product_id', $id)
            ->first();

        if ($cart) {
            $newQuantity = $cart['quantity'] + $quantity;
            $newSubTotal = $product['price'] * $newQuantity;
            $cartData = [
                'quantity'  => $newQuantity,
                'subtotal'  => $newSubTotal
            ];
            if ($this->cart->update($cart['id'], $cartData)) {
                session()->setFlashdata('success', 'Keranjang berhasil diperbarui!');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui keranjang.');
            }
        } else {
            $cartData = [
                'user_id'   => $userId,
                'product_id' => $id,
                'quantity'  => $quantity,
                'subtotal'  => $subTotal
            ];
            if ($this->cart->save($cartData)) {
                session()->setFlashdata('success', 'Produk berhasil ditambah ke keranjang!');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan produk ke keranjang.');
            }
        }

        return redirect()->to(base_url());
    }

    public function upateCart(int $id)
    {
        $quantity = $this->request->getPost('quantity');
        if (!is_numeric($quantity) || $quantity <= 0) {
            return redirect()->back()->with('error', 'Jumlah harus berupa angka positif.');
        }
        $cart = $this->cart->find($id);
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
        }
        $product = $this->product->find($cart['product_id']);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }
        $productPrice = $product['price'];
        $subtotal = $productPrice * $quantity;
        $cartUpdate = [
            'id'       => $id,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ];
        if ($this->cart->save($cartUpdate)) {
            return redirect()->to('/carts')->with('success', 'Keranjang berhasil diperbarui!');
        } else {
            return redirect()->to('/carts')->with('error', 'Keranjang gagal diperbarui!');
        }
    }

    public function destroy(int $id)
    {
        $cart = $this->cart->where('id', $id)->first();
        if (!$cart) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
        if ($this->cart->delete($cart['id'])) {
            return redirect()->to('/carts')->with('success', 'Produk berhasil dihapus dari daftar belanja !');
        } else {
            return redirect()->back()->with('error', 'Produk gagal dihapus!');
        }
    }
}
