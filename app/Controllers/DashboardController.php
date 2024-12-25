<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        return redirect()->to(route_to('admin_dashboard'));
    }
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('pages/admin/index', $data);
    }
}
