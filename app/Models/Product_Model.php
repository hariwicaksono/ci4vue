<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_Model extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['product_name', 'product_price', 'active'];
    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

    public function updateCategory($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['product_id' => $id]);
    }

}
