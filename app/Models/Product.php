<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table            = 'products';
    protected $allowedFields    = ['name', 'slug', 'category_id', 'description', 'price', 'image', 'stocks'];
}
