<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_Model extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['product_name', 'product_price', 'product_image', 'active'];
    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

    public function getProduct()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('product p');
        $builder->select('p.*, m.media_path');
        $builder->join('media m', 'm.media_id = p.product_image','left');
        $builder->orderBy('p.product_id', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
