<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

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
    public function create()
    {
        $validation =  \Config\Services::validation();

        if($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'product_name' => $json->product_name,
                'product_price' => $json->product_price
            ];
        } else {
            $data = [
                'product_name' => $this->request->getPost('product_name'),
                'product_price' => $this->request->getPost('product_price')
            ];
        }

        if($validation->run($data, 'product') == FALSE){
            $response = [
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $simpan = $this->model->insert($data);
            if($simpan){
                $response = [
                    'status' => true,
                    'message' => 'Created product successfully',
                    'data' => [],
                ];
                return $this->respond($response, 200);
            }
        } 
        
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
