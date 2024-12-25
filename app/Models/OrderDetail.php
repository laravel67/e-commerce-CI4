<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetail extends Model
{
    protected $table            = 'order_details';
    protected $allowedFields    = ['id_order', 'id_product', 'quantity', 'subtotal'];
}
