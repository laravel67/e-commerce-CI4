<?php

namespace App\Controllers;

use App\Models\User;
use Config\Services;
use App\Controllers\BaseController;

class AdminUserController extends BaseController
{
    protected $user;
    protected $validation;

    public function __construct()
    {
        $this->user = new User();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        if ($search) {
            $users = $this->user->like('name', $search)->paginate(10);
        } else {
            $users = $this->user->orderBy('id', 'desc')->paginate(10);
        }
        $data = [
            'title' => 'Daftar Pengguna',
            'users' => $users,
            'pager' => $this->user->pager,
        ];
        return view('pages/admin/user/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'action' => route_to('user_store'),
        ];
        return view('pages/admin/user/create', $data);
    }

    public function show()
    {
        // Display the specified resource
    }

    public function store()
    {
        $this->validation->setRules([
            'name'          => 'required|max_length[255]',
            'email'         => 'required|max_length[255]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[6]',
            'role'          => 'required',
            'status'        => 'required',
            'image'         => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
        ]);
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $imageName = '';

        $image = $this->request->getFile('image');
        if ($image && $image->isValid()) {
            $imageName = $image->getRandomName();
            $image->move('storage/users', $imageName);
        }

        $user = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('status'),
            'image'     => $imageName,
        ];
        if ($this->user->save($user)) {
            session()->setFlashdata('success', 'Pengguna baru berhasil disimpan!');
            return redirect()->to(route_to('user_index'));
        } else {
            session()->setFlashdata('error', 'Pengguna baru gagal disimpan');
            return redirect()->to(route_to('user_create'));
        }
    }

    public function edit(int $id)
    {
        $user = $this->user->where('id', $id)->first();
        $data = [
            'title'     => 'Edit Pengguna',
            'action'    => route_to('user_update', $user['id']),
            'user'      => $user
        ];
        return view('pages/admin/user/edit', $data);
    }

    public function update(int $id)
    {
        $user = $this->user->where('id', $id)->first();

        $this->validation->setRules([
            'name'          => 'required|max_length[255]',
            'email'         => 'required|min_length[3]|max_length[255]|is_unique[users.email,id,' . $user['id'] . ']',
            'role'          => 'required',
            'status'        => 'required',
            'image'         => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
        ]);

        $imageName = $user['image'] ?? null;

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if (!empty($user['image']) && file_exists('storage/users/' . $user['image'])) {
                unlink('storage/users/' . $user['image']);
            }
            $imageName = $image->getRandomName();
            $image->move('storage/users', $imageName);
        }

        $updateUser = [
            'id'        => $user['id'],
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('status'),
            'image'     => $imageName
        ];
        if ($this->user->save($updateUser)) {
            session()->setFlashdata('success', 'Pengguna berhasil diubah!');
            return redirect()->to(route_to('user_index'));
        } else {
            session()->setFlashdata('error', 'Pengguna gagal diubah');
            return redirect()->to(route_to('user_edit', $id));
        }
    }

    public function destroy(int $id)
    {
        $user = $this->user->where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }
        if ($this->user->delete($user['id'])) {
            if (!empty($user['image']) && file_exists('storage/users/' . $user['image'])) {
                unlink('storage/users/' . $user['image']);
            }
            return redirect()->to(route_to('user_index'))->with('success', 'Pengguna berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Pengguna gagal dihapus!');
        }
    }
}
