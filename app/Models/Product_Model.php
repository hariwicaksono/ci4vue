<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_Model extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $allowedFields = ['product_name', 'product_price'];
}
