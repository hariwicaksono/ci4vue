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
                    'message' => 'Produk berhasil ditambahkan',
                    'data' => [],
                ];
                return $this->respond($response, 200);
            }
        } 
        
    }
    public function update($id = NULL)
{
    $validation =  \Config\Services::validation();
 
    // $name   = $this->request->getRawInput('category_name');
    // $status = $this->request->getRawInput('category_status');
 
    $data = $this->request->getRawInput();
 
    // $data = [
    //     'category_name' => $name,
    //     'category_status' => $status 
    // ];
 
    if($validation->run($data, 'product') == FALSE){
 
        $response = [                                                                                       
            'status' => false,
            'message' => 'Validasi gagal',
            'data' => $validation->getErrors(),
        ];
        return $this->respond($response, 200);
 
    } else {
 
        $simpan = $this->model->update($id,$data);
        if($simpan){
            $response = [
                'status' => true,
                'message' => 'Produk berhasil diperbarui',
                'data' => [],
            ];
            return $this->respond($response, 200);
        } 
         
    }
}
    public function delete($id = null)
    {
        $this->model->delete($id);
    }
}
