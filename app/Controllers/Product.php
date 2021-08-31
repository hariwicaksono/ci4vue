<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Product_Model;

class Product extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\Product_Model';

    public function index()
    {
        echo view('product_view');
    }
    public function getProduct()
    {
        return $this->respond(["status" => true, "message" => "berhasil mendapatkan semua data", "data" => $this->model->findAll()], 200);
    }
    public function save()
    {
        $json = $this->request->getJSON();
        $data = [
            'product_name' => $json->product_name,
            'product_price' => $json->product_price
        ];
        // var_dump($data);
        // die;
        $this->model->insert($data);
    }
    public function update($id = null)
    {
        $json = $this->request->getJSON();
        $data = [
            'product_name' => $json->product_name,
            'product_price' => $json->product_price
        ];
        $this->model->update($id, $data);
    }
    public function delete($id = null)
    {
        $this->model->delete($id);
    }
}
