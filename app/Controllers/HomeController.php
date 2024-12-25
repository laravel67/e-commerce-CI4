<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends BaseController
{
    protected $product;
    protected $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }
    public function index(): string
    {
        $search     = $this->request->getGet('search');
        $short      = $this->request->getGet('short');
        $category   = $this->request->getGet('category');
        $categories = $this->category->findAll();
        $this->product->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id=products.category_id', 'left');
        if ($category) {
            $this->product->where('categories.slug', $category);
        }
        if ($search) {
            $this->product->like('products.name', $search);
        }
        if ($short == 'termurah') {
            $this->product->orderBy('products.price', 'asc');
        } elseif ($short == 'termahal') {
            $this->product->orderBy('products.price', 'desc');
        } else {
            $this->product->orderBy('products.id', 'desc');
        }
        $products = $this->product->paginate(6);
        $data = [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $category,
            'pager' => $this->product->pager,
        ];
        return view('pages/home/index', $data);
    }

    public function show(string $slug)
    {
        $product = $this->product
            ->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.slug', $slug)
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk tidak ditemukan.");
        }

        $data = [
            'product' => $product,
        ];

        return view('pages/home/show', $data);
    }
}
