<?php

namespace App\Controllers;

use App\Models\User;
use Config\Services;
use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $user;
    protected $userId;
    protected $sessionId;
    protected $validation;

    public function __construct()
    {
        $this->sessionId    = Services::session();
        $this->validation = Services::validation();
        $this->user         = new User();
        $this->userId = $this->sessionId->get('user_id');
    }

    public function index()
    {
        $user = $this->user->where('id', $this->userId)->first();
        $data = [
            'title' => 'Profile',
            'user'  => $user
        ];
        return view('/pages/profile/index', $data);
    }

    public function edit()
    {
        $user = $this->user->where('id', $this->userId)->first();
        $data = [
            'title' => 'Ubah Profile',
            'user'  => $user,
            'action' => base_url('/profile/update')
        ];
        return view('/pages/profile/edit', $data);
    }

    public function update()
    {
        $user = $this->user->where('id', $this->userId)->first();
        $this->validation->setRules([
            'name'          => 'required|max_length[255]',
            'email'         => 'required|min_length[3]|max_length[255]|is_unique[users.email,id,' . $user['id'] . ']',
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
            'image'     => $imageName
        ];
        if ($this->user->save($updateUser)) {
            session()->setFlashdata('success', 'Profile berhasil diubah!');
            return redirect()->to('profile');
        } else {
            session()->setFlashdata('error', 'Profile gagal diubah');
            return redirect()->to('profile/edit');
        }
    }

    public function updatePassword()
    {
        $user = $this->user->where('id', $this->userId)->first();
        $data = [
            'title' => 'Ubah Kata Sandi',
            'user'  => $user,
            'action' => base_url('profile/update-password')
        ];
        if ($this->request->getMethod() === 'POST') {
            $this->validation->setRules([
                'oldpassword' => 'required|min_length[8]',
                'newpassword' => 'required|min_length[8]|differs[oldpassword]',
                'password_confirmed' => 'required|matches[newpassword]',
            ]);

            if (!$this->validation->withRequest($this->request)->run()) {
                return redirect()->to(base_url('profile/update-password'))->withInput()->with('errors', $this->validation->getErrors());
            }
            $oldPassword = $this->request->getPost('oldpassword');
            $newPassword = $this->request->getPost('newpassword');
            if (!password_verify($oldPassword, $user['password'])) {
                return redirect()->to(base_url('profile/update-password'))->with('errors', ['oldpassword' => 'Kata sandi lama tidak sesuai'])->withInput();
            }
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->user->update($this->userId, ['password' => $newPasswordHash]);
            return redirect()->to(base_url('profile'))->with('success', 'Kata sandi berhasil diubah.');
        } else {
            return view('pages/profile/update_password', $data);
        }
    }
}
