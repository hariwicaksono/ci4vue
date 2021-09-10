<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Media_Model;

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
        return $this->respond(["status" => true, "message" => "berhasil mendapatkan semua data", "data" => $this->model->getProduct()], 200);
    }
    public function create()
    {
        $validation =  \Config\Services::validation();

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'product_name' => $json->product_name,
                'product_price' => $json->product_price,
                'product_description' => $json->product_description,
                'product_image' => $json->product_image,
                'active' => 1
            ];
        } else {
            $data = [
                'product_name' => $this->request->getPost('product_name'),
                'product_price' => $this->request->getPost('product_price'),
                'product_description' => $this->request->getPost('product_description'),
                'product_image' => $this->request->getPost('product_image'),
                'active' => 1
            ];
        }

        if ($validation->run($data, 'product') == FALSE) {
            $response = [
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {
            $simpan = $this->model->insert($data);
            if ($simpan) {
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

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'product_name' => $json->product_name,
                'product_price' => $json->product_price,
                'product_description' => $json->product_description,
                'product_image' => $json->product_image,
            ];
        } else {
            $data = $this->request->getRawInput();
        }

        if ($validation->run($data, 'product') == FALSE) {

            $response = [
                'status' => false,
                'message' => 'Validasi gagal',
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 200);
        } else {

            $simpan = $this->model->update($id, $data);
            if ($simpan) {
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
        $hapus = $this->model->find($id);
        $media = new Media_Model();
        $gambar = $media->find($hapus['product_image']);
        if ($hapus) {
            if (empty($gambar)) {
                $this->model->delete($id);
            } else {
                $this->model->delete($id);
                $media->delete($gambar['media_id']);
                unlink($gambar['media_path']);
            }

            $response = [
                'status' => true,
                'message' => 'Produk berhasil dihapus',
                'data' => [],
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal menghapus',
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }

    public function setPrice($id = NULL)
    {

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'product_price' => $json->product_price,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'product_price' => $input['product_price']
            ];
        }

        if ($data > 0) {
            $this->model->update($id, $data);

            $response = [
                'status' => true,
                'message' => 'Berhasil memperbarui data',
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal memperbarui data',
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }

    public function setActive($id = NULL)
    {

        if ($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'active' => $json->active,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'active' => $input['active']
            ];
        }

        if ($data > 0) {
            $this->model->update($id, $data);

            $response = [
                'status' => true,
                'message' => 'Berhasil memperbarui data',
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal memperbarui data',
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }
}
