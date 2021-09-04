<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ImageUpload extends ResourceController
{
    protected $format       = 'json';

	public function create()
    {
        $gambar = $this->request->getFile('foto');
        $fileName = $gambar->getName();
        if ($gambar !== "") {
            $gambar->move('images/', $fileName);
            $response = [
                'status' => true,
                'message' => 'Berhasil upload gambar',
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal upload gambar',
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }
    
}