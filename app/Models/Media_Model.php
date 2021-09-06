<?php

namespace App\Models;

use CodeIgniter\Model;

class Media_Model extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'media_id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['media_path'];
    //protected $validationRules    = [];
    //protected $validationMessages = [];
    //protected $skipValidation     = false;

}
