<?php

namespace App\Models;

use CodeIgniter\Model;

class Cart extends Model
{
    protected $table         = 'carts';
    protected $allowedFields = ['user_id', 'product_id', 'quantity', 'subtotal'];

    public function countCart() {
        $this->count;
    }
}
