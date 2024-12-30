<?php

namespace App\Controllers;

use Config\Services;
use App\Models\Product;
use CodeIgniter\HTTP\Request;
use App\Controllers\BaseController;
use App\Models\Category;

class AdminProductController extends BaseController
{
    protected $product;
    protected $category;
    protected $validation;

    public function __construct()
    {
        $this->product      = new Product();
        $this->category     = new Category();
        $this->validation   = Services::validation();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $this->product->select('products.*, categories.name as category')->join('categories', 'categories.id=products.category_id', 'left');
        if ($search) {
            $products = $this->product->like('products.name', $search)->paginate(10);
        } else {
            $products = $this->product->orderBy('products.id', 'desc')->paginate(10);
        }
        $data = [
            'title' => 'Kelola Produk',
            'products' => $products,
            'pager' => $this->product->pager,
        ];
        return view('pages/admin/product/index', $data);
    }

    public function create()
    {
        $categoriesData = $this->category->orderBy('id', 'desc')->get()->getResultArray();
        $categories = array_column($categoriesData, 'name', 'id');
        $data = [
            'title'         => 'Tambah Produk',
            'action' => route_to('product_store'),
            'categories'    => $categories,
        ];
        return view('pages/admin/product/create', $data);
    }

    public function show($id)
    {
        // Display the specified resource
    }

    public function store()
    {
        // dd($this->request);
        $this->validation->setRules([
            'title'         => 'required|max_length[255]|is_unique[products.name]',
            'slug'          => 'required|max_length[255]|is_unique[products.slug]',
            'category_id'   => 'required',
            'price'         => 'required|numeric',
            'stocks'        => 'required|numeric',
            'description'   => 'required|min_length[10]',
            'images'        => 'permit_empty|max_count[4]',
            'images.*'      => 'uploaded[images]|is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png]|max_size[images,2048]',
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $files = $this->request->getFiles('images');
        $imagesArray = $files['images'] ?? [];
        if (count($imagesArray) > 5) {
            $this->validation->setError('images', 'Jumlah gambar yang diupload tidak boleh lebih dari 5.');
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        // $imageName = null;
        // $image = $this->request->getFile('image');
        // if ($image && $image->isValid()) {
        //     $imageName = $image->getRandomName();
        //     $image->move('storage/products', $imageName);
        // }
        $uploadedImages = [];
        if ($files) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // $imageName = $file->getRandomName();
                    $imageName = substr(bin2hex(random_bytes(4)), 0, 10) . '.' . $file->getClientExtension();
                    $file->move('storage/products', $imageName);
                    $uploadedImages[] = $imageName;
                }
            }
        }

        $product = [
            'name'          => $this->request->getPost('title'),
            'slug'          => $this->request->getPost('slug'),
            'category_id'   => $this->request->getPost('category_id'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'stocks'        => $this->request->getPost('stocks'),
            'image'         => json_encode($uploadedImages)
        ];

        if ($this->product->save($product)) {
            session()->setFlashdata('success', 'Produk berhasil disimpan!');
            return redirect()->to(route_to('product_index'));
        } else {
            session()->setFlashdata('error', 'Kategori gagal disimpan');
            return redirect()->to(route_to('product_create'));
        }
    }

    public function edit(string $slug)
    {
        $product = $this->product->where('slug', $slug)->first();
        $categoriesData = $this->category->orderBy('id', 'desc')->get()->getResultArray();
        $categories = array_column($categoriesData, 'name', 'id');
        $data = [
            'title'         => 'Ubah Produk',
            'action' => route_to('product_update', esc($product['slug'])),
            'categories'    => $categories,
            'product'       => $product,
        ];
        return view('pages/admin/product/edit', $data);
    }

    public function update(string $slug)
    {
        $product = $this->product->where('slug', $slug)->first();
        if (!$product) {
            session()->setFlashdata('error', 'Produk tidak ditemukan');
            return redirect()->to(route_to('product_index'));
        }
        $this->validation->setRules([
            'title'             => 'required|min_length[3]|max_length[255]|is_unique[products.name,id,' . $product['id'] . ']',
            'slug'              => 'required|min_length[3]|max_length[255]|is_unique[products.slug,id,' . $product['id'] . ']',
            'category_id'       => 'required',
            'price'             => 'required|numeric',
            'stocks'            => 'required|numeric',
            'description'       => 'required|min_length[10]',
            'images'            => 'permit_empty|max_count[4]',
            'images.*'          => 'is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png]|max_size[images,2048]',
        ]);
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $files = $this->request->getFiles('images');
        $imagesArray = $files['images'] ?? [];
        if (count($imagesArray) > 5) {
            $this->validation->setError('images', 'Jumlah gambar yang diupload tidak boleh lebih dari 5.');
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        $existingImages = json_decode($product['image'], true) ?? [];
        $uploadedImages = [];

        if ($files) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    foreach ($existingImages as $existingImage) {
                        $imagePath = 'storage/products/' . $existingImage;
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                    $imageName = substr(bin2hex(random_bytes(4)), 0, 10) . '.' . $file->getClientExtension();
                    $file->move('storage/products', $imageName);
                    $uploadedImages[] = $imageName;
                }
            }
        }
        $images = !empty($uploadedImages) ? json_encode($uploadedImages) : ($existingImages ? json_encode($existingImages) : null);
        $updateProduct = [
            'id'            => $product['id'],
            'name'          => $this->request->getPost('title'),
            'slug'          => $this->request->getPost('slug'),
            'category_id'   => $this->request->getPost('category_id'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'stocks'        => $this->request->getPost('stocks'),
            'image'         => $images
        ];
        if ($this->product->save($updateProduct)) {
            session()->setFlashdata('success', 'Produk berhasil diubah!');
            return redirect()->to(route_to('product_index'));
        } else {
            session()->setFlashdata('error', 'Produk gagal diubah');
            return redirect()->to(route_to('product_edit', $slug));
        }
    }



    public function destroy(string $slug)
    {
        $product = $this->product->where('slug', $slug)->first();
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
        $existingImages = json_decode($product['image'], true) ?? [];
        if ($this->product->delete($product['id'])) {
            foreach ($existingImages as $existingImage) {
                $imagePath = 'storage/products/' . $existingImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            if (!empty($product['image']) && file_exists('storage/products/' . $product['image'])) {
                unlink('storage/products/' . $product['image']);
            }
            return redirect()->to(route_to('product_index'))->with('success', 'Produk berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Produk gagal dihapus!');
        }
    }
}
